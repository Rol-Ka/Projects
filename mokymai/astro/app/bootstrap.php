<?php


// Visi pagrindiniai nustatymai 

const DIR = __DIR__ . '/../'; // Nustatome pagrindinį katalogą
const URL = 'http://localhost/projects/mokymai/astro/public/'; // Nustatome pagrindinį URL
const INSTALL_DIR = '/projects/mokymai/astro/public/'; // Nustatome diegimo katalogą

require DIR . 'app/functions.php'; // Įtraukiame funkcijų failą

echo router(); // echo aplikacijoj panaudojamas tik viena kartą
