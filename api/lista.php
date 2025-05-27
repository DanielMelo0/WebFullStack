<?php
header('Content-Type: application/json');
// Conexão Database com MySqliConnect
$conn = mysqli_connect("nautasoft.com.br", "nautasof_sis", "F1tchg@12", "nautasof_comercial");
  
//$sql = "SELECT * FROM profissionais";

$sql = "
SELECT 
    
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

/*
$sql = "SELECT 
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
    l.pacienteId = 24444
";*/


$result = mysqli_query($conn, $sql);

$retorno = [];

if($result){
while ($row = mysqli_fetch_assoc($result)) {
 
    $retorno[] = $row;

}

echo json_encode($retorno);
}else {
    echo json_encode(["error" => mysqli_error($conn)]);
}


mysqli_close($conn);
          
/*$sql = "SELECT 
            l.pacienteid,
            l.procedimentoId,
            l.medicoId,
            c.nome_cliente AS clientes,
            p.nome_procedimento AS procedimentos,
            m.nome AS profissionais
        FROM laudos l
        INNER JOIN pacientes p ON l.pacienteId = p.Id
        INNER JOIN medicos m ON l.medicoId = m.Id
        INNER JOIN procedimentos pr ON l.procedimentoId = p.Id";


"SELECT * FROM procedimentos"; nome_procedimento
"SELECT * FROM profissionais"; ; nome_cliente
"SELECT 
            l.pacienteid,
            l.procedimentoId,
            l.medicoId,
            c.nome_cliente AS clientes,
            p.nome_procedimento AS procedimentos,
            m.nome AS profissionais
        FROM laudos l
        LEFT JOIN pacientes p ON l.pacienteId = p.Id
        LEFT JOIN medicos m ON l.medicoId = m.Id
        LEFT JOIN procedimentos pr ON l.procedimentoId = p.Id"

        $saql =  "SELECT l.pacienteid, l.procedimentoId, l.medicoId FROM laudos l
WHERE l.pacienteId = 24444 ";
*/


?>