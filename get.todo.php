<?php
$todo_items = [
["id" => "someUniqueId", "title" => "Erste Aufgabe"]
];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
echo json_encode($todo_items);
}
?>

// as saved within the filesystems on server
