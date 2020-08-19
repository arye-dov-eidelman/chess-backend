<?php
// route: create game
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
  include '../../main.php';
  connect_to_database();
  $game = create_game($_POST["player_name"], $_POST["color"]);
  disconnect_from_database();
  $data = ["game" => $game];
  header('Content-Type: application/json');
  echo json_encode($data);

// route: unknown
} else {
  http_response_code(404);
  echo json_encode(["error" => "404 at " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI']]);
}