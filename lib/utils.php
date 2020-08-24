<?php
class Utils
{
    public static function generate_random_string($length)
    {
        $permitted_chars = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $result = $result . substr(str_shuffle($permitted_chars), 0, 1);
        }
        return $result;
    }
}
