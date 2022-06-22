<?php


namespace app\controllers;

class ErrorController extends Controller
{
    public function error(string $message, \Exception $exception=null)
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        $this->render("error", array('message' => $exception));
        die();
    }
}
