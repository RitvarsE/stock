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

    public function account(): string
    {
        return $this->mainService->account();
    }

    public function buy(): string
    {
        return $this->mainService->buy();
    }

    public function bought(): string
    {
        return $this->mainService->bought();
    }

    public function sold(): string
    {
        return $this->mainService->sold();
    }
}