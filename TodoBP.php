<?php

require_once(__DIR__ . '/../config.php');

/**
 * Diese Klasse verwaltet die Datenbankoperationen (Erstellen, Abrufen, Aktualisieren und Löschen von Todos).
 */
class TodoDB {
    private $connection;

    /**
     * Konstruktor: Stellt die Verbindung zur Datenbank her.
     */
    public function __construct() {
        global $host, $db, $user, $pass;
        try {
            // Verbindung zur Datenbank herstellen
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4",
                $user,
                $pass
            );
            // Setze den Fehler- und den Abrufmodus
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Bei Verbindungsfehler: Fehler in die Logdatei schreiben
            error_log("Verbindung fehlgeschlagen: " . $e->getMessage());
        }
    }

    /**
     * Diese Methode führt SQL-Anweisungen aus.
     * 
     * @param string $sql Die SQL-Abfrage.
     * @param array $params Parameter für die SQL-Abfrage (optional).
     * @return array|bool Bei SELECT-Abfragen wird das Ergebnis zurückgegeben. Bei anderen Abfragen true/false.
     */
    private function prepareExecuteStatement($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            // Bei SELECT-Abfragen die Ergebnisse zurückgeben
            if (stripos($sql, 'SELECT') === 0) {
                return $stmt->fetchAll();
            }
            return true;
        } catch (PDOException $e) {
            // Fehler in die Logdatei schreiben, falls Abfrage fehlschlägt
            error_log("Abfrage-Fehler: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Gibt alle Todos aus der Datenbank zurück.
     * 
     * @return array Liste der Todos (id, text, completed Status).
     */
    public function getTodos() {
        $sql = "SELECT id, text, completed FROM todos";
        return $this->prepareExecuteStatement($sql);
    }

    /**
     * Erstellt ein neues Todo mit dem angegebenen Text.
     * 
     * @param string $text Der Text des neuen Todos.
     * @return bool Erfolg oder Misserfolg der Einfügeoperation.
     */
    public function createTodo($text) {
        $sql = "INSERT INTO todos (text, completed) VALUES (:text, :completed)";
        return $this->prepareExecuteStatement($sql, ['text' => $text, 'completed' => 0]);
    }

    /**
     * Aktualisiert den Erledigt-Status eines Todos.
     * 
     * @param int $id Die ID des Todos, das aktualisiert werden soll.
     * @return bool Erfolg oder Misserfolg der Aktualisierung.
     */
    public function updateTodoStatus($id) {
        $sql = "UPDATE todos SET completed = NOT completed WHERE id = :id";
        return $this->prepareExecuteStatement($sql, ['id' => $id]);
    }

    /**
     * Löscht ein Todo anhand seiner ID.
     * 
     * @param int $id Die ID des zu löschenden Todos.
     * @return bool Erfolg oder Misserfolg der Löschoperation.
     */
    public function deleteTodo($id) {
        $sql = "DELETE FROM todos WHERE id = :id";
        return $this->prepareExecuteStatement($sql, ['id' => $id]);
    }
}

?>
