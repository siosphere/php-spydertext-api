<?php
namespace SpyderText\Base;

class FileLogger implements ILogger
{
    public function log(string $message)
    {
        file_put_contents("debug.log", $message, FILE_APPEND);
    }
}