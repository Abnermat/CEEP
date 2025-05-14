<?php
//Conexão com banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "CEEP";

$conn = new mysqli($host,$usuario,$senha,$banco);

//verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

//Recebe do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); //Criptografar a senha

//Insere no banco
$sql = "INSERT INTO usuarios (nome, email, usuario, senha) VALEUS ('$nome', '$email', '$usuario', '$senha')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro realizado com sucesso. <a href='login.html'>Clique aqui para entrar</a>";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>