<?php


namespace app\models;



class Basket extends Model
{
    public function find()
    {
        $this->db->query("SELECT id, title, created_at, day FROM baskets ORDER BY created_at DESC");
        return $this->db->resultset();
    }

    public function adminfind()
    {
        $this->db->query("SELECT id, title, created_at, updated_at, day FROM baskets ORDER BY id DESC");
        return $this->db->resultset();
    }

    public function findOne(int $id)
    {
        $this->db->query("SELECT id, title, created_at, day FROM baskets WHERE id = :id");
        $this->db->bind("id", $id);
        return $this->db->single();
    }

    public function findDayBasket(int $day)
    {
        $this->db->query("SELECT id, title, created_at as date, day FROM baskets WHERE day = :day");
        $this->db->bind("day", $day);
        return $this->db->single();
    }

    public function update(string $title, int $id, string $updated_at)
    {
        $this->db->query("UPDATE `baskets` 
        SET 
        `title` = :title,
        `updated_at` = :updated_at
        WHERE 
        `id` = :id");
        $this->db->bind("title", $title);
        $this->db->bind("updated_at", $updated_at);
        $this->db->bind("id", $id);
        return $this->db->execute();

    }

    public function addProduct( int $product_id, int $basket_id)
    {
        $this->db->query("SELECT `id`, product_id from basketjoin WHERE product_id = :id AND basket_id = :basket_id");
        $this->db->bind("id", $product_id);
        $this->db->bind("basket_id", $basket_id);
        $result = $this->db->resultset();
        if(!$result) {
            $this->db->query("INSERT INTO `basketjoin` (`product_id`, `basket_id`) 
                                                VALUES (:product_id, :basket_id)");
            $this->db->bind("product_id", $product_id);
            $this->db->bind("basket_id", $basket_id);
            return $this->db->execute();
        }
        return false;
    }

    public function deleteProduct(int $product_id)
    {
        $this->db->query("SELECT `id`, product_id from basketjoin WHERE product_id = :id");
        $this->db->bind("id", $product_id);
        $result = $this->db->resultset();
        if(is_array($result))
        {
            foreach ($result as $r) {
                $this->db->query("DELETE from basketjoin WHERE id = :id");
                $this->db->bind("id", $r['id']);
                $this->db->execute();
            }
        }
        return false;
    }

    public function findProductsOfBasket($basket_id)
    {
        $this->db->query("SELECT id, product_id, basket_id FROM basketjoin WHERE basket_id = :id");
        $this->db->bind("id", $basket_id);
        return $this->db->resultset();
    }
}