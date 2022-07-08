<?php

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
public function getConcert(string $artist)
{
    $concert = db()->prepare('SELECT * FROM `concerts` WHERE Artist= :concert');
        $concert->bindParam(':concert', $artist);
        $concert->execute();
        $concertinfo = $concert->fetch();
        return $concertinfo;
        
}

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
        $customerinfo = $customer->fetch();
        //echo "jetzt kommen customer";
        //var_dump($customerinfo);

        $concertinfo = $this->getConcert($this->concert);


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
        }
        echo "hier kommt die id:  ";
        var_dump($customerinfo['CustomerID']);


        $ticket = db()->prepare('INSERT INTO `tickets`(Customerid,Concertid,Paid,Paydate,loyaltybonus) VALUES (:customerid,:concertid,:paid,:paydate,:loyaltybonus)');
        $ticket->bindParam(':customerid', $customerinfo['CustomerID']);
        $ticket->bindParam(':concertid', $concertinfo['ConcertID']);
        $ticket->bindParam(':paid', $this->paid);
        $ticket->bindParam(':paydate', $this->paydate);
        $ticket->bindParam(':loyaltybonus', $this->loyalty);
        $ticket->execute();
    }


    public function getall()
    {
        $ticket = db()->query('SELECT t.TicketID, c.CustomerName, c.Email, c.Phone, t.loyaltybonus, a.Artist, t.Paydate, t.Paid
        FROM tickets AS t INNER JOIN customer AS c ON t.customerID = c.customerID INNER JOIN concerts AS a ON t.ConcertID = a.ConcertID ORDER BY TicketID;');
        $tickets = $ticket->fetchAll();
        //var_dump($tickets);
        return $tickets;
    }
    public function notPayed()
    {
        $ticket = db()->prepare('SELECT t.TicketID, c.CustomerName, c.Email, c.Phone, t.loyaltybonus, a.Artist, t.Paydate, t.Paid
        FROM tickets AS t INNER JOIN customer AS c ON t.customerID = c.customerID INNER JOIN concerts AS a ON t.ConcertID = a.ConcertID WHERE t.Paid === :paid  ORDER BY t.Paydate;');
        $ticket->bindParam(':paid', false);
        $ticket->execute();

        $tickets = $ticket->fetchAll();
        var_dump($tickets);
        return $tickets;
    }


    public function getConnections(int $ticketID)
    {
        $ticket = db()->prepare('SELECT t.CustomerID, t.ConcertID FROM tickets AS t WHERE TicketID =:ticketid');
        $ticket->bindParam(':ticketid', $ticketID);
        $ticket->execute();
        $theticket = $ticket->fetch();
        return $theticket;
    }
    public function getTicket(int $id)
    {
        $ticket = db()->prepare('SELECT t.TicketID, c.customerName, c.email, c.phone, t.loyaltybonus, a.artist, t.paydate, t.paid
        FROM tickets AS t INNER JOIN customer AS c ON t.customerid = c.customerid INNER JOIN concerts AS a ON t.ConcertID = a.ConcertID where TicketID =:ticketid');
        $ticket->bindParam(':ticketid', $id);
        $ticket->execute();
        $ticketInfo = $ticket->fetch();
        var_dump($ticketInfo);
        return $ticketInfo;
    }
    public function mutate(array $strings, bool $ispaid, int $id)
    {
        $this->name = $strings["name"];
        $this->email = $strings["email"];
        $this->phone = $strings["phone"];
        $this->concert = $strings["concert"];
        $this->paid = $ispaid;  
        $concertInfo = $this->getConcert($this->concert);
        $concertID = $concertInfo["ConcertID"];

        $ticket = db()->prepare('UPDATE `tickets` SET Paid = :paid, ConcertID =:concertID WHERE TicketID = :id');
        $ticket->bindParam(':paid', $this->paid);
        $ticket->bindParam(':concertID', $concertID);
        $ticket->bindParam(':id', $id);
        $ticket->execute();
        $ticketInfo = $this->getConnections($id);


        $customer = db()->prepare('UPDATE `customer` SET CustomerName = :CustomerName, Email =:email, Phone =:phone WHERE CustomerID = :id');
        $customer->bindParam(':CustomerName', $this->name);
        $customer->bindParam(':email', $this->email);
        $customer->bindParam(':phone', $this->phone);
        $customer->bindParam(':id', $ticketInfo["CustomerID"]);
        $customer->execute();
    }

    public function delete(int $id)
    {
        //Daten Löschen
        $id = $_GET['id'];
        $ticket = db()->prepare('DELETE FROM `tickets` WHERE TicketID = :id');
        $ticket->bindParam(':id', $id);
        $ticket->execute();

        $ticket = db()->query(' DELETE FROM `customer` WHERE CustomerID NOT IN (SELECT CustomerID FROM `tickets`)');

        return 0;
    }
}
