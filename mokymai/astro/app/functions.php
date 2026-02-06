<?php

function router()
{

    $uri = $_SERVER['REQUEST_URI']; // Gauname užklausos URI
    $uri = str_replace(INSTALL_DIR, '', $uri); // Pašaliname diegimo katalogą iš URI
    $uri = explode('/', $uri); // Padalijame URI į dalis
    $method = $_SERVER['REQUEST_METHOD']; // Gauname užklausos metodą

    if ('GET' == $method && $uri[0] == '') {
        return homeController(); // Grąžina pagrindinį šabloną
    }
    if ('GET' == $method && $uri[0] == 'note') {
        return noteController(); // Grąžina pagrindinį šabloną
    }
    if ('GET' == $method && $uri[0] == 'create') {
        return createController(); // Grąžina pagrindinį šabloną
    }
    if ('POST' == $method && $uri[0] == 'store') {
        return storeController(); // Grąžina pagrindinį šabloną
    }
}




function homeController()
{

    $pageData = [];
    $pageData['title'] = 'Home';

    $notes = json_decode(file_get_contents(DIR . 'data/notes.json'), true) ?? []; // Gauname esamus užrašus iš failo, jei failas tuščias, grąžina tuščią masyvą
    $pageData['notes'] = $notes; // Pridedame užrašus į puslapio duomenis

    return view('home', $pageData); // Grąžina pagrindinį šabloną su duomenimis
}
function noteController()
{
    return view('note'); // Grąžina pagrindinį šabloną su duomenimis
}
function createController()
{

    $pageData = [];
    $pageData['title'] = 'Create Note';

    return view('create', $pageData); // Grąžina pagrindinį šabloną su duomenimis
}

function storeController()
{

    $storeData['date'] = $_POST['date'] ?? '';
    $storeData['title'] = $_POST['title'] ?? '';
    $storeData['content'] = $_POST['content'] ?? '';
    $storeData['id'] = rand(100000000, 999999999); // Sugeneruojame atsitiktinį ID

    $notes = json_decode(file_get_contents(DIR . 'data/notes.json'), true) ?? []; // Gauname esamus užrašus iš failo, jei failas tuščias, grąžina tuščią masyvą
    $notes[] = $storeData; // Pridedame naują užrašą į masyvą
    file_put_contents(DIR . 'data/notes.json', json_encode($notes, JSON_PRETTY_PRINT)); // Išsaugome atnaujintą masyvą į failą

    header('Location: ' . URL); // Peradresuojame į pagrindinį puslapį
    return ''; // Grąžiname tuščią stringą, nes header() jau išsiuntė atsakymą
}




function view(string $template, array $data = [])
{
    extract($data); // Išskleidžiame duomenis į atskirus kintamuosius
    // viskas bus buferinimas, tai reiškia, kad viskas, kas bus išspausdinta, bus saugoma atmintyje, o ne iškart išsiųsta į naršyklę
    ob_start(); // Pradeda buferį
    require DIR . 'view/top.php'; // Įtraukia bendrą šabloną
    require DIR . "view/{$template}.php"; // Įtraukia šablono failą
    require DIR . 'view/bottom.php'; // Įtraukia bendrą šabloną
    return ob_get_clean(); // Grąžina buferio turinį ir išvalo buferį
}
