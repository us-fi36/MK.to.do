// Warten, bis die gesamte Seite geladen ist, bevor das Skript ausgeführt wird.
document.addEventListener("DOMContentLoaded", function() {

    // URL des PHP-Skripts, das die TODO-Liste verarbeitet.
    const apiUrl = "http://172.30.148.126/Todolist/todo.php";

    // Holt die TODO-Elemente vom Server (vom PHP-Skript) und zeigt sie in der Liste an.
    fetch(apiUrl) // Sendet eine GET-Anfrage an das PHP-Skript.
    .then(response => response.json()) // Konvertiert die Antwort (die im JSON-Format ist) in ein JavaScript-Objekt.
    .then(data => {
        const todoList = document.getElementById('todo-list'); // Greift auf die Liste im HTML-Dokument zu.
        
        // Geht jedes TODO-Element in den empfangenen Daten durch.
        data.forEach(item => {
            const li = document.createElement('li'); // Erstellt ein neues Listen-Element für jedes TODO.
            li.textContent = item.title; // Setzt den Titel des TODOs als Text im Listen-Element.
            todoList.appendChild(li); // Fügt das neue Element zur Liste auf der Seite hinzu.
        });
    });

    // Event-Listener für das Formular, um ein neues TODO hinzuzufügen.
    document.getElementById('todo-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Verhindert, dass die Seite beim Abschicken des Formulars neu geladen wird.
        
        const todoInput = document.getElementById('todo-input').value; // Holt den Text des neuen TODOs aus dem Eingabefeld.

        // Sendet eine POST-Anfrage an das PHP-Skript, um das neue TODO zu erstellen.
        fetch(apiUrl, {
            method: 'POST', // Gibt an, dass eine POST-Anfrage (zum Erstellen) gesendet wird.
            headers: {
                'Content-Type': 'application/json' // Teilt dem Server mit, dass die gesendeten Daten im JSON-Format sind.
            },
            body: JSON.stringify({ title: todoInput }) // Sendet die neuen Daten (den Titel des TODOs) als JSON an den Server.
        })
        .then(response => response.json()) // Konvertiert die Antwort des Servers in ein JavaScript-Objekt.
        .then(data => {
            const todoList = document.getElementById('todo-list'); // Greift wieder auf die Liste im HTML-Dokument zu.
            const li = document.createElement('li'); // Erstellt ein neues Listen-Element für das neue TODO.
            li.textContent = data.title; // Setzt den Titel des neuen TODOs in das Listen-Element.
            todoList.appendChild(li); // Fügt das neue Element zur Liste auf der Seite hinzu.
        });
    });
});
