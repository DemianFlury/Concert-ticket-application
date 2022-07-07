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
    public string $name = "";
    public string $email = "";
    public string $phone = "";
    public float $loyalty = "";
    public string $concert = "";
    public DateTime $paydate = "";
    public bool $paid = false;

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
    public function create($strings = [4], $loyal, $date, $ispaid)
    {
        $this->name = $strings["name"];
        $this->email = $strings["email"];
        $this->phone = $strings["phone"];
        $this->loyalty = $loyal;
        $this->concert = $strings["concert"];
        $this->paydate = $date;
        $this->paid = $ispaid;

        $customer = db()->prepare('SELECT * FROM `customers` WHERE email= :email');
        $customer->bindParam(':email',$this->email);
        $customer->execute();
        
        $concertid = db()->prepare('SELECT * FROM `concerts` WHERE artist= :concert');
        $concertid->bindParam(':concert',$this->concert);
        $concertid->execute();
        
        if($customer == ""){
        $newCustomer = db()->prepare('INSERT INTO `customers`(name, email, phone, loyalty) VALUES (:name,:email,:phone,:loyalty)');
        $newCustomer->bindParam(':name,:email,:phone,:loyalty', $this->name, $this->email, $this->phone, $this->loyalty);
        $newCustomer->execute();
        }

        
        $ticket = db()->prepare('INSERT INTO `tickets`(customerid,concertid,paid,date) VALUES (:customerid,:concertid,:paid,:date)');
        $ticket->bindParam(':customerid,:concertid,:paid,:date',$customer['customerid'],$concertid['concertid'] );
        $ticket->execute();
        
    }
    
    /**
     * Erstellt einen neuen Eintrag in der Datenbank.
     */
    public function getall(): int
    {
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
