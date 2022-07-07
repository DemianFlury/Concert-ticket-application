<?php
/**
 * Das Model "Example" implementiert alle grundlegenden Funktionen einer Datenbank-
 * Anwendung: load (SELECT), save (INSERT oder UPDATE) und delete (DELETE).
 */
class ticketmodel
{
    public int $saleid = 0;
    public int $personid = 0;
    public int $concertid = 0;
    public string $name = '';

    /**
     * Der Konstruktor initialisiert alle Eigenschaften des Objekts
     * Für neue Datensätze kann die $id auf 0 gesetzt werden.
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        return $this;
    }

    /**
     * Datensatz mit gegebener ID von der Datenbank ins Objekt laden
     */
    public function find(int $id): ?self
    {
        $statement = db()->prepare('SELECT * FROM example WHERE id = :id LIMIT 1');
        $statement->bindParam(':id', $id);
        $statement->execute();
        $result = $statement->fetch();

        if ($result) {
            // Datensatz gefunden? Eigenschaften setzen und Objekt zurückgeben.
            $this->id = $result['id'];
            $this->name = $result['name'];

            return $this;
        }

        // Datensatz NICHT gefunden -> null zurückgeben.
        return null;
    }

    /**
     * Alle Datensätze aus der Datenbank laden.
     */
    public function getAll()
    {
        // Dein Code ...
    }

    /**
     * Erstellt einen neuen Eintrag in der Datenbank.
     */
    public function create(): int
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $title = $_POST["title"];
            $title = trim($title);
            if($title ===""){

            echo"bitte geben sie eine Aufgabe ein bevor abzusenden!";
            header('LOCATION: /framework/task');
            }
            else{
                $statement = db()->prepare('INSERT INTO `tasks`(title) VALUES (:title)');
                $statement->bindParam(':title',$title);
                $statement->execute();
                header('LOCATION: /framework/task');
            }
        }
    }
    
    /**
     * Aktualisiert die aktuellen Daten in der Datenbank.
     */
    public function update(): int
    {
        // Dein Code...
    }

    /**
     * Lösche einen Datensatz, entweder mit der angegebenen $id oder falls nicht angegeben, der aktuell geladene.
     */
    public function delete(int $id = 0): int
    {
       //Daten Löschen
       $id = $_GET['id'];
       $statement = db()->prepare('DELETE FROM `tasks` WHERE id = :id');
       $statement->bindParam(':id', $id);
       $statement->execute();
       header('LOCATION: /framework/task');

        return 0;
    }
}