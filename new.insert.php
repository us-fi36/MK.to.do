<?php
switch ($_SERVER['REQUEST_METHOD']) {
case 'POST':
// Get data from the input stream.
$data = json_decode(file_get_contents('php://input'), true);
// Create new todo item.
$new_todo = ["id" => uniqid(), "title" => $data['title']];
// Add new item to our todo item list.
$todo_items[] = $new_todo;
// Write todo items to JSON file.
file_put_contents($todo_file, json_encode($todo_items));
// Return the new item.
echo json_encode($new_todo);
break;
}
?>
