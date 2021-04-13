<?php


namespace App\Services\Twig;


use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

class TwigService
{
    private FilesystemLoader $loader;
    private Environment $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('../app/Views');
        $this->twig = new Environment($this->loader, [
            'auto_reload' => true,
            'debug' => true,
        ]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new IntlExtension());
    }

    public function environment(): Environment
    {
        return $this->twig;
    }
}