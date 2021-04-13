<?php


namespace App\Controllers;

use App\Services\Main\MainService;
use Finnhub;
use GuzzleHttp;

class HomeController
{
    private MainService $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function login(): string
    {
        return $this->mainService->login();
        // echo $this->mainService->getQuote('AAPL')['c'];
    }

    public function logout(): void
    {
        header("refresh:0;url=/");
        $this->mainService->logout();
    }

    public function index(): string
    {
        return $this->mainService->verifyUser();
    }

    public function register(): string
    {
        return $this->mainService->registerView();
    }

    public function registered(): void
    {
        $this->mainService->registered();
    }
}