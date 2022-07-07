<?php

class FormController
{
    public function form()
    {

        require "app/Views/form.view.php";
    }
    public function validate()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']) ?? '';
            $email = trim($_POST['email']) ?? '';
            $phone = trim($_POST['phone']) ?? '';
            $people = trim($_POST['people']) ?? '';
            $hotel = trim($_POST['hotel']) ?? '';
            $shuttle = trim($_POST['shuttle']) ?? 0;
            $program = trim($_POST['program']) ?? '';
            $notes = trim($_POST['note']) ?? '';
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
        if ($people === '') {
            $errors[] = 'Bitte geben Sie die Anzahl teilnehmender Personen ein.';
        }
        if (preg_match('/a-z/', $phone)) {
            $errors[] = 'Bitte geben Sie nur Nummern ein.';
        }
        if ($hotel === '') {
            $errors[] = 'Bitte wählen Sie ein Hotel für die Übernachtung aus.';
        }

        if (count($errors) === 0) {
            require 'app/Views/form_ok.view.php';
            return;
        }
        require 'app/Views/form.view.php';
    }
}
