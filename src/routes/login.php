<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->post('/login/usuario',function(Request $request, Response $response){
	
	$login = $request->getParam('login');
	$senha = $request->getParam('senha');


	$sqlLogin =  "SELECT * FROM Usuario WHERE login = '$login' AND senha = '$senha'";


	try
	{
	
		$db = new db();
		$db = $db->connect();

		$stmt = $db->prepare($sqlLogin);


		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':senha', $senha);

		$stmt->execute();
		$retornoLogin = $stmt->fetchAll(PDO::FETCH_OBJ);

		if($retornoLogin){
			return json_encode($retornoLogin);
		}
		else{
			return json_encode("0");
		}

	}
	catch(PDOException $e)
	{
		return json_encode($e->getMessage());
	}

});