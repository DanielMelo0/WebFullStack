<?php
header('Content-Type: application/json');

// Conexão com o banco
$conn = mysqli_connect("nautasoft.com.br", "nautasof_sis", "F1tchg@12", "nautasof_comercial");

if (!$conn) {
    echo json_encode(["error" => "Erro na conexão: " . mysqli_connect_error()]);
    exit;
}

// Query para buscar os clientes não excluídos
$sql = "SELECT id, nome_cliente, cpf, email, data_nasc, numero_celular, excluido FROM clientes WHERE excluido = 0";

$result = mysqli_query($conn, $sql);

$retorno = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $retorno[] = $row;
    }
    echo json_encode($retorno);
} else {
    echo json_encode(["error" => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
