<?php


namespace App\Controllers;


use App\Services\Main\MainService;

class AccountController
{
    private MainService $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function account(): void
    {
        if (isset($_SESSION['username'])) {
            echo $this->mainService->account();
        } else {
            header('refresh:0;url=/');
        }
    }

    public function buy(): void
    {
        if (isset($_SESSION['username'])) {
            echo $this->mainService->buy();
        } else {
            header('refresh:0;url=/');
        }
    }

    public function bought(): void
    {
        echo $this->mainService->bought();
    }

    public function sold(): void
    {
        echo $this->mainService->sold();
    }
}