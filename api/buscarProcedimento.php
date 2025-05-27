<?php
include 'config.php';
header('Content-Type: application/json');

// Verifica se o parâmetro "nome" foi passado
$nome = isset($_GET['nome']) ? trim($_GET['nome']) : '';

if (empty($nome)) {
    echo json_encode(["error" => "Parâmetro 'nome' é obrigatório"]);
    exit;
}

$sql = "SELECT * FROM procedimentos WHERE nome_procedimento LIKE ? AND excluido = 0";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    $param = "%" . $nome . "%";
    mysqli_stmt_bind_param($stmt, "s", $param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $procedimentos = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $procedimentos[] = $row;
    }

    echo json_encode($procedimentos);
} else {
    echo json_encode(["error" => "Erro na preparação da consulta: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
