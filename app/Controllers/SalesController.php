<?php
class SalesController
{
    
    public function overview()
    {
    }
    public function edit()
    {
        require 'app/Views/mutate-sale.view.php';
    }
    public function newTicket()
    {
        require 'app/Views/new-sale.view.php';
    }
    public function validate()
    {
        $ticketModel = new ticketmodel();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']) ?? '';
            $email = trim($_POST['email']) ?? '';
            $phone = trim($_POST['phone']) ?? '';
            $concert = trim($_POST['concert'] ?? '');
            $loyalty = trim($_POST['loyaltybonus'] ?? 0);
            $paid = trim($_POST['paid'] ?? false);
            $date = date('Y-m-d', strtotime("+30 days"));
            
        }
        
        if ($name === '') {
            $errors[] = 'Bitte geben Sie einen Namen ein.';
        }
        if ($email === '') {
            $errors[] = 'Bitte geben Sie eine Email ein.';
        } elseif (!str_contains($email, '@')) {
            $errors[] = 'Ihre E-Mail ist ungültig';
        }
        if ($phone === '') {
            $errors[] = 'Bitte geben Sie eine Telefonnummer ein.';
        }
        if (preg_match('/a-z/', $phone)) {
            $errors[] = 'Bitte geben Sie nur Nummern ein.';
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
            $ticketModel->create($paramarray, (int)$loyalty, $date, $paid);
            header('LOCATION: overview');
        }
    }
}
