<?php
header('Content-Type: application/json');
include 'config.php';

$sql = "SELECT * FROM procedimentos WHERE excluido = 0";
$result = $conn->query($sql);

$procedimentos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $procedimentos[] = $row;
    }
}

echo json_encode($procedimentos);
$conn->close();
?>
