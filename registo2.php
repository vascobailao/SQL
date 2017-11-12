Registo.php
<html>
<body>
<?php

// inicia sessão para passar variaveis entre ficheiros php
session_start();

// Função para limpar os dados de entrada
function test_input($data) {
 	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// Carregamento das variáveis username e pin do form HTML através do metodo POST;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 	$username = test_input($_POST["username"]);
 	$pin = test_input($_POST["pin"]);
 	$dia = test_input($_POST["dia"]);
 	$mes = test_input($_POST["mes"]);
 	$ano = test_input($_POST["ano"]);
}

// passa variaveis para a sessao;
$nif=$_SESSION['nif'];
$_SESSION['username'] = $username;
$_SESSION['nif'] = $nif;
$_SESSION['dia']=$dia;
$_SESSION['mes'] =$mes;
$_SESSION['ano']=$ano;

 echo("<p>Valida Pin da Pessoa $username</p>\n");

 // Variáveis de conexão à BD
$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist176531"; // -> substituir pelo nome de utilizador
$password="pgie8876"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador
echo("<p>Projeto Base de Dados Parte II</p>\n");
$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");


$datasessao=$ano."-".$mes."-".$dia;


echo("<p>Leiloes Ativos na data pretendida</p>\n");
// Apresenta os leilões
$sql = "SELECT R.dia, R.nrleilaonodia, R.nif, R.lid, L.nome, L.valorbase  from leilaor R, leilao L where R.dia='$datasessao' and R.dia=L.dia and R.nrleilaonodia=L.nrleilaonodia and R.nif=L.nif group by R.lid";
$result = $connection->query($sql);
echo("<table border=\"1\">\n");
echo("<tr><td>ID</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>valorbase</td></tr>\n");
$idleilao = 0;
foreach($result as $row){
$idleilao = $idleilao +1;
	echo("<tr><td>");
	echo($row["lid"]); echo("</td><td>");
	echo($row["nif"]); echo("</td><td>");
	echo($row["dia"]); echo("</td><td>");
	echo($row["nrleilaonodia"]); echo("</td><td>");
	echo($row["nome"]); echo("</td><td>");
	echo($row["valorbase"]); 
}

echo("</table>\n");


?>

<form action="leilao2.php" method="post"> 
<h2>Escreva os ID's dos leiloes que quer registar (separados por um espaco)</h2>
<p>ID's : <input type="text" name="ids" /> </p>
<p><input type="submit" value="Registar"/></p>
</form>

<form action="leilao2.php" method="post">
<p><input type="submit" value="Avancar para a area de leiloes registados"/></p>
</form>

<form action="login2.htm" method="post">
<p><input type="submit" value="Logout"/></p>
</form>
</body>
</html>
