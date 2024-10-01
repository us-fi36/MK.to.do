<?php

// Der Header teilt dem Browser mit, dass die Antwort im JSON-Format gesendet wird.
header("Content-Type: application/json");

// Funktion zum Protokollieren von Aktionen (z.B. Erstellen, Lesen) in einer Log-Datei.
function write_log($action, $data) {
    // Öffne (oder erstelle) eine Datei namens 'log.txt' und hänge neue Inhalte an.
    $log = fopen('log.txt', 'a');
    
    // Hol dir das aktuelle Datum und die Uhrzeit.
    $timestamp = date('Y-m-d H:i:s');
    
    // Schreibe die Aktion und die zugehörigen Daten in die Datei, formatiert als JSON.
    fwrite($log, "$timestamp - $action: " . json_encode($data) . "\n");
    
    // Schließe die Datei, nachdem du die Daten hineingeschrieben hast.
    fclose($log);
}

// Pfad zur JSON-Datei, die alle TODO-Items speichert.
$todo_file = 'todos.json';

// Liest den Inhalt der 'todos.json'-Datei und wandelt ihn in ein Array um.
$todo_items = json_decode(file_get_contents($todo_file), true);

// Wenn der Browser eine GET-Anfrage schickt (z.B. um die TODO-Liste zu sehen), gebe die TODOs zurück.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Wandelt das Array der TODOs in JSON um und gibt es zurück.
    echo json_encode($todo_items);
}

// Bestimmt, welche Art von Anfrage vom Browser kommt (GET, POST, PUT, DELETE).
switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        // Wenn eine GET-Anfrage kommt, sende alle TODO-Elemente zurück.
        echo json_encode($todo_items); // Konvertiert die TODOs in JSON und sendet sie an den Browser.
        write_log("READ", $todo_items); // Protokolliert die Aktion "READ" (Lesen der TODOs).
        break;

    case "POST":
        // Wenn eine POST-Anfrage kommt, bedeutet das, dass ein neues TODO erstellt werden soll.
        
        // Nimmt die Daten aus der Anfrage (den Titel des neuen TODOs).
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Erstellt ein neues TODO mit einer eindeutigen ID und dem Titel, den der Benutzer gesendet hat.
        $new_todo = ["id" => uniqid(), "title" => $data['title']];
        
        // Fügt das neue TODO-Item zum Array der bestehenden TODOs hinzu.
        $todo_items[] = $new_todo;
        
        // Speichert die aktualisierte TODO-Liste wieder in der 'todos.json'-Datei.
        file_put_contents($todo_file, json_encode($todo_items));
        
        // Gibt das neu erstellte TODO-Element als JSON zurück.
        echo json_encode($new_todo);
        
        // Protokolliert die Aktion "CREATE" (Erstellen eines neuen TODOs).
        write_log("CREATE", $new_todo);
        break;

    case "PUT":
        // Platzhalter für PUT-Anfragen, die zum Aktualisieren eines bestehenden TODOs verwendet werden.
        write_log("PUT", null); // Protokolliert einfach die PUT-Anfrage (noch nicht implementiert).
        break;

    case "DELETE":
        // Platzhalter für DELETE-Anfragen, die zum Löschen eines TODOs verwendet werden.
        write_log("DELETE", null); // Protokolliert einfach die DELETE-Anfrage (noch nicht implementiert).
        break;
}

?>
