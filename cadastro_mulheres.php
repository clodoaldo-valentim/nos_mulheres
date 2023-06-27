<?php

// Conecte-se ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "catu";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Recuperar os dados do formulário de cadastro de usuários
$nome = $_POST['nome'];
$fone = $_POST['fone'];
$email = $_POST['email'];
$instagram = $_POST['instagram'];
$idade = $_POST['idade'];
$nascimento = $_POST['nascimento'];
$peso = $_POST['peso'];
$altura = $_POST['altura'];
$idade_corporal = $_POST['idade_corporal'];
$peso = str_replace(',', '.', preg_replace('/[^0-9,]/', '', $_POST['peso']));
$altura = str_replace(',', '.', preg_replace('/[^0-9,]/', '', $_POST['altura']));
// Verificar se os dados já existem no banco de dados
$check_query = "SELECT * FROM mulheres WHERE Nome = '$nome'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    header('Location: usuario_ja_existe.html');
    exit;
}

// Inserir os dados no banco de dados
$query = "INSERT INTO mulheres (Nome, Fone, Email, Instagram, Idade, Nascimento, Peso, Altura, Idade_corporal) VALUES ('$nome', '$fone', '$email', '$instagram', $idade, '$nascimento', '$peso', '$altura', '$idade_corporal')";

if (mysqli_query($conn, $query)) {
    header('Location: sucesso.html');
} else {
    header('Location: erro_cad_usuario.html');
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);

?>
