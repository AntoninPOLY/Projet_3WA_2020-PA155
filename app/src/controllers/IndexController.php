<?php


namespace app\controllers;

use app\models\Article;
use app\models\Basket;
use app\models\Product;

class IndexController extends Controller
{
    public function index()
    {

        $this->render("index",[]);
    }

    public function admin()
    {
        $this->isAdminLogged();
        $articles = new Article();
        $baskets = new Basket();
        $products = new Product();
        $result = [
            "articles" => $articles->adminfind(),
            "products" => $products->adminfind(),
            "baskets" => $baskets->adminfind()
        ];

        $this->render("admin",[
            "articles"  => $result['articles'],
            "products"  => $result['products'],
            "baskets"  => $result['baskets']
        ], "back");
    }

}