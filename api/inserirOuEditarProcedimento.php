<?php
header('Content-Type: application/json');
include 'config.php'; // Conexão com o banco

// Recebe os dados enviados via POST
$id = $_POST['id_cliente'] ?? ''; // <-- Recebe o ID (se estiver editando)
$nome_cliente = $_POST['nome_cliente'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$email = $_POST['email'] ?? '';
$data_nasc = $_POST['data_nasc'] ?? '';
$numero_celular = $_POST['numero_celular'] ?? '';

// Validação simples
if (empty($nome_cliente) || empty($cpf) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos obrigatórios.']);
    exit;
}

if ($id == '') {
    // 🔥 INSERIR
    $stmt = $conn->prepare("INSERT INTO clientes (nome_cliente, cpf, email, data_nasc, numero_celular, excluido) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("sssss", $nome_cliente, $cpf, $email, $data_nasc, $numero_celular);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Cliente cadastrado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar cliente: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    // 🔥 EDITAR
    $stmt = $conn->prepare("UPDATE clientes SET nome_cliente=?, cpf=?, email=?, data_nasc=?, numero_celular=? WHERE id=?");
    $stmt->bind_param("sssssi", $nome_cliente, $cpf, $email, $data_nasc, $numero_celular, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Cliente atualizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar cliente: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
