<?php
include("../seguridadsimple.php");

$hoy = date('Y-m-d');
$filename = 'LISTADO-' . $hoy . '.xls';

$inicio = $_POST["desde"] ?? '';
$termino = $_POST["hasta"] ?? '';

if ($termino == "") {
    $termino = $inicio;
}

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$link = Conectarse();

$inicio_safe = mysqli_real_escape_string($link, $inicio);
$termino_safe = mysqli_real_escape_string($link, $termino);

$consultaSQL = "SELECT * FROM cert2009 WHERE (fecha_solicitud >= '$inicio_safe' AND fecha_solicitud <= '$termino_safe') ORDER BY id";
$result = mysqli_query($link, $consultaSQL);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
    xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
    xmlns:html="http://www.w3.org/TR/REC-html40">
    <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
        <Author>Sistema DOM</Author>
        <Created><?php echo date('Y-m-d\TH:i:s\Z'); ?></Created>
    </DocumentProperties>
    <Styles>
        <Style ss:ID="header">
            <Font ss:Bold="1" ss:Size="11" ss:Color="#FFFFFF" /><Interior ss:Color="#4CAF50" ss:Pattern="Solid" /><Alignment ss:Horizontal="Center" ss:Vertical="Center" /><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" /><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" /><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" /><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" /></Borders>
        </Style>
        <Style ss:ID="title">
            <Font ss:Bold="1" ss:Size="14" /><Alignment ss:Horizontal="Center" />
        </Style>
        <Style ss:ID="cell">
            <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" /><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" /><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" /><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" /></Borders>
        </Style>
    </Styles>
    <Worksheet ss:Name="Reporte Diario">
        <Table>
            <Column ss:Width="50" />
            <Column ss:Width="80" />
            <Column ss:Width="100" />
            <Column ss:Width="150" />
            <Column ss:Width="250" />
            <Column ss:Width="200" />
            <Column ss:Width="150" />

            <Row>
                <Cell ss:MergeAcross="6" ss:StyleID="title">
                    <Data ss:Type="String">Reporte Diario de Solicitudes de Certificados</Data>
                </Cell>
            </Row>
            <Row>
                <Cell ss:MergeAcross="6">
                    <Data ss:Type="String">Período: <?php echo htmlspecialchars($inicio); ?> al <?php echo htmlspecialchars($termino); ?></Data>
                </Cell>
            </Row>
            <Row />

            <Row>
                <Cell ss:StyleID="header"><Data ss:Type="String">ID</Data></Cell>
                <Cell ss:StyleID="header"><Data ss:Type="String">Fecha</Data></Cell>
                <Cell ss:StyleID="header"><Data ss:Type="String">ROL</Data></Cell>
                <Cell ss:StyleID="header"><Data ss:Type="String">Tipo Certificado</Data></Cell>
                <Cell ss:StyleID="header"><Data ss:Type="String">Dirección / Numero / Depto / Block / Sitio / Manzana</Data></Cell>
                <Cell ss:StyleID="header"><Data ss:Type="String">Nombre del Contribuyente</Data></Cell>
                <Cell ss:StyleID="header"><Data ss:Type="String">Firma de Recepción Conforme</Data></Cell>
            </Row>

            <?php
            if (!$result) {
                echo '<Row><Cell ss:MergeAcross="6"><Data ss:Type="String">Error en la consulta: ' . htmlspecialchars(mysqli_error($link)) . '</Data></Cell></Row>';
            } else {
                $num_total_registros = mysqli_num_rows($result);

                if ($num_total_registros == 0) {
                    echo '<Row><Cell ss:MergeAcross="6"><Data ss:Type="String">No se encontraron registros para el período seleccionado</Data></Cell></Row>';
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $idaux = htmlspecialchars($row["id"]);
                        $fecha = htmlspecialchars($row["fecha_solicitud"]);
                        $rolaux = htmlspecialchars($row["rol"]);
                        $diraux = htmlspecialchars($row["direccion"]);
                        $cod = $row["rut"];
                        $idcert = $row["idcert"];

                        $qry_rut = "SELECT nombre, apellidos FROM rut WHERE rut = '" . mysqli_real_escape_string($link, $cod) . "'";
                        $res_rut = mysqli_query($link, $qry_rut);

                        if ($res_rut && mysqli_num_rows($res_rut) > 0) {
                            $row_rut = mysqli_fetch_assoc($res_rut);
                            $nombre = htmlspecialchars($row_rut["nombre"] . " " . $row_rut["apellidos"]);
                        } else {
                            $nombre = "N/A";
                        }

                        $qry_tc = "SELECT nombre FROM tipocertificado WHERE id = '" . mysqli_real_escape_string($link, $idcert) . "'";
                        $res_tc = mysqli_query($link, $qry_tc);

                        if ($res_tc && mysqli_num_rows($res_tc) > 0) {
                            $row_tc = mysqli_fetch_assoc($res_tc);
                            $tcx = htmlspecialchars($row_tc["nombre"]);
                        } else {
                            $tcx = "N/A";
                        }

                        echo '<Row>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="Number">' . $idaux . '</Data></Cell>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="String">' . $fecha . '</Data></Cell>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="String">' . $rolaux . '</Data></Cell>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="String">' . $tcx . '</Data></Cell>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="String">' . $diraux . '</Data></Cell>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="String">' . $nombre . '</Data></Cell>';
                        echo '<Cell ss:StyleID="cell"><Data ss:Type="String"></Data></Cell>';
                        echo '</Row>';
                    }

                    echo '<Row/>';
                    echo '<Row><Cell ss:MergeAcross="6"><Data ss:Type="String">Total de Solicitudes: ' . $num_total_registros . '</Data></Cell></Row>';
                }
            }

            mysqli_close($link);
            ?>
        </Table>
    </Worksheet>
</Workbook>