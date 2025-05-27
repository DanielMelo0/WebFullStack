<?php
include 'config.php';

header('Content-Type: application/json');

// Verifica se foi passado um ID via GET
$pacienteId = isset($_GET['pacienteId']) ? intval($_GET['pacienteId']) : 0;

// Prepara a SQL com interpolação segura
$sql = "

SELECT 
    l.idLaudo,
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
";

// Adiciona o filtro de paciente se o ID foi enviado
if ($pacienteId > 0) {
    $sql .= " WHERE l.pacienteId = $pacienteId";
}

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
