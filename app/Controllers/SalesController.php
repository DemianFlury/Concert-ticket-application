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
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']) ?? '';
            $email = trim($_POST['email']) ?? '';
            $phone = trim($_POST['phone']) ?? '';
            $concert = trim($_POST['concert'] ?? '');
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

            header('LOCATION: /overview');
        }
    }
}
