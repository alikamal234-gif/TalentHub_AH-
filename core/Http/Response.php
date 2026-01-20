<?php

declare(strict_types=1);

namespace Core\Http;

class Response
{
    protected string $content;
    protected int $statusCode;

    public function __construct(string $content = '', int $status = 200) {
        $this->content = $content;
        $this->statusCode = $status;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = (string) $content;

        return $this;
    }

    private function sendContent(): void
    {
        echo $this->content;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        header('Content-Type: text/html');

        $this->sendContent();

        // Ferme la requête
        if (\function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}