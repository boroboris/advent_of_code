<?php

class Logger
{
    public static function outputLine($message, $info)
    {
        echo "$message: $info<br>";
    }

    public static function hr()
    {
        echo "<hr>";
    }

    public static function error($message, $info)
    {
        echo "<strong>ERROR:</strong> $message: $info<br>";
    }
}