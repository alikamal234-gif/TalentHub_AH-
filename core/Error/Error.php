<?php

namespace Core\Error;

use Core\Http\Response;

abstract class Error
{
    public static function abort(int $errorCode): Response
    {
        $templatePath = sprintf('./pages/%s.php', $errorCode);
        if (!file_exists($templatePath)) {
            $templatePath = './pages/default.php';
        }

        ob_start();
        require $templatePath;
        $content = ob_get_clean();

        return new Response($content, $errorCode);
    }
}