<?php
include 'config.php';
header('Content-Type: application/json');

// Verifica se o parâmetro "nome" foi passado
$nome = isset($_GET['nome']) ? $_GET['nome'] : '';

if (empty($nome)) {
    echo json_encode(["error" => "Parâmetro 'nome' é obrigatório"]);
    exit;
}

// Monta a SQL usando LIKE para busca parcial
$sql = "SELECT id, nome_cliente, cpf, email, data_nasc, numero_celular 
        FROM clientes 
        WHERE nome_cliente LIKE ?";

$stmt = mysqli_prepare($conn, $sql);

$param = "%" . $nome . "%"; // Permite buscar qualquer parte do nome
mysqli_stmt_bind_param($stmt, "s", $param);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$retorno = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $retorno[] = $row;
    }
    echo json_encode($retorno);
} else {
    echo json_encode(["error" => mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
