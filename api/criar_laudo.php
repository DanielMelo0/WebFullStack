<?php
include 'config.php';

header('Content-Type: application/json');

// Receber dados via POST
$nomeCliente = $_POST['nome_cliente'] ?? '';
$nomeProcedimento = $_POST['nome_procedimento'] ?? '';
$nomeMedico = $_POST['nome_medico'] ?? '';

// Validação simples
if (empty($nomeCliente) || empty($nomeProcedimento) || empty($nomeMedico)) {
    echo json_encode(['error' => 'Preencha todos os campos.']);
    exit;
}

// Função para inserir ou obter o ID existente
function getOrCreate($conn, $tabela, $campoNome, $valorNome) {
    $sqlSelect = "SELECT id FROM $tabela WHERE $campoNome = ?";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bind_param("s", $valorNome);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        $stmt->close();
        return $id;
    }
    $stmt->close();

    $sqlInsert = "INSERT INTO $tabela ($campoNome) VALUES (?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("s", $valorNome);
    if ($stmt->execute()) {
        $newId = $stmt->insert_id;
        $stmt->close();
        return $newId;
    } else {
        $stmt->close();
        return false;
    }
}

// Obter ou criar cliente
$clienteId = getOrCreate($conn, 'clientes', 'nome_cliente', $nomeCliente);
if (!$clienteId) {
    echo json_encode(['error' => 'Erro ao criar cliente.']);
    exit;
}

// Obter ou criar procedimento
$procedimentoId = getOrCreate($conn, 'procedimentos', 'nome_procedimento', $nomeProcedimento);
if (!$procedimentoId) {
    echo json_encode(['error' => 'Erro ao criar procedimento.']);
    exit;
}

// Obter ou criar médico
$medicoId = getOrCreate($conn, 'profissionais', 'nome', $nomeMedico);
if (!$medicoId) {
    echo json_encode(['error' => 'Erro ao criar médico.']);
    exit;
}

// Inserir Laudo
$dataAtual = date('Y-m-d');

$sqlLaudo = "INSERT INTO laudos (pacienteId, procedimentoId, medicoId, data, excluido) 
             VALUES (?, ?, ?, ?, 0)";

$stmt = $conn->prepare($sqlLaudo);
$stmt->bind_param("iiis", $clienteId, $procedimentoId, $medicoId, $dataAtual);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Laudo criado com sucesso!',
        'laudo_id' => $stmt->insert_id,
        'cliente_id' => $clienteId,
        'procedimento_id' => $procedimentoId,
        'medico_id' => $medicoId
    ]);
} else {
    echo json_encode(['error' => 'Erro ao criar laudo.']);
}

$stmt->close();
$conn->close();
?>
