<html>
<body>
<?php

// inicia sessão para passar variaveis entre ficheiros php
session_start();
$username = $_SESSION['username'];
$nif = $_SESSION['nif'];
$dia=$_SESSION['dia'];
$mes=$_SESSION['mes'];
$ano=$_SESSION['ano'];

$datasessao=$ano."-".$mes."-".$dia;
$datas=date('Y-m-d', strtotime($datasessao));

// Função para limpar os dados de entrada
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
// Carregamento das variáveis username e pin do form HTML através do metodo POST;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$lid = test_input($_POST["lid"]);
	$ids=test_input($_POST["ids"]);
	//$tamanho=test_input($_POST["numero"]);
}


// Conexão à BD
$host="db.ist.utl.pt"; 								// o MySQL esta disponivel nesta maquina
$user="ist176531"; 									// -> substituir pelo nome de utilizador
$password="pgie8876"; 								// -> substituir pela password dada pelo mysql_reset
$dbname = $user; 									// a BD tem nome identico ao utilizador
$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");

$_SESSION['username'] = $username;
$_SESSION['nif'] = $nif;


$array=explode(" ", $ids);

$variavel=0;

// //regista a pessoa no leilão. Exemplificativo apenas.....
// $sql3= "SELECT * FROM concorrente WHERE pessoa=$nif";
// $result3=$connection->query($sql3);
// foreach ($result3 as $row3) {
// 	$aux3=$row3["leilao"];
// 	foreach ($array as $valor) {
// 		$id=$valor;
// 		if($id==$aux3){
// 			$variavel=1;
// 		}
// 	}

// }


// //regista a pessoa no leilão. Exemplificativo apenas.....
// $sql3= "SELECT * FROM leilaor";
// $result3=$connection->query($sql3);
// foreach ($result3 as $row3) {
// 	$aux3=$row3["lid"];
// 	foreach ($array as $valor) {
// 		$id=$valor;
// 		if($id!=$aux3){
// 			$variavel=1;
// 		}
// 	}

// }

if($ids==0){

}
else{ 
			try {
    		// First of all, let's begin a transaction
			$resultado=0;
    		$connection->beginTransaction();
    		foreach ($array as $lid) {
    			$lidatual=$lid;
    			$sql="SELECT * from leilaor where lid=$lidatual";
    			$result=$connection->query($sql);
    			foreach ($result as $data) {
    				$dataleilao=$data["dia"];
    				if($datas!=$dataleilao){
    					$resultado=1;
    				}
    			 }
    		}
    	

   			 // A set of queries; if one fails, an exception should be thrown
    		if($resultado==0){
    			foreach ($array as $valor) {
    				if($variavel!=1){
						$id=$valor;
						$sql4="INSERT into concorrente (pessoa,leilao) values ($nif, $id)";
						$result4=$connection->query($sql4);
						if(!$result4){
							throw new Exception($connection->error);
							
						}
					}
				}
			}

		


   		 // $db->query('first query');
   		// $db->query('second query');
    	// $db->query('third query');

    	// If we arrive here, it means that no exception was thrown
    	// i.e. no query has failed, and we can commit the transaction
   	 	$connection->commit();
		} catch (Exception $e) {
    		// An exception has been thrown
    		// We must rollback the transaction
   		 $connection->rollback();
		}
	}

	


echo("<p>Leiloes Inscritos</p>\n");

echo("<table border=\"1\">\n");
echo("<tr><td>dia</td><td>nrleilaonodia</td><td>nif</td><td>nrdias</td><td>lid</td></tr>\n");
$sql2 = "SELECT * FROM leilaor, concorrente WHERE pessoa=$nif and lid = leilao";
$result2 = $connection->query($sql2);
foreach ($result2 as $row2 ) {
	$aux=$row2["lid"];
	echo("<tr><td>");
	echo($row2["dia"]); echo("</td><td>");
	$data=$row2["dia"];
	echo($row2["nrleilaonodia"]); echo("</td><td>");
	echo($row2["nif"]); echo("</td><td>");
	echo($row2["nrdias"]); echo("</td><td>");
	echo($row2["lid"]); //echo("</td><td>");
}
echo("</table>\n");

echo("\n");
echo("\n");
echo("\n");
echo("\n");

?>
<form action="lance2.php" method="post">
<p>Introduza o lid do leilao: <input type="text" name="lid" /></p>
<p>Introduza o seu lance: <input type="text" name="novolance" /></p>
<p><input type="submit" value="Licitar" /></p>
</form>



<form action="lance2.php" method="post">
<p><input type="submit" value="Avancar para a pagina de lances"/></p>
</form>

<?php

echo("\n");
echo("\n");
echo("\n");
echo("\n");


echo("<p>Leiloes Nao Inscritos</p>\n");

echo("<table border=\"1\">\n");
echo("<tr><td>dia</td><td>nrleilaonodia</td><td>nif</td><td>nrdias</td><td>lid</td></tr>\n");
$sql2 = "SELECT * FROM leilaor R WHERE R.dia='$datasessao' and not exists( SELECT * FROM concorrente C WHERE C.pessoa=$nif and R.lid=C.leilao) group by lid";
$result2 = $connection->query($sql2);
//($sql3 = "SELECT"
foreach ($result2 as $row2 ) {
	$aux=$row2["lid"];
	echo("<tr><td>");
	echo($row2["dia"]); echo("</td><td>");
	echo($row2["nrleilaonodia"]); echo("</td><td>");
	echo($row2["nif"]); echo("</td><td>");
	echo($row2["nrdias"]); echo("</td><td>"); 
	echo($row2["lid"]); //echo("</td><td>");
}
echo("</table>\n");


?>

<form action="leilao2.php" method="post">
<p>Para uma nova inscricao, introduza os ID's que pretende (separados por um espaco): <input type="text" name="ids" /></p>
<p><input type="submit" /></p>
</form>

<form action="dataleilao.php" method="post">
<p><input type="submit" value="Mudar data leilao" /></p>
</form>

<form action="login2.htm" method="post">
<p><input type="submit" value="Logout"/></p>
</form>
</body>
</html>