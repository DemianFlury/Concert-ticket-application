<?php

/**
 * Das Model "Example" implementiert alle grundlegenden Funktionen einer Datenbank-
 * Anwendung: load (SELECT), save (INSERT oder UPDATE) und delete (DELETE).
 */
class ticketmodel
{
    
    public int $saleid;
    public int $personid = 0;
    public int $concertid = 0;
    public string $name = "";
    public string $email = "";
    public string $phone = "";
    public int $loyalty = 0;
    public string $concert = "";
    public string $paydate;
    public bool $paid = false;
    /**
     * Der Konstruktor initialisiert alle Eigenschaften des Objekts
     * Für neue Datensätze kann die $id auf 0 gesetzt werden.
     */
    public function __construct()
    {
        $this->saleid = 0;
        $this->personid = 0;
        $this->name = "";
        $this->email = "";
        $this->phone = "";
        $this->loyalty = 0;
        $this->concert = "";
        $this->paydate = date('Y-m-d');
        $this->paid = false;

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
    public function create(array $strings, int $loyal, $date, $ispaid)
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
        $newCustomer = db()->prepare('INSERT INTO `customers`(customerName, email, phone, loyalty) VALUES (:customerName,:email,:phone,:loyalty)');
        $newCustomer->bindParam(':customerName,:email,:phone,:loyalty', $this->name, $this->email, $this->phone, $this->loyalty);
        $newCustomer->execute();
        }
        echo $this->playdate;
        
        $ticket = db()->prepare('INSERT INTO `tickets`(customerid,concertid,paid,paydate) VALUES (:customerid,:concertid,:paid,:date)');
        $ticket->bindParam(':customerid,:concertid,:paid,:date',$customer['customerid'],$concertid['concertid'],$this->paid, $this->paydate );
        $ticket->execute();
        
    }
    
    /**
     * Erstellt einen neuen Eintrag in der Datenbank.
     */
    public function getall($ticketid): int
    {
        $ticket = db()->prepare('SELECT c.customerName, c.email, c.phone, c.loyaltybonus, a.artist, t.paydate, t.paid
        FROM ticket AS t INNER JOIN customer AS c ON ticket.customerid = customer.customerid INNER JOIN concert AS a ON ticket.concertid = concert.concertid ORDER BY ticketid;');
        $ticket->bindParam(':email',$this->email);
        $ticket->execute();
        return 1;
    }

    /**
     * Aktualisiert die aktuellen Daten in der Datenbank.
     */
    public function update(): int
    {
        // Dein Code...
        return 1;
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
