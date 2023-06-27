<!DOCTYPE html>
<html>
<head>
  <title>Consultar Status do Livro</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="manifest" href="/manifest.json">
    <!--Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script>
      //pwa -  registrar o service worker
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
          console.log('Service worker registered: ', registration);
        }, function(err) {
          console.log('Service worker registration failed: ', err);
        });
      });
    }
  </script>
</head>
<body>
<?php
// Conectar ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "catu";

// Criar conexão
$conn = mysqli_connect($host, $username, $password, $dbname);
// Verificar conexão
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Receber o valor do livro digitado
$nome = $_POST["nome"];

// Consulta de livro por nome
$sql = "SELECT * FROM mulheres WHERE Nome LIKE '%$nome%'";
$result = mysqli_query($conn, $sql);

// Verificar se a consulta retornou algum resultado
if (mysqli_num_rows($result) > 0) {
    // Exibir os resultados da consulta em forma de tabela
    echo "<table>";
    echo "<tr>";
    echo "<th>Número de registro</th>";
    echo "<th>Nome </th>";
    echo "<th>Fone </th>";
    echo "<th>Email</th>";
    echo "<th>Instagram</th>";
    echo "<th>Idade</th>";
    echo "<th>Nascimento</th>";
    echo "<th>Peso</th>";
    echo "<th>Altura</th>";
    echo "<th>Idade_corporal</th>";
    echo "</tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["Código"]."  ". "</td>";
        echo "<td>" . $row["Nome"]. "  "."</td>";
        echo "<td>" . $row["Fone"]."  ". "</td>";
        echo "<td>" . $row["Email"]. "  "."</td>";
        echo "<td>" . $row["Instagram"]. "  "."</td>";
        echo "<td>" . $row["Idade"]. "  "."</td>";
        echo "<td>" . $row["Nascimento"]. "  "."</td>";
        echo "<td>" . $row["Peso"]. "  "."</td>";
        echo "<td>" . $row["Altura"]. "  "."</td>";
        echo "<td>" . $row["Idade_corporal"]. "  "."</td>";
        echo "</tr>";
    }
    echo "</table>"."<br>";
    echo '<a href="consulta.html"><input class="button" type="submit" value="Voltar" style="background-color: rgb(44, 4, 43);width:100px;text-align:center;"></a>';
} else {
    echo "Nenhum resultado encontrado.";
}

// Fechar a conexão
mysqli_close($conn);
?>
</body>
</html>
