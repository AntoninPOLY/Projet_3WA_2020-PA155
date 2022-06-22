<?php


namespace app\models;


class Product extends Model
{
    public function find()
    {
        $this->db->query("SELECT id, title, provenance FROM products ORDER BY created_at DESC");
        return $this->db->resultset();
    }

    public function adminfind()
    {
        $this->db->query("SELECT id, title, provenance, creator_id, created_at, updated_at FROM products ORDER BY created_at DESC");
        return $this->db->resultset();
    }
    public function findOne(int $id)
    {
        $this->db->query("SELECT id, title, provenance, created_at FROM products WHERE id = :id");
        $this->db->bind("id", $id);
        return $this->db->single();
    }

    public function insert(string $title, string $provenance)
    {
        $id  = $_SESSION['id'];
        $this->db->query("INSERT INTO `products` (`title`, provenance, `creator_id`) 
                                                VALUES (:title, :provenance, :creator_id)");
        $this->db->bind("title", $title);
        $this->db->bind("provenance", $provenance);
        $this->db->bind("creator_id", $id);
        return $this->db->execute();

    }
    public function update(string $title, string $provenance, int $id)
    {
        $date = date("Y-m-d H:i:s");
        $this->db->query("UPDATE `products` 
        SET 
        `title` = :title,
        `provenance` = :provenance,
        `updated_at` = :date
        WHERE 
        `id` = :id");
        $this->db->bind("title", $title);
        $this->db->bind("provenance", $provenance);
        $this->db->bind("date", $date);
        $this->db->bind("id", $id);
        return $this->db->execute();

    }

    public function delete(int $id)
    {
        $this->db->query("SELECT id, product_id FROM basketjoin WHERE product_id = :id");
        $this->db->bind("id", $id);
        $result = $this->db->resultset();
        foreach ($result as $r) {
            $this->db->query("DELETE from basketjoin WHERE id = :id");
            $this->db->bind("id", $r['id']);
            $this->db->execute();
        }
        $this->db->query("DELETE FROM `products` WHERE `id` = :id");
        $this->db->bind("id", $id);
        return $this->db->execute();
    }

    public function joinBasket(int $basket_id) {
        $this->db->query("SELECT * FROM products INNER JOIN basketjoin ON products.id = basketjoin.product_id WHERE basketjoin.basket_id = :id");
        $this->db->bind("id", $basket_id);
        return $this->db->resultset();
    }
}
