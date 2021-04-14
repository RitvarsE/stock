<?php


namespace App\Middlewares;


interface MiddlewareInterface
{
    public function authorize(): void;
}