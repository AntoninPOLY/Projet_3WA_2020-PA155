<?php

namespace app\controllers;

use AltoRouter;
use app\core\Session;
use Exception;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Controller
{
    protected Environment $twig;

    protected Environment $layoutTwig;

    protected AltoRouter $router;

    public array $errors = [];

    public function __construct(AltoRouter $router)
    {
        $this->router = $router;
        $className = substr(get_class($this), 16, -10);

        // Twig Configuration
        $layoutLoader  = new FilesystemLoader('../views/layout');
        $loader = new FilesystemLoader('../views/' . strtolower($className));

        $function = new TwigFunction("routeOf", [$this, "generateRoute"]);

        $this->twig = $this->loadTwig($loader, $function);
        $this->layoutTwig = $this->loadTwig($layoutLoader, $function);

        $this->twig->addExtension(new DebugExtension());
    }

    public function generateRoute(string $name, array $params = [])
    {
        try {
            return $this->router->generate($name, $params);
        } catch (Exception $e) {
            return "";
        }
    }

    protected function render(string $name, array $params = [], ?string $layout = "default")
    {
        try {
            $name = $name . ".twig";
            $layout = $this->layoutTwig->load($layout.".twig");
            $params += [
                "layout" => $layout
            ];
            echo $this->twig->render($name, $params);
            return true;
        }catch(Exception $e) {
            return $e;
        }
    }

    private function loadTwig(FilesystemLoader $loader, TwigFunction $function)
    {
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => True
        ]);
        $twig->addFunction($function);
        return $twig;
    }
    protected function startSession() {
        session_start();
    }
    protected function setSession(array $array) {
        $_SESSION = $array;
    }

    protected function unsetSession() {
        $_SESSION = [];
        session_destroy();
        return true;
    }

    protected function isUserLogged()
    {
        $this->startSession();
        if(!Session::isUserLogged()) header('location:' . $this->generateRoute("customerLogin"));
    }

    protected function isAdminLogged()
    {
        $this->startSession();
        if(!Session::isAdmin()) header('location:' . $this->generateRoute("adminLogin"));
    }

    protected function escape(string $input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    function isString(string $string)
    {
        if (!is_string($string)) return false;
        return true;
    }

    function isInt(int $int)
    {
        if (!is_string($int)) return false;
        return true;
    }
}
