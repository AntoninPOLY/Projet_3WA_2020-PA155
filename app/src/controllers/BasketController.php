<?php

namespace app\controllers;

use app\models\Basket;
use app\models\Product;

class BasketController extends Controller
{

    public function adminUpdate(int $id)
    {
        $this->isAdminLogged();

        $baskets = new Basket();

        if(!empty($_POST)) {
            $data = $_POST;
            $this->verifyInputs($data['title'], $data['date']);

            if(count($this->errors) == 0) {
                $data["title"] = $this->escape($data["title"]);
                $data["date"] = $this->escape($data["date"]);
                switch ($_POST['submit_type']) {
                    case 'save':
                        $baskets->update($data['title'], $id, $data['date']);
                        break;
                    case 'saveandclose':
                        $result = $baskets->update($data['title'], $id, $data['date']);


                        if ($result) {
                            header('location:' . $this->generateRoute("adminHome"));
                        } else {
                            header('location:' . $this->generateRoute("adminHome"));
                            die;
                        }
                        break;
                }
            }
            if($_POST['submit_type'] === "close") header('location:' . $this->generateRoute("adminHome"));
        }

        $this->render("update",[
            "basket" => $baskets->findOne($id),
            "errors" => $this->errors
        ], "back");
    }

    public function adminAddProduct(int $basket_id)
    {
        $this->isAdminLogged();

        $baskets = new Basket();
        $products = new Product();
        $products_array = $products->adminfind();

        if(!empty($_POST)) {
            $data = $_POST;
            $data['produits'] = $data['produits'] ? $data['produits'] : [];

            switch ($_POST['submit_type'])
            {
                case 'save':
                    foreach ($products_array as $p)
                    {
                        if(in_array($p['id'], $data['produits'])) {
                            $baskets->addProduct($p['id'], $basket_id);
                        }
                        else {
                            $baskets->deleteProduct($p['id']);
                        }
                    }
                    break;
                case 'saveandclose':
                    foreach ($products_array as $p)
                    {
                        if(in_array($p['id'], $data['produits'])) {
                            $result_add = $baskets->addProduct($p['id'], $basket_id);
                        }
                        else {
                            $result_del = $baskets->deleteProduct($p['id']);
                        }
                    }
                    if($result_add || $result_del) {
                        header('location:' . $this->generateRoute("adminHome"));
                    }
                    else {
                        header('location:' . $this->generateRoute("adminHome"));
                        die;
                    }
                    break;
                case 'close':
                    header('location:' . $this->generateRoute("adminHome"));
                    break;
            }
        }
        $products_id = [];
        foreach ($baskets->findProductsOfBasket($basket_id) as $product) array_push($products_id, $product['product_id']);
        $this->render("add",[
            "products" => $products_array,
            "id" => $basket_id,
            "produits" => $products_id

        ], "back");
    }

    function verifyInputs(?string $title, ?string $date)
    {

        if (empty($title) || !$this->isString($title)) return(array_push($this->errors, "Le titre est manquant , veuillez réessayer"));
        if (empty($date) || !$this->isString($date)) return(array_push($this->errors, "Il y a eu une erreur, veuillez réessayer"));
        if(strlen($title)>71 ) return array_push($this->errors, "Vous êtes limités à 70 charactères , veuillez réessayer");
        return null;
    }
}