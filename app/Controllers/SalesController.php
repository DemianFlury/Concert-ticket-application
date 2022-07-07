<?php
class SalesController{
    public function overview(){

    }
    public function edit(){
        require 'app/Views/mutate-sale.view.php';
    }
    public function newTicket(){
        require 'app/Views/new-sale.view.php';
    }
}