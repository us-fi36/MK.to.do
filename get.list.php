<?php
// Read content of the file and decode JSON data to an array.
$todo_file = 'todos.json';
$todo_items = json_decode(file_get_contents($todo_file), true);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
// Rückgabe der TODOs
echo json_encode($todo_items);
}
?>
