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
}


// Conexão à BD
$host="db.ist.utl.pt"; 								// o MySQL esta disponivel nesta maquina
$user="ist176531"; 									// -> substituir pelo nome de utilizador
$password="pgie8876"; 								// -> substituir pela password dada pelo mysql_reset
$dbname = $user; 									// a BD tem nome identico ao utilizador
$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");


//regista a pessoa no leilão. Exemplificativo apenas.....
$sql3= "SELECT * FROM concorrente WHERE pessoa=$nif";
$result3=$connection->query($sql3);
foreach ($result3 as $row3) {
	$aux3=$row3["leilao"];
	$variavel=0;
	if($lid==$aux3){
		$variavel=1;
	}

}
if($lid==0){

}
else{
	if($variavel==0){
		$sql = "INSERT INTO concorrente (pessoa, leilao) VALUES ($nif, $lid)";
		$result = $connection->query($sql);
		if (!$result) {
			echo("<p> Pessoa nao registada: Erro na Query:($sql) <p>");
		exit();
		}

		echo("<p> Pessoa ($username), nif ($nif) Registada no leilao ($lid)</p>\n");
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
<form action="lance.php" method="post">
<p>Introduza o lid do leilao: <input type="text" name="lid" /></p>
<p>Introduza o seu lance: <input type="text" name="novolance" /></p>
<p><input type="submit" value="Licitar" /></p>
</form>



<form action="lance.php" method="post">
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
$sql2 = "SELECT * FROM leilaor WHERE not exists( SELECT * FROM concorrente WHERE pessoa=$nif and lid=leilao) group by lid";
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

<form action="leilao.php" method="post">
<p>Para uma nova inscricao, introduza o ID que pretende: <input type="text" name="lid" /></p>
<p><input type="submit" /></p>
</form>



<form action="login.htm" method="post">
<p><input type="submit" value="Logout"/></p>
</form>
</body>
</html>