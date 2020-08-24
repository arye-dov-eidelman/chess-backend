<?php
class Game
{
    public static function get($alpha_num_id)
    {
        $result = (new SQLStatement(
            "SELECT * FROM games WHERE alpha_num_id = ? LIMIT 1",
            "s", $alpha_num_id
        ))->execute();
        if ($result->num_rows == 0) {
            return false;
        }
        return $result->fetch_assoc();
    }

    public static function create($player_name, $color)
    {
        $alpha_num_id = self::find_available_alpha_num_id();
        $player_key = Utils::generate_random_string(5);
        $player = $color == 'white' ? 'a' : ($color == 'black' ? 'b' : (random_int(0, 1) ? "a" : "b"));

        $game = (new SQLStatement(
            "INSERT INTO games(
                alpha_num_id, player_${player}_name, player_${player}_key
            ) values(?, ?, ?);",
            "sss", $alpha_num_id, $player_name, $player_key
        ))->execute();
        return self::get($alpha_num_id);
    }

    private static function find_available_alpha_num_id()
    {
        $length = 3;
        do {
            $length += 0.2;
            $alpha_num_id = Utils::generate_random_string(floor($length));
        } while (self::get($alpha_num_id));
        return $alpha_num_id;
    }
}
