<?php

namespace App\Core;

/**
 * View renderer
 */
class View
{
    public static function render(
        string $view,
        array $data = []
    ): void {
        extract($data);

        $view =
            str_replace('.', '/', $view);

        $file =
            view_path($view . '.php');

        if (!file_exists($file)) {
            die("View not found: {$file}");
        }

        require $file;
    }
}