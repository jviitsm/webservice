<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Cadastro de usuário
$app->post('/usuario/cadastrar/cidadao',function(Request $request, Response $response){

	//Tabela Login
	$email = $request->getParam('email');
	$login = $request->getParam('login');
	$senha = $request->getParam('senha');
	$status_login = $request->getParam('status_login');
	$administrador = $request->getParam('administrador');


	//Tabela cidadao
	$sexo = $request->getParam('sexo');
	$nome = $request->getParam('nome');
	$sobrenome = $request->getParam('sobrenome');
	$estado = $request->getParam('estado');
	$cidade = $request->getParam('cidade');
	$dir_foto_usuario = $request->getParam('dir_foto_usuario');





	$sqlLogin = "INSERT INTO Login (email,login,senha,status_login,administrador) VALUES 
	(:email,:login,:senha,:status_login,:administrador)"; 
	
	$sql_fk_login_cidadao = "SELECT id_login from Login where login ='$login'";

	$sqlCidadao = "INSERT INTO Cidadao (sexo,nome,sobrenome,estado,cidade,dir_foto_usuario,fk_login_cidadao) VALUES (:sexo,:nome,
	:sobrenome,:estado,:cidade,:dir_foto_usuario,:fk_login_cidadao)";

	
	try
	{
		$db = new db();

		$db = $db->connect();

		$stmt = $db->prepare($sqlLogin);
		$stm2 = $db->prepare($sql_fk_login_cidadao);
		$stm3 = $db->prepare($sqlCidadao);

		$stmt->bindParam(':email',$email);
		$stmt->bindParam(':login',$login);
		$stmt->bindParam(':senha',$senha);
		$stmt->bindParam(':status_login',$status_login);
		$stmt->bindParam(':administrador',$administrador);


	
		$stmt->execute();
		$stmt2 = $db->query($sql_fk_login_cidadao);
		
		$fk_login_cidadao = $stmt2->fetch(PDO::FETCH_NUM);

		$stm3->bindParam(':sexo',$sexo);
		$stm3->bindParam(':nome',$nome);
		$stm3->bindParam(':sobrenome',$sobrenome);
		$stm3->bindParam(':estado',$estado);
		$stm3->bindParam(':cidade',$cidade);
		$stm3->bindParam(':dir_foto_usuario',$dir_foto_usuario);
		$stm3->bindValue(':fk_login_cidadao',$fk_login_cidadao[0]);
		
		$stm3->execute();

		

		
	}
	catch(PDOException $e)
	{
		return json_encode($e->getMessage());
	}
});




//Cadastrar Usuario Empresa
$app->post('/usuario/cadastrar/empresa',function(Request $request, Response $response){

	//Tabela Login
	$email = $request->getParam('email');
	$login = $request->getParam('login');
	$senha = $request->getParam('senha');
	$status_login = $request->getParam('status_login');
	$administrador = $request->getParam('administrador');


	//Tabela Empresa
	$cnpj = $request->getParam('cnpj');
	$razao_social = $request->getParam('razao_social');
	$nome_fantasia = $request->getParam('nome_fantasia');
	$estado = $request->getParam('estado');
	$cidade = $request->getParam('cidade');
	$dir_foto_usuario = $request->getParam('dir_foto_usuario');



	//SQLS

	$sqlLogin = "INSERT INTO Login (email,login,senha,status_login,administrador) VALUES 
	(:email,:login,:senha,:status_login,:administrador)"; 

	$sql_fk_login_empresa = "SELECT id_login from Login where login ='$login'";

	$sqlEmpresa = "INSERT INTO Empresa (cnpj,razao_social,nome_fantasia,estado,cidade,dir_foto_usuario,fk_login_empresa) VALUES 
	(:cnpj,:razao_social,:nome_fantasia,:estado,:cidade,:dir_foto_usuario,:fk_login_empresa)";


	try
		{
			$db = new db();

			$db = $db->connect();

			$stmt = $db->prepare($sqlLogin);
			$stm2 = $db->prepare($sql_fk_login_empresa);
			$stm3 = $db->prepare($sqlEmpresa);

			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':login',$login);
			$stmt->bindParam(':senha',$senha);
			$stmt->bindParam(':status_login',$status_login);
			$stmt->bindParam(':administrador',$administrador);


		
			$stmt->execute();
			$stmt2 = $db->query($sql_fk_login_empresa);
			
			$fk_login_empresa = $stmt2->fetch(PDO::FETCH_NUM);

			$stm3->bindParam(':cnpj',$cnpj);
			$stm3->bindParam(':razao_social',$razao_social);
			$stm3->bindParam(':nome_fantasia',$nome_fantasia);
			$stm3->bindParam(':estado',$estado);
			$stm3->bindParam(':cidade',$cidade);
			$stm3->bindParam(':dir_foto_usuario',$dir_foto_usuario);
			$stm3->bindValue(':fk_login_empresa',$fk_login_empresa[0]);
			
			$stm3->execute();

			

			
		}
		catch(PDOException $e)
		{
			return json_encode($e->getMessage());
		}
	});



//Exibir cidadao por id
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
		if($usuarios){
			return json_encode($usuarios);
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
//Excluir cidadao por id
$app->get('/usuario/excluir/{id}',function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$sql = "DELETE FROM Usuario where id_usuario = $id";

	try
	{
		$db = new db();

		$db = $db->connect();


		$stmt = $db->query($sql);
		$db  = null;
		return json_encode(1);
	}
	catch(PDOException $e)
	{
		return json_encode($e->getMessage());
	}

});