<?php

class UserService
{
    /** @var UserModel */
    private $user;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->user = UserModel::instance();
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function login($login, $password): bool
    {
        $user = $this->user->getByLogin($login);
        if ($user === null) {
            return false;
        }

        $id_user = $user['id_user'];
        if ($user['password'] !== $this->user->hash($password)) {
            return false;
        }

        $this->user->sid = $this->user->openSession($id_user);
        return true;
    }

    public function logout(): void
    {
        $this->user->logout();
    }

    /**
     * @param $login
     * @param $password
     * @param $confirm
     * @return bool|null
     * @throws Exception
     */
    public function registration($login, $password, $confirm): ?bool
    {
        try {
            if (!$this->user->checkLogin($login)) {
                throw new LogicException('Имя не должно быть короче 2-х символов');
            }
            if (!$this->user->checkPassword($password)) {
                throw new LogicException('Пароль не должен быть короче 4-х символов');
            }
            if ($this->user->getByLogin($login)) {
                throw new LogicException("Логин {$login} уже используется");
            }
            if ($password !== $confirm) {
                throw new LogicException('Пароли не совпадают');
            }
            return $this->user->createUser(
                $login,
                $password,
                'use',
                UserModel::ROLE_SUPER_ADMIN);
        } catch (Exception $exception) {
            throw $exception;
        }
    }


    /**
     * @param $privilege
     * @param null $userId
     * @return bool|null
     * @internal param null $id_user
     */
    public function can($privilege, $userId = null): ?bool
    {
        if ($userId = $userId ?? $this->user->getUid()) {
            return $privilege === $this->user->getRole($userId)->name;
        }

        return false;
    }


}