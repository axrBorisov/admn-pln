<?php

class GuardModel
{

    public static function cleanQuery($query)
    {
        $query = trim($query);
        $query = htmlspecialchars($query);
        $query = strip_tags($query);
        $query = strtolower($query);
        $query = preg_replace('~[^a-z0-9 \x80-\xFF]~i', "", $query);

        return $query;
    }

    public static function cleanPost($query)
    {
        $query = trim($query);
        $query = htmlspecialchars($query);
        $query = strip_tags($query);
        $query = preg_replace('~[^а-яА-Яa-zA-Z0-9 \x5F\x2D]~u', "", $query);

        return $query;
    }


    public function getToken()
    {
        return self::hashToken(self::generateSalt(5), self::getKey());
    }


    public function setKey()
    {
        if (!isset($_SESSION['key'])) {
            $_SESSION['key'] = self::generateSalt(8);
        }
    }

    public function getKey()
    {
        if (isset($_SESSION['key'])) {
            return $_SESSION['key'];
        } else return false;
    }

    public function generateSalt($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length)
            $code .= $chars[mt_rand(0, $clen)];

        return $code;
    }

    private function hashToken($salt, $key)
    {
        return $salt . ':' . md5(md5($salt . ':' . $key));
    }

}