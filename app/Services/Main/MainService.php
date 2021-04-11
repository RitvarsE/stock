<?php


namespace App\Services\Main;


use App\Repositories\Finnhub\FinnhubRepository;
use App\Services\Twig\TwigService;
use App\Services\Users\UsersService;
use Finnhub\Model\Quote;

class MainService
{
    private FinnhubRepository $finnhubRepository;
    private TwigService $twigService;
    private UsersService $usersService;

    public function __construct(
        FinnhubRepository $finnhubRepository,
        TwigService $twigService,
        UsersService $usersService)

    {
        $this->finnhubRepository = $finnhubRepository;
        $this->twigService = $twigService;
        $this->usersService = $usersService;
        $this->twigService->environment()->addGlobal('session', $_SESSION);
    }

    public function getQuote(string $stock): Quote
    {
        return $this->finnhubRepository->getQuote($stock);
    }

    public function login(): string
    {
        return $this->twigService->environment()->render('HomeView.twig');
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
            return $this->twigService->environment()->render('AccountView.twig');
        } else {
            header("refresh:2;url=/");
            return 'Invalid username/password';
        }

    }
}