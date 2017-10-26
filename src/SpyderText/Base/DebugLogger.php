<?php
namespace SpyderText\Base;

class DebugLogger implements ILogger
{
    public function log(string $message) {
        var_dump($message);
    }
}