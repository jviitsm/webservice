<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



//Cadastro de usuário
$app->post('/usuario/cadastrar',function(Request $request, Response $response){

	//Tabela usuario
	$nome = $request->getParam('nome');
	$sobrenome = $request->getParam('sobrenome');
	$estado = $request->getParam('estado');
	$cidade = $request->getParam('cidade');
	$dir_foto_usuario = $request->getParam('dir_foto_usuario');
	$email = $request->getParam('email');
	$login = $request->getParam('login');
	$senha = $request->getParam('senha');
	$status_login = $request->getParam('status_login');
	$administrador = $request->getParam('administrador');

	//Tabela cidadao
	$sexo = $request->getParam('sexo');
	


	$sqlUsuario = "INSERT INTO Usuario (nome,sobrenome,estado,cidade,dir_foto_usuario,email,login,senha
	,status_login,administrador) VALUES 
	(:nome,:sobrenome,:estado,:cidade,:dir_foto_usuario,:email,:login,:senha,:status_login,:administrador)";
	
	$sqlForeignKey = "SELECT id_usuario from Usuario where login ='$login'";

	$sqlCidadao = "INSERT INTO Cidadao (sexo,fk_usuario_cidadao) VALUES (:sexo,:fk_usuario_cidadao)";

	

	try
	{
		$db = new db();

		$db = $db->connect();

		$stmt = $db->prepare($sqlUsuario);
		$stm2 = $db->prepare($sqlForeignKey);
		$stm3 = $db->prepare($sqlCidadao);

		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':sobrenome', $sobrenome);
		$stmt->bindParam(':estado', $estado);
		$stmt->bindParam(':cidade', $cidade);
		$stmt->bindParam(':dir_foto_usuario', $dir_foto_usuario);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':senha', $senha);
		$stmt->bindParam(':status_login',$status_login);
		$stmt->bindParam(':administrador',$administrador);


	
		$stmt->execute();
		$stmt2 = $db->query($sqlForeignKey);
		
		$fk_usuario_cidadao = $stmt2->fetch(PDO::FETCH_NUM);

		$stm3->bindValue(':sexo',$sexo);
		$stm3->bindValue(':fk_usuario_cidadao',$fk_usuario_cidadao[0]);
		
		$stm3->execute();

		return json_encode($fk_usuario_cidadao);

		
	}
	catch(PDOException $e)
	{
		echo '{"error": {"text": '.$e->getMessage().'}';
			echo '{"notice": {"text": "0"}';
	}
});







$app->get('/usuario/exibir/{id}',function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM Usuario where id_usuario = $id";

	try
	{
		$db = new db();

		$db = $db->connect();


		$stmt = $db->query($sql);
		$usuarios	 = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db  = null;
		return json_encode($usuarios);
	}
	catch(PDOException $e)
	{
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});