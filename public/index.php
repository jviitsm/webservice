<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../config/db.php';

$app = new \Slim\App;


//Rotas dos clientes
require '../src/routes/clientes.php';
require '../src/routes/cadastro.php';

$app->run();
