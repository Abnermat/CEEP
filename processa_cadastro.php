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
$tipo = $_POST['tipo'];

//verifica duplicidade de email ou usuario
$verifica = $conn->prepare("SELECT * FROM usuarios WHERE email = ? OR usuario = ?");
$verifica->bind_param("ss", $email, $usuario);
$verifica->execute();
$resultado = $verifica->get_result();

if ($resultado->num_rows > 0) {
    echo "Erro: e-mail ou usuário já cadastrados. <a href='cadastro.html>Voltar</a>";
    exit();
}

//Insere no banco
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, usuario, senha, tipo) VALEUS (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $usuario, $senha, $tipo)

if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso. <a href='login.html'>Clique aqui para entrar</a>";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>