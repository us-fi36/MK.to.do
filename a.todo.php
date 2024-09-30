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

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":

        $todo_items =[
            ["id" => "someuniqueId", "title" => "erste Aufgabe"],
            ["id" => "someuniqueId2", "title" => "erste Aufgabe Part 2"],
            ["id" => "someuniqueId3", "title" => "erste Aufgabe Part 3"]
        ];
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
