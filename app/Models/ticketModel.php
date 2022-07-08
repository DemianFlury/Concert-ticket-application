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
    public function getConcerts()
    {
        $concert = db()->query('SELECT * FROM `concerts`');
        $consertlist = $concert->fetchAll();
        //var_dump($consertlist);
        return $consertlist;
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

        var_dump($this->concert);

        $customer = db()->prepare('SELECT * FROM `customer` WHERE Email= :email');
        $customer->bindParam(':email', $this->email);
        $customer->execute();

        $concert = db()->prepare('SELECT * FROM `concerts` WHERE Artist= :concert');
        $concert->bindParam(':concert', $this->concert);
        $concert->execute();
        $customerinfo = $customer->fetch();
        var_dump()

        //var_dump($customerinfo);
        if ($customerinfo === false) {
            $newCustomer = db()->prepare('INSERT INTO `customer`(CustomerName, Email, Phone) VALUES (:customerName,:email,:phone)');
            $newCustomer->bindParam(':customerName', $this->name);
            $newCustomer->bindParam(':email', $this->email);
            $newCustomer->bindParam(':phone', $this->phone);
            $newCustomer->execute();

            $customer = db()->prepare('SELECT * FROM `customer` WHERE email= :email');
            $customer->bindParam(':email', $this->email);
            $customer->execute();

            $customerinfo = $customer->fetch();
            //var_dump($customerinfo);
        }
        $concertinfo = $concert->fetch();
        var_dump($concertinfo);


        $ticket = db()->prepare('INSERT INTO `tickets`(Customerid,Concertid,Paid,Paydate,loyaltybonus) VALUES (:customerid,:concertid,:paid,:paydate,:loyaltybonus)');
        $ticket->bindParam(':customerid', $customerinfo['Customerid']);
        $ticket->bindParam(':concertid', $concertinfo['Concertid']);
        $ticket->bindParam(':paid', $this->paid);
        $ticket->bindParam(':paydate', $this->paydate);
        $ticket->bindParam(':loyaltybonus', $this->loyalty);
        $ticket->execute();
    }

    /**
     * Erstellt einen neuen Eintrag in der Datenbank.
     */
    public function getall()
    {
        $ticket = db()->query('SELECT c.customerName, c.email, c.phone, c.loyaltybonus, a.Artist, t.paydate, t.paid
        FROM tickets AS t INNER JOIN customer AS c ON t.customerid = c.customerid INNER JOIN concerts AS a ON t.concertid = a.Concertid ORDER BY ticketid;');
        $tickets = $ticket->fetchAll();
        //var_dump($tickets);
        return $tickets;
    }

    /**
     * Aktualisiert die aktuellen Daten in der Datenbank.
     */
    public function update()
    {
        $ticket = db()->prepare('SELECT c.customerName, c.email, c.phone, c.loyaltybonus, a.artist, t.paydate, t.paid
        FROM ticket AS t INNER JOIN customer AS c ON t.customerid = c.customerid INNER JOIN concert AS a ON t.concertid = c.concertid where ticketid =:ticketid');
        $ticket->bindParam(':ticketid', $this);
        $ticket->execute();
        return $ticket;
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
