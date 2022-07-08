<?php
class SalesController
{
    
    public function overview()
    {
        $ticketModel = new ticketmodel();
        $allsales = $ticketModel->getall();
        require 'app/Views/sales.view.php';
    }
    public function notpayed()
    {
        $ticketModel = new ticketmodel();
        $allsales = $ticketModel->notpayed();
        require 'app/Views/sales.view.php';
    }
    public function delete()
    {
        $ticketID = $_GET['id'];
        $ticketmodel = new ticketmodel();
        $deleteEntries = $ticketmodel->delete($ticketID);
        header('LOCATION: overview');
    }
    public function edit()
    {
        $ticketID = $_GET['id'];
        $ticketmodel = new ticketmodel();
        $concertlist = $ticketmodel->getConcerts();
        $ticket = $ticketmodel->getTicket($ticketID);
        require 'app/Views/mutate-sale.view.php';
    }
    public function newTicket()
    {
        $ticketmodel = new ticketmodel();
        $concertlist = $ticketmodel->getConcerts();
        require 'app/Views/new-sale.view.php';
    }
    public function validate(int $type)
    {
        $ticketModel = new ticketmodel();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']) ?? '';
            $email = trim($_POST['email']) ?? '';
            $phone = trim($_POST['phone']) ?? '';
            $concert = trim($_POST['concert'] ?? '');
            $loyalty = trim($_POST['loyaltybonus'] ?? 0);
            $paid = trim($_POST['paid'] ?? 0);
            $date = date('Y-m-d', strtotime("+30 days"));
            $ticketid = $_POST['ticketid'];
        }
        if ($name === '') {
            $errors[] = 'Bitte geben Sie einen Namen ein.';
        }
        if ($email === '') {
            $errors[] = 'Bitte geben Sie eine Email ein.';
        } elseif (!str_contains($email, '@')) {
            $errors[] = 'Ihre E-Mail ist ungültig';
        }
        if($phone = '');
        elseif (preg_match('/[0-9\+\-\(\) ]{0,}$/', $phone) == false) {
            $errors[] = 'Telefonnummern erlauben nur Ziffern 0-9 und +-()';
        }
        if ($concert === '') {
            $errors[] = 'Bitte wählen Sie ein Konzert aus.';
        }
        
        if(count($errors) !== 0){
            foreach($errors as $error){
                echo $error . '<br>';
            }
        }
        else{

            $paramarray = [
                'name' => "$name",
                'email' => "$email",
                'phone' => "$phone",
                'concert' => "$concert"
            ];
            if($type === 1){
                $ticketModel->create($paramarray, (int)$loyalty, $date, $paid);
                header('LOCATION: overview');
            }
            elseif($type === 2){
                $ticketModel->mutate($paramarray, $paid, $ticketid);
                header('LOCATION: overview');
            }
        }
    }
    public function validatenew(){
        $this->validate(1);
    }
    public function validateedit(){
        $this->validate(2);
    }
}
