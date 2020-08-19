<?php
include '../../main.php';
connect_to_database();
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
  $game = create_game($_POST["player_name"], $_POST["color"]);
}
disconnect_from_database();
$data = ["game" => $game];
header('Content-Type: application/json');
echo json_encode($data);