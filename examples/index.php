<?php 
use AdinanCenci\SimpleRequest\Request;

//-----------------------------

error_reporting(E_ALL);
ini_set('display_errors', 1);

//-----------------------------

require '../vendor/autoload.php';

//-----------------------------

$request  = new Request('https://swapi.dev/api/people/1');
$response = $request->request();
$data     = json_decode($response->body, true);

echo '<pre>';
print_r($data);
echo '</pre>';
