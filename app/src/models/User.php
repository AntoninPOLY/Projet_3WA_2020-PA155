<?php


namespace app\models;


class User extends Model
{
    public function login(string $login, string $pass)
    {
        $this->db->query("SELECT id, login, password FROM users WHERE login= :login LIMIT 1");
        $this->db->bind("login", $login);
        $result = $this->db->single();
        $hash = $result['password'];
        return password_verify($pass, $hash) ? $result : false;
    }
}