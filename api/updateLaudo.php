<?php
include 'config.php';

$id_laudo = $_POST['id_laudo'];
$id_cliente = $_POST['id_cliente'];
$nome_cliente = trim($_POST['nome_cliente']);
$nome_procedimento = trim($_POST['nome_procedimento']);
$nome_medico = trim($_POST['nome_medico']);

$conn->begin_transaction();

try {
    // Atualizar cliente
    $stmt = $conn->prepare("UPDATE clientes SET nome_cliente = ? WHERE id = ?");
    $stmt->bind_param("si", $nome_cliente, $id_cliente);
    $stmt->execute();
    $stmt->close();

    // Atualizar procedimento
    $stmt = $conn->prepare("
        UPDATE procedimentos 
        INNER JOIN laudos ON laudos.idProcedimento = procedimentos.id
        SET procedimentos.nome_procedimento = ?
        WHERE laudos.idLaudo = ?");
    $stmt->bind_param("si", $nome_procedimento, $id_laudo);
    $stmt->execute();
    $stmt->close();

    // Atualizar médico
    $stmt = $conn->prepare("
        UPDATE profissionais 
        INNER JOIN laudos ON laudos.idMedico = profissionais.id
        SET profissionais.nome = ?
        WHERE laudos.idLaudo = ?");
    $stmt->bind_param("si", $nome_medico, $id_laudo);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo json_encode(["status" => "success"]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}

$conn->close();
?>
