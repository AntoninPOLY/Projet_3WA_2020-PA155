<?php


namespace app\models;


class Article extends Model
{
    public function find()
    {
        $this->db->query("SELECT id, title, content, online, updated_at, created_at FROM articles WHERE online = 1 ORDER BY created_at DESC");
        return $this->db->resultset();
    }

    public function adminfind()
    {
        $this->db->query("SELECT id, title, content, created_at, updated_at, creator_id, online, updated_at FROM articles ORDER BY created_at DESC");
        return $this->db->resultset();
    }
    public function findOne(int $id)
    {
        $this->db->query("SELECT id, title, content, online, created_at FROM articles WHERE id = :id");
        $this->db->bind("id", $id);
        return $this->db->single();
    }
    public function insert(string $title, string $content, int $online)
    {
        $id  = $_SESSION['id'];
        $this->db->query("INSERT INTO `articles` (`title`, `content`, `creator_id`, `online`) VALUES (:title, :content, :creator_id, :online)");
        $this->db->bind("title", $title);
        $this->db->bind("content", $content);
        $this->db->bind("creator_id", $id);
        $this->db->bind("online", $online);
        return $this->db->execute();

    }
    public function update(string $title, string $content, int $id, int $online)
    {
        $date = date("Y-m-d H:i:s");
        $this->db->query("UPDATE `articles` 
        SET 
        `title`   = :title,
        `content` = :content,
        `online`  = :online,
        `updated_at` = :date
        WHERE 
        `id` = :id");
        $this->db->bind("title", $title);
        $this->db->bind("title", $title);
        $this->db->bind("content", $content);
        $this->db->bind("id", $id);
        $this->db->bind("online", $online);
        $this->db->bind("date", $date);

        return $this->db->execute();

    }

    public function delete(int $id)
    {
        $this->db->query("DELETE FROM `articles` WHERE `id` = :id");
        $this->db->bind("id", $id);
        return $this->db->execute();
    }
}