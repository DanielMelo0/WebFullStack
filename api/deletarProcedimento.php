<?php
header('Content-Type: application/json');
include 'config.php';

$id = $_GET['id'] ?? '';

if ($id == '') {
    echo json_encode(['status' => 'error', 'message' => 'ID inválido']);
    exit;
}

$stmt = $conn->prepare("UPDATE procedimentos SET excluido = 1 WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Procedimento deletado com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
