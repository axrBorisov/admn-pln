<?php

class UserModel
{

    const ROLE_SUPER_ADMIN = 10;
    const ROLE_ADMIN = 20;
    const ROLE_USER = 30;

    /**
     * @property $instance экземпляр класса
     */
    private static $instance;

    /**
     * @property $sid идентификатор текущей сессии
     */
    public $sid;

    /**
     * @property $sid идентификатор текущего пользователя
     */
    public $uid;

    public static function instance(): \UserModel
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @param $login
     * @param $password
     * @param string $privilegeName
     * @param int $roleId
     * @return bool
     * @internal param string $roleName
     */
    public function createUser($login, $password, string $privilegeName, int $roleId): bool
    {
        $result = Db::getInstance()->insert(
            'INSERT',
            'users',
            ['login', 'password'],
            [
                'login' => $login,
                'password' => $this->hash($password),
            ]);
        if ($result) {
            $lastId = Db::getInstance()->lastInsertId();
            Db::getInstance()->insert(
                'INSERT',
                'access',
                ['name', 'id_user', 'role_id'],
                [
                    'name' => $privilegeName,
                    'id_user' => $lastId,
                    'role_id' => $roleId,
                ]);
        }

        return $result;
    }

    public function getRole(int $userId)
    {
        return Db::getInstance()->select(
            "SELECT access.name  FROM `access` 
                            LEFT JOIN `users`
                                ON `access`.`id_user` = `users`.`id_user`
                       WHERE `users`.`id_user` = $userId",
            'object');
    }

    /**
     * @param $name
     * @return bool
     */
    public function checkLogin($name): bool
    {
        return strlen($name) >= 2;
    }

    /**
     * @param $password
     * @return bool
     */
    public function checkPassword($password): bool
    {
        return strlen($password) >= 4;
    }

    public function clearSessions(): void
    {
        $min = date('Y-m-d H:i:s', time() - 60 * 20);
        $t = "time_last < '%s'";
        $where = sprintf($t, $min);
        Db::getInstance()->delete('sessions', null, $where);
    }

    public function logout(): void
    {
        setcookie('login', '', time() - 1);
        setcookie('password', '', time() - 1);
        unset($_COOKIE['login'], $_COOKIE['password'], $_SESSION['sid']);
        $this->sid = null;
        $this->uid = null;
    }


    /**
     * @param null $id_user
     * @return mixed
     */
    public function get($id_user = null)
    {
        if ($id_user === null) {
            $id_user = $this->getUid();
        }
        if ($id_user === null) {
            return null;
        }
        $t = "SELECT * FROM users WHERE id_user = '%d'";
        $query = sprintf($t, $id_user);
        $result = Db::getInstance()->select($query);
        return $result[0];
    }

    /**
     * @param $login
     * @return mixed
     */
    public function getByLogin($login)
    {
        $values['login'] = $login;
        $result = Db::getInstance()->select("SELECT * FROM `users` WHERE `login` = :login", null, $values);
        if (!empty($result)) {
            return $result[0];
        }
    }


    public function getUid()
    {
        if ($this->uid !== null) {
            return $this->uid;
        }
        $sid = $this->getSid();

        if ($sid === null) {
            return null;
        }

        $t = "SELECT id_user FROM sessions WHERE sid = '%s'";
        $query = sprintf($t, $sid);
        $result = Db::getInstance()->select($query);

        if (count($result) === 0) {
            return null;
        }
        $this->uid = $result[0]['id_user'];
        return $this->uid;
    }

    private function getSid()
    {
        if ($this->sid !== null) {
            return $this->sid;
        }

        $sid = $_SESSION['sid'] ?? null;

        if ($sid !== null) {
            $session = array();
            $session['time_last'] = date('Y-m-d H:i:s');
            $t = "sid = '%s'";
            $where = sprintf($t, $sid);
            $affected_rows = Db::getInstance()->insert('UPDATE', 'sessions', array('time_last'), $session, $where);

            if ($affected_rows === 0) {
                $t = "SELECT count(*) FROM sessions WHERE sid = '%s'";
                $query = sprintf($t, $sid);
                $result = Db::getInstance()->select($query);

                if ($result[0]['count(*)'] === 0) {
                    $sid = null;
                }
            }
        }

        if ($sid === null && isset($_COOKIE['login'])) {
            $user = $this->getByLogin($_COOKIE['login']);

            if ($user !== null && $user['password'] === $_COOKIE['password'])
                $sid = $this->openSession($user['id_user']);
        }

        if ($sid !== null) {
            $this->sid = $sid;
        }

        return $sid;
    }

    public function openSession($id_user): string
    {
        $sid = $this->generateStr();

        $now = (new DateTime())->format('Y-m-d H:i:s');
        $session = [
            'id_user' => $id_user,
            'sid' => $sid,
            'time_start' => $now,
            'time_last' => $now
        ];

        Db::getInstance()->insert('INSERT', 'sessions', ['id_user', 'sid', 'time_start', 'time_last'], $session);

        $_SESSION['sid'] = $sid;
        return $sid;
    }

    private function generateStr($length = 10): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
        $code = '';
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length) {
            $code .= $chars[random_int(0, $clen)];
        }
        return $code;
    }

    public function hash($string): string
    {
        return md5(md5($string . '3x47mtn8y7fg4gf2otn3kpfty'));
    }

}

