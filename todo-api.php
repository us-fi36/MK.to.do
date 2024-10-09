<?php
require_once 'TodoDB.php';

// Eine neue Instanz der TodoDB-Klasse erstellen.
$todoDB = new TodoDB();

// Header setzen, um JSON als Antwortformat zu definieren.
header('Content-Type: application/json');

// Die HTTP-Methode herausfinden (GET, POST, PUT, DELETE).
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Wenn die Methode GET ist, alle Todos als JSON zurückgeben.
    echo json_encode($todoDB->getTodos());
} elseif ($method === 'POST') {
    // Wenn die Methode POST ist, ein neues Todo erstellen.
    $data = json_decode(file_get_contents('php://input'), true);
    $text = $data['text'] ?? '';
    $result = $todoDB->createTodo($text);
    echo json_encode(['success' => $result]);
} elseif ($method === 'PUT') {
    // Wenn die Methode PUT ist, den Status eines Todos aktualisieren.
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    $result = $todoDB->updateTodoStatus($id);
    echo json_encode(['success' => $result]);
} elseif ($method === 'DELETE') {
    // Wenn die Methode DELETE ist, ein Todo löschen.
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    $result = $todoDB->deleteTodo($id);
    echo json_encode(['success' => $result]);
}
?>
