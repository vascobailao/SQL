<html>
<body>
<?php

// inicia sessão para passar variaveis entre ficheiros php
session_start();
$username = $_SESSION['username'];
$nif = $_SESSION['nif'];


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
	$novolance=test_input($_POST["novolance"]);
}


// Conexão à BD
$host="db.ist.utl.pt"; 								// o MySQL esta disponivel nesta maquina
$user="ist176531"; 									// -> substituir pelo nome de utilizador
$password="pgie8876"; 								// -> substituir pela password dada pelo mysql_reset
$dbname = $user; 									// a BD tem nome identico ao utilizador
$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");


if($lid==0){
}
else{
	$sql4="INSERT INTO lance (pessoa, leilao, valor) VALUES ($nif, $lid, $novolance)";
	$result4=$connection->query($sql4);
	if (!$result4) {
		echo("<p> Lance nao registado: Erro na Query:($sql4) <p>");
	exit();
	}
	echo("<p> Pessoa ($username), nif ($nif) leilao ($lid) Lance ($novolance) </p>\n");
}

$sql3="SELECT CURDATE()";
	$result3=$connection->query($sql3);
	foreach ($result3 as $rowe) {
		$datatual=$rowe["CURDATE()"];

	}	

$presente=strtotime($datatual);
$presente2=date('Y-m-d', $presente);


echo("<p>Leiloes Inscritos licitados</p>\n");

echo("<table border=\"1\">\n");
echo("<tr><td>leilao</td><td>licitacao mais alta</td><td>tempo restante</td></tr>\n");
$sql2 = "SELECT E.leilao,R.nrdias, R.dia, max(E.valor) as valor from lance E, leilaor R where E.leilao=R.lid and exists ( select * from concorrente C where C.pessoa=$nif and E.leilao=C.leilao) group by leilao";
$result2 = $connection->query($sql2);
foreach ($result2 as $row2 ) {
	echo("<tr><td>");
	echo($row2["leilao"]); echo("</td><td>");
	echo($row2["valor"]); echo("</td><td>"); 
	$datainicio=$row2["dia"];
	$validade="+ " . $row2["nrdias"] . " day";
	$timestamp=strtotime($datainicio);
	$timestamp2=strtotime($validade,$timestamp); 
	$datafinal=date('Y-m-d', $timestamp2);
	if($presente > $timestamp2){
	echo("Leilao Encerrado \n");
	}
	else{
		$sql="SELECT datediff ('$datafinal','$presente2') as diferenca";
		$res=$connection->	query($sql);
		foreach ($res as $roww) {
			$restante=$roww["diferenca"];
			echo($restante);
		}		
	}
}	

echo("</table>\n");

echo("\n");
echo("\n");
echo("\n");
echo("\n");


echo("<p>Leiloes Inscritos Nao Licitados</p>\n");

echo("<table border=\"1\">\n");
echo("<tr><td>dia</td><td>nrleilaonodia</td><td>nif</td><td>nrdias</td><td>lid</td></tr>\n");
$sql2 = " SELECT * from leilaor R where exists (select * from concorrente C where C.pessoa=$nif and C.leilao=R.lid and not exists (select * from lance E where C.pessoa=E.pessoa and E.leilao=R.lid)) group by lid";
$result2 = $connection->query($sql2);
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
<form action="lance.php" method="post">
<p>Introduza o lid do leilao: <input type="text" name="lid" /></p>
<p>Introduza o seu lance: <input type="text" name="novolance" /></p>
<p><input type="submit" value="Licitar" /></p>
</form>

<?php

echo("\n");
echo("\n");
echo("\n");
echo("\n");


?>

<form action="leilao.php" method="post">
<p><input type="submit" value="Inscricao em leiloes" /></p>
</form>

<form action="login.htm" method="post">
<p><input type="submit" value="Logout"/></p>
</form>
</body>
</html>