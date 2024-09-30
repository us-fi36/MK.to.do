<?php

header("Content-Type: application/json");

// LOG function in PHP
function write_log($action, $data) {
    $log = fopen('log.txt', 'a');
    $timestamp = date('Y-m-d H:i:s');
    fwrite($log, "$timestamp - $action: " . json_encode($data) . "\n");
    fclose($log);
}



// Read content of the file and decode JSON data to an array.

$todo_file = 'todos.json';
$todo_items = json_decode(file_get_contents($todo_file), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Rückgabe der TODOs
    echo json_encode($todo_items);
 

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":

        // Get Todo's (READ)
        echo json_encode($todo_items);
        write_log("READ", $todo_items);
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
