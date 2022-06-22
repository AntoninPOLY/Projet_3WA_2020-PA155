<?php


namespace app\controllers;


use app\models\Product;
use app\models\Basket;
use \DateTime;


class ProductController extends Controller
{
    function index()
    {
        $today = new DateTime();
        $day = $today->format("w");
	if($day == 0) {
		$day = 1;
	}

        $basket = new Basket();
        $result = $basket->findDayBasket($day);


        $products = new Product();
        $results = $products->joinBasket($result['id']);

        $this->render("index",[
            "basket" => $result,
            "products" => $results
        ]);
    }

    public function adminInsert()
    {
        $this->isAdminLogged();

        if(!empty($_POST)) {
            $data = $_POST;
            $this->verifyInputs($data['title'], $data['provenance']);

            $products = new Product();

            if(count($this->errors) == 0) {

                $data["title"] = $this->escape($data["title"]);
                $data["provenance"] = $this->escape($data["provenance"]);
                switch ($_POST['submit_type'])
                {
                    case 'save':
                        $products->insert($data['title'], $data['provenance']);
                        break;
                    case 'saveandclose':
                        $result = $products->insert($data['title'], $data['provenance']);

                        if($result) {
                            header('location:' . $this->generateRoute("adminHome"));
                        }
                        else {
                            header('location:' . $this->generateRoute("adminHome"));
                            die;
                        }
                        break;
                }
            }
            if($_POST['submit_type'] === "close") header('location:' . $this->generateRoute("adminHome"));
        }
        $this->render("insert",[
            "errors" => $this->errors
        ], "back");
    }

    public function adminUpdate(int $id)
    {
        $this->isAdminLogged();

        $products = new Product();

        if(!empty($_POST)) {
            $data = $_POST;
            $this->verifyInputs($data['title'], $data['provenance']);

            if(count($this->errors) == 0) {

                $data["title"] = $this->escape($data["title"]);
                $data["provenance"] = $this->escape($data["provenance"]);
                switch ($_POST['submit_type'])
                {
                    case 'save':
                        $products->update($data['title'], $data['provenance'], $id);
                        break;
                    case 'saveandclose':
                        $result = $products->update($data['title'], $data['provenance'], $id);

                        if($result) {
                            header('location:' . $this->generateRoute("adminHome"));
                        }
                        else {
                            header('location:' . $this->generateRoute("adminHome"));
                            die;
                        }
                        break;
                }
            }
            if($_POST['submit_type'] === "close") header('location:' . $this->generateRoute("adminHome"));
        }

        $this->render("update",[
            "product" => $products->findOne($id),
            "errors" => $this->errors
        ], "back");
    }

    public function adminDelete(int $id)
    {
        $this->isAdminLogged();
        $products = new Product();
        $products->delete($id);
        header('location:' . $this->generateRoute("adminHome"));
    }

    function verifyInputs(?string $title, ?string $provenance)
    {

        if (empty($title) || !$this->isString($title))
        {
            return(array_push($this->errors, "Le titre est manquant , veuillez réessayer"));
        }
        if (empty($provenance) || !$this->isString($provenance))
        {
            return(array_push($this->errors, "La provenance est manquante , veuillez réessayer"));
        }
        if(strlen($title)>71 || strlen($provenance)>71)
        {
            return array_push($this->errors, "Vous êtes limités à 70 charactères , veuillez réessayer");
        }
        return null;
    }
}
