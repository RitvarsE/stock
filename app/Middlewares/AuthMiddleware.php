<?php


namespace App\Middlewares;


class AuthMiddleware implements MiddlewareInterface
{
    public function authorize(): void
    {
        if (!isset($_SESSION['username'])) {
            header('refresh:0;url=/');
            exit;
        }
    }
}