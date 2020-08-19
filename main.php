<?php
function connect_to_database() {
  if (!array_key_exists('db_connection', $GLOBALS)) {
    if ($url = getenv('JAWSDB_URL')) {
      $dbparts = parse_url($url);
      $hostname = $dbparts['host'];
      $username = $dbparts['user'];
      $password = $dbparts['pass'];
      $database = ltrim($dbparts['path'], '/');
    } else {
      $hostname = "localhost";
      $username = "root";
      $password = "";
      $database = "chess";
    }
    $db_connection = new mysqli($hostname, $username, $password, $database) or die("Unable to connect to database");
    $db_connection->select_db($database) or die("Unable to select database");
    $GLOBALS["db_connection"] = $db_connection;
  }
}

function disconnect_from_database() {
  if (array_key_exists('db_connection', $GLOBALS)) {
    $GLOBALS["db_connection"]->close();
    $GLOBALS["db_connection"] = null;
  }
}

function generate_random_string($length) {
  $permitted_chars = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
  $result = "";
  for ($i = 0; $i < $length; $i++) {
    $result = $result . substr(str_shuffle($permitted_chars), 0, 1);
  }
  return $result;
}

function get_game($alpha_num_id) {
  $statement = $GLOBALS["db_connection"]->prepare("SELECT * FROM games WHERE alpha_num_id = ? LIMIT 1");
  $statement->bind_param("s", $alpha_num_id);
  $statement->execute();
  $result = $statement->get_result();
  $statement->close();
  if ($result->num_rows == 0) {
    return false;
  }
  return $result->fetch_assoc();
}

function find_new_game_alpha_num_id() {
  $length = 2;
  do {
    $length += 0.2;
    $alpha_num_id = generate_random_string(floor($length));
  } while (get_game($alpha_num_id));
  return $alpha_num_id;
}

function create_game($player_name, $color) {
  $alpha_num_id = find_new_game_alpha_num_id();
  $player_key = generate_random_string(5);
  $player = $color == 'white' ? 'a' : $color == 'black' ? 'b' : random_int(0, 1) ? "a" : "b";

  $statement = $GLOBALS["db_connection"]->prepare("
    INSERT INTO games(alpha_num_id, player_${player}_name, player_${player}_key)
    values(?, ?, ?);
  ");
  $statement->bind_param("sss", $alpha_num_id, $player_name, $player_key);
  $game = $statement->execute();
  $statement->close();
  return get_game($alpha_num_id);
}
