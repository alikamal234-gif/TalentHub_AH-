<?php

namespace Core\Error;

use Core\Http\Response;

abstract class Error
{
    public static function abort(int $errorCode): Response
    {
        $templatePath = sprintf('%s/pages/%s.php',__DIR__ ,$errorCode);
        if (!file_exists($templatePath)) {
            $templatePath = sprintf('%s/pages/default.php',__DIR__);
        }

        ob_start();
        require_once $templatePath;
        $content = ob_get_clean();

        return new Response($content, $errorCode);
    }
}