<?php

if (!function_exists('debug_log')) {
    function debug_log($label, $value = null)
    {
        if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
            if ($value === null) {
                error_log("DEBUG: " . $label);
            } else {
                error_log("DEBUG $label: " . print_r($value, true));
            }
        }
    }
}

if (!function_exists('debug_request')) {
    function debug_request()
    {
        if (defined('DEBUG_MODE') && DEBUG_MODE === true) {
            error_log("DEBUG GET: " . print_r($_GET, true));
            error_log("DEBUG POST: " . print_r($_POST, true));
        }
    }
}
