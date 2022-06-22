<?php

require_once "../vendor/autoload.php";

use app\controllers\ErrorController;

$paths = app\core\Config::$routes;

$router = new AltoRouter();

try
{
    if (!empty($router)) $router->addRoutes($paths);
    
}
catch (Exception $e)
{
    die();
}

$match = $router->match();

if(is_array($match))
    try
    {
        $target = explode('#', $match['target']);

        $class = "app\\controllers\\" . (isset($target[0]) ? ucfirst($target[0]) . 'Controller' : 'IndexController');
        $action = isset($target[1]) ? $target[1] : "index";

        $params = $match['params'];

        if (class_exists($class, true))
        {
            $class = new $class($router);

            if (in_array($action, array_diff(get_class_methods($class), get_class_methods('App\controllers\Controller'))))
                call_user_func_array([$class, $action], $params);
            else
                throw new Exception("Une erreur est survenue, la fonction n'existe pas");
        }
        else
            throw new Exception("Une erreur est survenue, la classe n'existe pas");
    }
    catch (Exception $e)
    {
        $error = new ErrorController($router);
        call_user_func_array([$error, "error"],
            ["message"  => "Désolée la page que vous recherchez est introuvable. ",
            "exception" => $e]);
    }
else {
    $error = new ErrorController($router);
    call_user_func_array([$error, "error"], ["message" => "Désolée la page que vous recherchez est introuvable.",
    ]);
}
