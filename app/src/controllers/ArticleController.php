<?php

namespace app\controllers;

use app\models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = new Article();
        $result = $articles->find();
        $this->render("index",[
            "articles" => $result
        ]);
    }
    public function adminInsert()
    {
        $this->isAdminLogged();


        if(!empty($_POST)) {
            $data = $_POST;
            $this->verifyInputs($data["title"], $data['content'], $data['online']);

            $articles = new Article();

            if(count($this->errors) == 0) {
                $data["title"] = $this->escape($data["title"]);
                $data["content"] = $this->escape($data["content"]);
                $data["online"] = $this->escape($data["online"]);

                $data['online'] = $data['online'] == "true" ? 1 : 0;
                switch ($_POST['submit_type'])
                {
                    case 'save':
                        $articles->insert($data['title'], $data['content'], $data['online']);
                        break;
                    case 'saveandclose':
                        $result = $articles->insert($data['title'], $data['content'], $data['online']);

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
            "result" => $result[0]
        ], "back");
    }

    public function adminUpdate(int $id)
    {
        $this->isAdminLogged();

        $articles = new Article();

        if(!empty($_POST)) {
            $data = $_POST;
            $this->verifyInputs($data["title"], $data['content'], $data['online']);

            if(count($this->errors) == 0) {
                $data["title"] = $this->escape($data["title"]);
                $data["content"] = $this->escape($data["content"]);
                $data["online"] = $this->escape($data["online"]);
                $data['online'] = $data['online'] == "true" ? 1 : 0;
                switch ($_POST['submit_type'])
                {
                    case 'save':
                        $articles->update($data['title'], $data['content'], $id, $data['online']);
                        break;
                    case 'saveandclose':
                        $result = $articles->update($data['title'], $data['content'], $id, $data['online']);

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
            "article" => $articles->findOne($id),
            "errors" => $this->errors
        ], "back");
    }

    public function adminDelete(int $id)
    {
        $this->isAdminLogged();
        $articles = new Article();
        $articles->delete($id);
        header('location:' . $this->generateRoute("adminHome"));
    }

    function verifyInputs(?string $title, ?string $content, ?string $online)
    {

        if (empty($title) || !$this->isString($title)) return(array_push($this->errors, "Le titre est manquant , veuillez réessayer"));
        if (empty($content) || !$this->isString($content)) return(array_push($this->errors, "Le contenu est manquant, veuillez réessayer"));
        if (empty($online) || !$this->isString($online)) return(array_push($this->errors, "Veuillez sélectionner le champ en ligne"));
        if(strlen($title)>71) return array_push($this->errors, "Vous êtes limités à 70 charactères , veuillez réessayer");
        return null;
    }
}