<?php

class Zveris extends Miskas implements Fauna, Fauna2
{

    public $vardas;
    public $dangus = 'Žydras';
    public static $kas = 'Uodega';

    public function __construct($vardas)
    {
        $this->vardas = $vardas;
    }

    public function valio()
    {
        echo '<h2>Mehhh...</h2>';
    }

    public function grybai($va)
    {
        echo '<h2>GrYYYYYYbai...</h2>';
    }

    public function basukai()
    {
        echo '<h2>Basukai...</h2>';
    }
    public function kiaunes()
    {
        echo '<h2>Kiaunės...</h2>';
    }
    public function barsukai2()
    {
        echo '<h2>Barsukai 2...</h2>';
    }
    public function kiaunes2()
    {
        echo '<h2>Kiaunės 2...</h2>';
    }
    public function musmires()
    {
        echo '<h2>Musmirės...</h2>';
    }
}
