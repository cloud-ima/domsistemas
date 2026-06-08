<?php
/**
 * Pruebas de integridad entre domsistemas_Backup y domsistemas.
 *
 * Uso:
 *   php pruebas_integridad_bd.php
 *   php pruebas_integridad_bd.php --json
 *
 * La prueba es solo lectura. Lee las constantes DB_* desde conexion.php sin
 * incluirlo, para evitar efectos secundarios de conexión.
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$jsonOutput = in_array('--json', $argv ?? [], true);
$configPath = __DIR__ . DIRECTORY_SEPARATOR . 'conexion.php';
$config = file_get_contents($configPath);

function config_value(string $name, ?string $default = null): ?string
{
    global $config;

    $pattern = "/define\s*\(\s*['\"]" . preg_quote($name, '/') . "['\"]\s*,\s*['\"]([^'\"]*)['\"]\s*\)/";

    return preg_match($pattern, $config, $matches) ? $matches[1] : $default;
}

function quote_identifier(string $identifier): string
{
    return '`' . str_replace('`', '``', $identifier) . '`';
}

function fetch_rows(mysqli $connection, string $sql): array
{
    $rows = [];
    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

function fetch_one(mysqli $connection, string $sql): array
{
    $result = $connection->query($sql);

    return $result->fetch_assoc() ?: [];
}

function table_names(mysqli $connection, string $database): array
{
    $safeDatabase = $connection->real_escape_string($database);
    $rows = fetch_rows(
        $connection,
        "SELECT TABLE_NAME
         FROM INFORMATION_SCHEMA.TABLES
         WHERE TABLE_SCHEMA = '{$safeDatabase}'
           AND TABLE_TYPE = 'BASE TABLE'
         ORDER BY TABLE_NAME"
    );

    return array_map(static fn(array $row): string => $row['TABLE_NAME'], $rows);
}

function table_columns(mysqli $connection, string $database, string $table): array
{
    $safeDatabase = $connection->real_escape_string($database);
    $safeTable = $connection->real_escape_string($table);
    $columns = [];
    $rows = fetch_rows(
        $connection,
        "SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT,
                COLUMN_KEY, EXTRA, CHARACTER_SET_NAME, COLLATION_NAME
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = '{$safeDatabase}'
           AND TABLE_NAME = '{$safeTable}'
         ORDER BY ORDINAL_POSITION"
    );

    foreach ($rows as $row) {
        $columnName = $row['COLUMN_NAME'];
        unset($row['COLUMN_NAME']);
        $columns[$columnName] = $row;
    }

    return $columns;
}

function primary_key_columns(mysqli $connection, string $database, string $table): array
{
    $safeDatabase = $connection->real_escape_string($database);
    $safeTable = $connection->real_escape_string($table);
    $rows = fetch_rows(
        $connection,
        "SELECT COLUMN_NAME
         FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
         WHERE TABLE_SCHEMA = '{$safeDatabase}'
           AND TABLE_NAME = '{$safeTable}'
           AND CONSTRAINT_NAME = 'PRIMARY'
         ORDER BY ORDINAL_POSITION"
    );

    return array_map(static fn(array $row): string => $row['COLUMN_NAME'], $rows);
}

function count_table_rows(mysqli $connection, string $database, string $table): int
{
    $row = fetch_one(
        $connection,
        'SELECT COUNT(*) AS total FROM ' . quote_identifier($database) . '.' . quote_identifier($table)
    );

    return (int) $row['total'];
}

function exact_rows_missing(mysqli $connection, string $fromDatabase, string $toDatabase, string $table, array $columns): int
{
    if ($columns === []) {
        return 0;
    }

    $conditions = [];
    foreach ($columns as $column) {
        $quotedColumn = quote_identifier($column);
        $conditions[] = "target.{$quotedColumn} <=> source.{$quotedColumn}";
    }

    $sql = 'SELECT COUNT(*) AS total
            FROM ' . quote_identifier($fromDatabase) . '.' . quote_identifier($table) . ' source
            WHERE NOT EXISTS (
                SELECT 1
                FROM ' . quote_identifier($toDatabase) . '.' . quote_identifier($table) . ' target
                WHERE ' . implode(' AND ', $conditions) . '
            )';

    return (int) fetch_one($connection, $sql)['total'];
}

function database_schema(mysqli $connection, string $database): array
{
    $safeDatabase = $connection->real_escape_string($database);

    return fetch_one(
        $connection,
        "SELECT DEFAULT_CHARACTER_SET_NAME AS charset_name,
                DEFAULT_COLLATION_NAME AS collation_name
         FROM INFORMATION_SCHEMA.SCHEMATA
         WHERE SCHEMA_NAME = '{$safeDatabase}'"
    );
}

function add_test(array &$tests, string $id, string $status, array $detail = []): void
{
    $tests[] = [
        'id' => $id,
        'status' => $status,
        'detail' => $detail,
    ];
}

function print_human_report(array $report): void
{
    echo "Pruebas de integridad BD\n";
    echo "Fuente valida: {$report['source_of_truth']}\n";
    echo "Destino activo: {$report['destination']}\n";
    echo "Ejecutado: {$report['executed_at']}\n\n";

    echo "Resumen: {$report['summary']['pass']} PASS, {$report['summary']['fail']} FAIL, {$report['summary']['warn']} WARN\n\n";

    foreach ($report['tests'] as $test) {
        echo "[{$test['status']}] {$test['id']}\n";
    }

    $warnTests = array_values(array_filter($report['tests'], static fn(array $test): bool => $test['status'] === 'WARN'));
    $failTests = array_values(array_filter($report['tests'], static fn(array $test): bool => $test['status'] === 'FAIL'));

    if ($warnTests !== []) {
        echo "\nAdvertencias:\n";
        foreach ($warnTests as $test) {
            echo "- {$test['id']}: " . json_encode($test['detail'], JSON_UNESCAPED_UNICODE) . "\n";
        }
    }

    if ($failTests !== []) {
        echo "\nFallas:\n";
        foreach ($failTests as $test) {
            echo "- {$test['id']}: " . json_encode($test['detail'], JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
}

$sourceDatabase = 'domsistemas_Backup';
$destinationDatabase = config_value('DB_NAME');
$host = config_value('DB_HOST');
$user = config_value('DB_USER');
$password = config_value('DB_PASS');
$charset = config_value('DB_CHARSET', 'utf8mb4') ?: 'utf8mb4';

if ($host === null || $user === null || $password === null || $destinationDatabase === null) {
    fwrite(STDERR, "No se pudieron leer las constantes DB_* desde conexion.php.\n");
    exit(2);
}

$connection = new mysqli($host, $user, $password);
$connection->set_charset($charset);

$tests = [];
$sourceTables = table_names($connection, $sourceDatabase);
$destinationTables = table_names($connection, $destinationDatabase);
$onlySourceTables = array_values(array_diff($sourceTables, $destinationTables));
$onlyDestinationTables = array_values(array_diff($destinationTables, $sourceTables));

add_test($tests, 'T01_table_set', ($onlySourceTables === [] && $onlyDestinationTables === []) ? 'PASS' : 'FAIL', [
    'source_count' => count($sourceTables),
    'destination_count' => count($destinationTables),
    'only_source' => $onlySourceTables,
    'only_destination' => $onlyDestinationTables,
]);

$sourceSchema = database_schema($connection, $sourceDatabase);
$destinationSchema = database_schema($connection, $destinationDatabase);
add_test($tests, 'T02_schema_charset_collation', $sourceSchema === $destinationSchema ? 'PASS' : 'FAIL', [
    'source' => $sourceSchema,
    'destination' => $destinationSchema,
]);

$unexpectedStructureDifferences = [];
$allowedStructureDifferences = [];
$rowCountDeltas = [];
$sourceRowsMissingInDestination = [];
$destinationRowsNotInSource = [];
$sharedRowValueDifferences = [];
$noPrimaryKeyDifferences = [];

$commonTables = array_values(array_intersect($sourceTables, $destinationTables));

foreach ($commonTables as $table) {
    $sourceColumns = table_columns($connection, $sourceDatabase, $table);
    $destinationColumns = table_columns($connection, $destinationDatabase, $table);
    $onlySourceColumns = array_values(array_diff(array_keys($sourceColumns), array_keys($destinationColumns)));
    $onlyDestinationColumns = array_values(array_diff(array_keys($destinationColumns), array_keys($sourceColumns)));
    $changedColumns = [];

    foreach (array_intersect(array_keys($sourceColumns), array_keys($destinationColumns)) as $column) {
        if ($sourceColumns[$column] !== $destinationColumns[$column]) {
            $changedColumns[] = $column;
        }
    }

    if ($onlySourceColumns !== [] || $onlyDestinationColumns !== [] || $changedColumns !== []) {
        if ($table === 'usuarios' && $onlySourceColumns === [] && $onlyDestinationColumns === [] && $changedColumns === ['password']) {
            $allowedStructureDifferences[$table] = ['changed' => $changedColumns];
        } else {
            $unexpectedStructureDifferences[$table] = [
                'only_source' => $onlySourceColumns,
                'only_destination' => $onlyDestinationColumns,
                'changed' => $changedColumns,
            ];
        }
    }

    $sourceCount = count_table_rows($connection, $sourceDatabase, $table);
    $destinationCount = count_table_rows($connection, $destinationDatabase, $table);
    if ($sourceCount !== $destinationCount) {
        $rowCountDeltas[$table] = [
            'source' => $sourceCount,
            'destination' => $destinationCount,
            'delta_destination_minus_source' => $destinationCount - $sourceCount,
        ];
    }

    $commonColumns = array_values(array_intersect(array_keys($sourceColumns), array_keys($destinationColumns)));
    $primaryKey = primary_key_columns($connection, $destinationDatabase, $table);

    if (count($primaryKey) === 1 && in_array($primaryKey[0], $commonColumns, true)) {
        $quotedPrimaryKey = quote_identifier($primaryKey[0]);
        $quotedSourceTable = quote_identifier($sourceDatabase) . '.' . quote_identifier($table);
        $quotedDestinationTable = quote_identifier($destinationDatabase) . '.' . quote_identifier($table);

        $missing = (int) fetch_one(
            $connection,
            "SELECT COUNT(*) AS total
             FROM {$quotedSourceTable} source
             LEFT JOIN {$quotedDestinationTable} destination
                ON destination.{$quotedPrimaryKey} = source.{$quotedPrimaryKey}
             WHERE destination.{$quotedPrimaryKey} IS NULL"
        )['total'];

        $extra = (int) fetch_one(
            $connection,
            "SELECT COUNT(*) AS total
             FROM {$quotedDestinationTable} destination
             LEFT JOIN {$quotedSourceTable} source
                ON source.{$quotedPrimaryKey} = destination.{$quotedPrimaryKey}
             WHERE source.{$quotedPrimaryKey} IS NULL"
        )['total'];

        if ($missing > 0) {
            $sourceRowsMissingInDestination[$table] = $missing;
        }

        if ($extra > 0) {
            $destinationRowsNotInSource[$table] = $extra;
        }

        $compareColumns = $commonColumns;
        if ($table === 'usuarios') {
            $compareColumns = array_values(array_diff($compareColumns, ['password', 'session']));
        }

        $differenceChecks = [];
        foreach ($compareColumns as $column) {
            if ($column === $primaryKey[0]) {
                continue;
            }
            $quotedColumn = quote_identifier($column);
            $differenceChecks[] = "NOT (destination.{$quotedColumn} <=> source.{$quotedColumn})";
        }

        if ($differenceChecks !== []) {
            $differentRows = (int) fetch_one(
                $connection,
                "SELECT COUNT(*) AS total
                 FROM {$quotedSourceTable} source
                 JOIN {$quotedDestinationTable} destination
                    ON destination.{$quotedPrimaryKey} = source.{$quotedPrimaryKey}
                 WHERE " . implode(' OR ', $differenceChecks)
            )['total'];

            if ($differentRows > 0) {
                $sharedRowValueDifferences[$table] = [
                    'different_rows' => $differentRows,
                    'excluded_columns' => $table === 'usuarios' ? ['password', 'session'] : [],
                ];
            }
        }
    } else {
        $sourceExactRowsMissing = exact_rows_missing($connection, $sourceDatabase, $destinationDatabase, $table, $commonColumns);
        $destinationExactRowsMissing = exact_rows_missing($connection, $destinationDatabase, $sourceDatabase, $table, $commonColumns);

        if ($sourceExactRowsMissing > 0 || $destinationExactRowsMissing > 0) {
            $noPrimaryKeyDifferences[$table] = [
                'source_exact_rows_missing_in_destination' => $sourceExactRowsMissing,
                'destination_exact_rows_missing_in_source' => $destinationExactRowsMissing,
            ];
        }
    }
}

add_test($tests, 'T03_structure_expected_only', $unexpectedStructureDifferences === [] ? 'PASS' : 'FAIL', [
    'unexpected' => $unexpectedStructureDifferences,
    'allowed' => $allowedStructureDifferences,
]);

$noPrimaryKeySourceMissing = array_filter(
    $noPrimaryKeyDifferences,
    static fn(array $difference): bool => $difference['source_exact_rows_missing_in_destination'] > 0
);
add_test($tests, 'T04_all_backup_rows_exist_in_destination', ($sourceRowsMissingInDestination === [] && $noPrimaryKeySourceMissing === []) ? 'PASS' : 'FAIL', [
    'primary_key_tables_missing' => $sourceRowsMissingInDestination,
    'no_primary_key_tables_missing' => $noPrimaryKeySourceMissing,
]);

add_test($tests, 'T05_shared_rows_values_match', $sharedRowValueDifferences === [] ? 'PASS' : 'FAIL', $sharedRowValueDifferences);

$noPrimaryKeyDestinationExtras = array_filter(
    $noPrimaryKeyDifferences,
    static fn(array $difference): bool => $difference['destination_exact_rows_missing_in_source'] > 0
);
add_test($tests, 'T06_destination_has_only_known_extras', ($destinationRowsNotInSource === [] && $noPrimaryKeyDestinationExtras === []) ? 'PASS' : 'WARN', [
    'row_count_deltas' => $rowCountDeltas,
    'primary_key_extra_rows' => $destinationRowsNotInSource,
    'no_primary_key_extra_rows' => $noPrimaryKeyDestinationExtras,
]);

$passwordColumn = fetch_one(
    $connection,
    "SELECT COLUMN_TYPE, IS_NULLABLE
     FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = '{$destinationDatabase}'
       AND TABLE_NAME = 'usuarios'
       AND COLUMN_NAME = 'password'"
);
$badDestinationPasswords = (int) fetch_one(
    $connection,
    "SELECT COUNT(*) AS total
     FROM " . quote_identifier($destinationDatabase) . ".`usuarios`
     WHERE ((`password` NOT LIKE '\\$2y\\$%')
        AND (`password` NOT LIKE '\\$2a\\$%')
       AND (`password` NOT LIKE '\\\$argon2%'))
        OR CHAR_LENGTH(`password`) < 50"
)['total'];
$activeSessions = (int) fetch_one(
    $connection,
    "SELECT COUNT(*) AS total
     FROM " . quote_identifier($destinationDatabase) . ".`usuarios`
     WHERE `session` IS NOT NULL
       AND `session` <> ''"
)['total'];
$legacySourcePasswords = (int) fetch_one(
    $connection,
    "SELECT COUNT(*) AS total
     FROM " . quote_identifier($sourceDatabase) . ".`usuarios`
     WHERE ((`password` NOT LIKE '\\$2y\\$%')
        AND (`password` NOT LIKE '\\$2a\\$%')
       AND (`password` NOT LIKE '\\\$argon2%'))
        OR CHAR_LENGTH(`password`) < 50"
)['total'];

add_test($tests, 'T07_user_password_security', (
    ($passwordColumn['COLUMN_TYPE'] ?? null) === 'varchar(255)'
    && $badDestinationPasswords === 0
    && $activeSessions === 0
) ? 'PASS' : 'FAIL', [
    'destination_password_column' => $passwordColumn,
    'destination_bad_passwords' => $badDestinationPasswords,
    'destination_active_sessions' => $activeSessions,
    'source_legacy_passwords' => $legacySourcePasswords,
]);

$preMigrationBackups = array_map(
    static fn(array $row): string => $row['SCHEMA_NAME'],
    fetch_rows(
        $connection,
        "SELECT SCHEMA_NAME
         FROM INFORMATION_SCHEMA.SCHEMATA
         WHERE SCHEMA_NAME LIKE 'domsistemas_pre_migration_%'
         ORDER BY SCHEMA_NAME"
    )
);
add_test($tests, 'T08_pre_migration_backup_exists', $preMigrationBackups !== [] ? 'PASS' : 'FAIL', [
    'backups' => $preMigrationBackups,
]);

$report = [
    'executed_at' => date('c'),
    'source_of_truth' => $sourceDatabase,
    'destination' => $destinationDatabase,
    'summary' => [
        'pass' => count(array_filter($tests, static fn(array $test): bool => $test['status'] === 'PASS')),
        'fail' => count(array_filter($tests, static fn(array $test): bool => $test['status'] === 'FAIL')),
        'warn' => count(array_filter($tests, static fn(array $test): bool => $test['status'] === 'WARN')),
    ],
    'tests' => $tests,
];

if ($jsonOutput) {
    echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), PHP_EOL;
} else {
    print_human_report($report);
}

exit($report['summary']['fail'] > 0 ? 1 : 0);
