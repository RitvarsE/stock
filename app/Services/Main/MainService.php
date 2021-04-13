<?php


namespace App\Services\Main;


use App\Services\Stock\StockService;
use App\Services\Twig\TwigService;
use App\Services\Users\UsersService;

class MainService
{
    private TwigService $twigService;
    private UsersService $usersService;
    private StockService $stockService;

    public function __construct(
        TwigService $twigService,
        UsersService $usersService,
        StockService $stockService
    )

    {
        $this->twigService = $twigService;
        $this->usersService = $usersService;
        $this->twigService->environment()->addGlobal('session', $_SESSION);
        $this->twigService->environment()->addGlobal('post', $_POST);

        if (isset($_SESSION['username'])) {
            $this->twigService->environment()->addGlobal('wallet', $this->usersService->getWallet($_SESSION['username']));
        }
        $this->stockService = $stockService;
    }

    public function getQuote(string $stock): string
    {
        return json_decode(
            file_get_contents(
                'https://finnhub.io/api/v1/quote?symbol=' . $stock . '&token=c1pj3v2ad3id1hoq2ap0')
            , true)['c'];
    }

    public function login(): string
    {
        return $this->twigService->environment()->render('HomeView.twig');
    }

    public function logout(): void
    {
        unset($_SESSION['username']);
    }

    public function index(): string
    {

        return $this->twigService->environment()->render('HomeView.twig');
    }

    public function registerView(): string
    {
        return $this->twigService->environment()->render('RegisterView.twig');
    }

    public function registered(): void
    {
        $this->usersService->createUser($_POST['username'], $_POST['password']);
    }

    public function verifyUser(): string
    {
        if ($this->usersService->verifyUser($_POST['username'], $_POST['password'])) {
            $_SESSION['username'] = $_POST['username'];
            return $this->twigService->environment()->render('LoginView.twig', ['auth' => true]);
        } else {
            return $this->twigService->environment()->render('LoginView.twig', ['auth' => false]);
        }

    }

    public function account(): string
    {
        $stocks = $this->stockService->allStock($_SESSION['username']);
        return $this->twigService->environment()->render('AccountView.twig',
            ['stocks' => $stocks]);
    }

    public function buy(): string
    {
        $quote = 0;
        if (isset($_POST['stockname'])) {
            $quote = $this->getQuote($_POST['stockname']);
        }
        return $this->twigService->environment()->render('buyStockView.twig', ['quote' => $quote]);
    }

    public function bought(): string
    {
        if ($this->usersService->getWallet($_SESSION['username'])
            >= $_POST['count'] * $this->getQuote($_POST['stock'])) {

            $this->usersService->updateWallet($_SESSION['username'],
                $_POST['count'] * $this->getQuote($_POST['stock']));

            $this->stockService->buy($_SESSION['username'],
                $_POST['stock'],
                $this->getQuote($_POST['stock']),
                $_POST['count']);

            return $this->twigService->environment()->render('BoughtView.twig', ['success' => true]);
        }
        return $this->twigService->environment()->render('BoughtView.twig', ['success' => false]);

    }

    public function addCurrentPrice(): void
    {
        $this->stockService->addCurrentPrice();
    }

    public function sold(): string
    {
        $this->usersService->updateWallet($_SESSION['username'],
            ($_POST['count'] * $this->getQuote($_POST['stock'])) * -1);
        $this->stockService->sell($_POST['id'], $_POST['stockPrice']);
        return $this->twigService->environment()->render('SoldView.twig');
    }
}