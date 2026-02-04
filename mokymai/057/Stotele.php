<?php

// klases deklaracija
class Stotele // pavadinimas prasideda didziaja raide
{
    public $vardas; // savybes aprasymas
    public $autobusai = []; // savybes aprasymas
    private $id; // savybes aprasymas


    function __construct($pavadinimas) // konstruktorius, kuris paleidziamas kuriant objekta
    {
        $this->vardas = $pavadinimas; // $this nurodo i esama objekta
        $this->id = rand(1000, 9999); // priskiriama atsitiktine reiksme is intervalo

    }

    public function __destruct() // destruktorius, kuris paleidziamas sunaikinant objekta
    {
        echo '<h1 style="color:crimson;">Objekto nebėra</h1>'; // veikia, kai objektas sunaikinamas
    }


    //pasileidzia kai bandoma pasiekti neegzistuojancia private savybe
    public function __get($prop)
    {
        // $prop ==> 'id'

        return $this->$prop; // $ yra, nes tai yra savybes kintamasis
    }





    public function rodytiAutobusus() // metodas, kuris priklauso klasei
    {
        if (count($this->autobusai) === 0) { // patikrina ar masyvas tuscias
            echo '<h2 style="color: red;">Autobusu nera</h2>'; // isveda zinute, jei masyvas tuscias
        }
    }
}
