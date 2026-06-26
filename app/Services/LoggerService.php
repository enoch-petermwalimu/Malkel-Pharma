<?php

namespace App\Services;

class LoggerService
{
    protected string $logPath;

    public function __construct()
    {
        $this->logPath =
            dirname(__DIR__, 2)
            . '/storage/logs/app.log';
    }

    public function info(string $message): void
    {
        $this->write('INFO', $message);
    }

    public function error(string $message): void
    {
        $this->write('ERROR', $message);
    }

    protected function write(
        string $level,
        string $message
    ): void {

        $date = date('Y-m-d H:i:s');

        $formatted =
            "[{$date}] {$level}: {$message}" . PHP_EOL;

        file_put_contents(
            $this->logPath,
            $formatted,
            FILE_APPEND
        );
    }
}