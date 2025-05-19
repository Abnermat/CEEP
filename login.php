<?php
session_start();

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "CEEP";

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$usuario = $_POST['usuario'];
$senhaDigitada = $_POST['senha'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuarioDados = $resultado->fetch_assoc();
    if (password_verify($senhaDigitada, $usuarioDados['senha'])) {
        $_SESSION['usuario_id'] = $usuarioDados['id'];
        $_SESSION['nome'] = $usuarioDados['nome'];
        $_SESSION['tipo'] = $usuarioDados['tipo'];
        $_SESSION['logado'] = true;

        // Redireciona com base no tipo de usuário
        if ($usuarioDados['tipo'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($usuarioDados['tipo'] == 'professor') {
            header("Location: professor_dashboard.php");
        } else {
            header("Location: aluno_dashboard.php");
        }
        exit();
    } else {
        echo "Senha incorreta. <a href='login.html'>Tentar novamente</a>";
    }
} else {
    echo "Usuário não encontrado. <a href='login.html'>Tentar novamente</a>";
}
?>