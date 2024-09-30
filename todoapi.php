<?php

header("Content-Type: application/json");

// LOG function in PHP
function write_log($action, $data) {
    $log = fopen('log.txt', 'a');
    $timestamp = date('Y-m-d H:i:s');
    fwrite($log, "$timestamp - $action: " . json_encode($data) . "\n");
    fclose($log);
}

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        // Get Todo's (READ)
        write_log("READ", null);
        break;
    case "POST":
        // Add Todo (CREATE)
        write_log("CREATE", null);
        break;
    case "PUT":
        // Change Todo (UPDATE)
        write_log("PUT", null);
        break;
    case "DELETE":
        // Remove Todo (DELETE)
        write_log("DELETE", null);
        break;
}

?>
