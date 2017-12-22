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
        echo "<p style='color: red'>ERROR:</p> $message: $info<br>";
    }

    public static function success($info)
    {
        echo "<label style='color: green'> success:</label> $info<br>";
    }
}