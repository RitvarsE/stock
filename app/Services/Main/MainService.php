<?php


namespace App\Services\Main;


use App\Services\Quote\QuoteService;
use App\Services\Stock\StockService;
use App\Services\Users\UsersService;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

class MainService
{
    private UsersService $usersService;
    private StockService $stockService;
    private FilesystemLoader $loader;
    private Environment $twig;


    public function __construct(UsersService $usersService, StockService $stockService)

    {
        $this->stockService = $stockService;
        $this->usersService = $usersService;

        // twig
        $this->loader = new FilesystemLoader('../app/Views');
        $this->twig = new Environment($this->loader, [
            'auto_reload' => true,
            'debug' => true,
        ]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new IntlExtension());
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('post', $_POST);
        if (isset($_SESSION['username'])) {
            $this->twig
                ->addGlobal('wallet', $this->usersService->getWallet($_SESSION['username']));
        }
    }

    public function getQuote(string $stock): string
    {
        return $this->stockService->getQuote($stock);
    }

    public function login(): string
    {
        return $this->twig->render('HomeView.twig');
    }

    public function logout(): void
    {
        unset($_SESSION['username']);
    }

    public function index(): string
    {

        return $this->twig->render('HomeView.twig');
    }

    public function registerView(): string
    {
        return $this->twig->render('RegisterView.twig');
    }

    public function registered(): string
    {
        if ($this->usersService->createUser($_POST['username'], $_POST['password'])) {
            return $this->twig->render('RegisteredView.twig', ['register' => true]);
        }
        return $this->twig->render('RegisteredView.twig', ['register' => false]);
    }

    public function verifyUser(): string
    {
        if ($this->usersService->verifyUser($_POST['username'], $_POST['password'])) {
            $_SESSION['username'] = $_POST['username'];
            return $this->twig->render('LoginView.twig', ['auth' => true]);
        } else {
            return $this->twig->render('LoginView.twig', ['auth' => false]);
        }

    }

    public function account(): string
    {
        $this->addCurrentPrice();
        $stocks = $this->stockService->allStock($_SESSION['username']);
        return $this->twig->render('AccountView.twig',
            ['stocks' => $stocks]);
    }

    public function buy(): string
    {
        $quote = 0;
        if (isset($_POST['stockname'])) {
            $quote = $this->getQuote($_POST['stockname']);
        }
        return $this->twig->render('buyStockView.twig', ['quote' => $quote]);
    }

    public function bought(): string
    {
        if (is_numeric($_POST['count']) && $this->usersService->getWallet($_SESSION['username'])
            >= $_POST['count'] * $this->getQuote($_POST['stock']) * 100
            && $_POST['count'] > 0) {

            $this->usersService->updateWallet($_SESSION['username'],
                $_POST['count'] * $this->getQuote($_POST['stock']) * 100);

            $this->stockService->buy($_SESSION['username'],
                $_POST['stock'],
                $this->getQuote($_POST['stock']),
                $_POST['count']);

            return $this->twig->render('BoughtView.twig', ['success' => true]);
        }
        return $this->twig->render('BoughtView.twig', ['success' => false]);

    }

    public function addCurrentPrice(): void
    {
        $this->stockService->addCurrentPrice($_SESSION['username']);
    }

    public function sold(): string
    {
        $this->usersService->updateWallet($_SESSION['username'],
            $_POST['stockPrice'] * -1);
        $this->stockService->sell($_POST['id'], $_POST['stockPrice']);

        return $this->twig->render('SoldView.twig');
    }

    public function nothing(): string
    {
        return $this->twig->render('NothingView.twig');
    }
}