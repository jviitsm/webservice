<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



//Mostrar todos os clientes em Json
$app->Get('/clientes',function(Request $request, Response $response){
	$sql = "SELECT * FROM clientes";

	try
	{
		$db = new db();

		$db = $db->connect();


		$stmt = $db->query($sql);
		$clientes2 = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db  = null;
		$response->withJson($clientes2);
	}
	catch(PDOException $e)
	{
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Mostrar cliente por ID
$app->Get('/clientes/{id}',function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM clientes where id = $id";

	try
	{
		$db = new db();

		$db = $db->connect();


		$stmt = $db->query($sql);
		$clienteid = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db  = null;
		echo json_encode($clienteid);
	}
	catch(PDOException $e)
	{
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Adicionar cliente
$app->post('/clientes/add',function(Request $request, Response $response){
	
	$login = $request->getParam('login');
	$senha = $request->getParam('senha');
	$cidade = $request->getParam('cidade');

	$sql = "INSERT INTO clientes (login,senha,cidade) VALUES 
	(:login,:senha,:cidade)";

	try
	{
		$db = new db();

		$db = $db->connect();

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':senha', $senha);
		$stmt->bindParam(':cidade', $cidade);

		$stmt->execute();

		echo '{"notice": {"text": "Cliente Adicionado"}';

	}
	catch(PDOException $e)
	{
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});