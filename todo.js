document.addEventListener("DOMContentLoaded", function() {
    // URL der API, die wir für die Anfragen verwenden
    const apiUrl = "todo-api.php";

    // Funktion zum Laden der Todos aus der Datenbank
    function loadItems() {
        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const todoList = document.getElementById('todo-list');
            todoList.innerHTML = ""; // Liste leeren
            data.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.text;
                li.id = item.id;

                // Wenn das Todo erledigt ist, Stil anwenden
                if (item.completed) {
                    li.classList.add('completed');
                }

                // Löschen-Button erstellen
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Löschen';
                deleteButton.addEventListener('click', function() {
                    // Todo löschen
                    fetch(apiUrl, {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: item.id })
                    })
                    .then(() => li.remove()); // Element aus der Liste entfernen
                });
                li.appendChild(deleteButton);

                // Erledigt-Button erstellen
                const completeButton = document.createElement('button');
                completeButton.textContent = 'Erledigt';
                completeButton.addEventListener('click', function() {
                    // Todo-Status umschalten
                    fetch(apiUrl, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: item.id })
                    })
                    .then(() => loadItems()); // Liste neu laden
                });
                li.appendChild(completeButton);

                // Todo in die Liste einfügen
                todoList.appendChild(li);
            });
        });
    }

    // Neue Todos hinzufügen, wenn das Formular abgeschickt wird
    document.getElementById('todo-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Verhindert das Neuladen der Seite
        const todoInput = document.getElementById('todo-input').value;
        // Todo zur Datenbank hinzufügen
        fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ text: todoInput })
        })
        .then(() => loadItems()); // Liste nach dem Hinzufügen neu laden
    });

    // Todos beim Laden der Seite anzeigen
    loadItems();
});
