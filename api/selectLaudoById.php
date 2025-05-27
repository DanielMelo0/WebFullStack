<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID não fornecido"]);
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT 
    l.id AS idLaudo,
    l.pacienteId, 
    c.nome_cliente,
    l.procedimentoId, 
    p.nome_procedimento,
    l.medicoId, 
    m.nome AS nome_medico
FROM 
    laudos l
LEFT JOIN 
    clientes c ON l.pacienteId = c.id
LEFT JOIN 
    procedimentos p ON l.procedimentoId = p.id
LEFT JOIN 
    profissionais m ON l.medicoId = m.id
WHERE 
    l.id = ?
LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Laudo não encontrado"]);
}

$stmt->close();
$conn->close();
?>
