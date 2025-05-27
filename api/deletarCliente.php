<?php
include 'config.php'; // Conexão com o banco


header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Cliente removido com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao remover cliente.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID não informado.']);
}

$conn->close();
?>
