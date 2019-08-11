<?php

namespace App\Controller;

use App\Service\ConfigService;
use App\Service\DBService;
use App\Service\ResponseService;

/**
 * Class BaseController
 * @package Controller
 */
class BaseController
{
    /**
     * Получение разметки страницы
     *
     * @param string $name
     * @param null $args
     *
     * @return string
     */
    public function getView(string $name, $args = null)
    {
        return (new ResponseService())->getView($name, $args);
    }

    /**
     * Получение разметки страницы с описанием ошибки
     *
     * @param string $message
     * @param string $backUrl
     *
     * @return string
     */
    public function getErrorView(string $message, string $backUrl)
    {
        return $this->getView('error/custom', [
            'message'   => $message,
            'url'       => $backUrl,
        ]);
    }

    /**
     * Получение параметра из конфига по ключу
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getParameter(string $key)
    {
        return (new ConfigService())->get($key);
    }

    /**
     * Получение объекта PDO
     *
     * @return \PDO
     */
    public function getPDO()
    {
        return (new DBService(new ConfigService()))->getPDO();
    }

    /**
     * Проверка залогинен ли пользователь
     *
     * @return bool
     */
    public function userLogged()
    {
        return
            isset($_SESSION['logged']) &&
            $_SESSION['logged'] &&
            isset($_SESSION['id']) &&
            is_numeric($_SESSION['id']);
    }

    /**
     * Получение id пользователя из сессии
     *
     * @return int
     */
    public function getUserId()
    {
        return intval($_SESSION['id']);
    }

    /**
     * Занесение данных пользователя в сессию
     *
     * @param string|int $id
     */
    public function loginUser($id)
    {
        $_SESSION['logged'] = true;
        $_SESSION['id']     = $id;
    }

    /**
     * Удаление данных сессии пользователя
     */
    public function logoutUser()
    {
        unset($_SESSION['logged'], $_SESSION['id']);
    }

    /**
     * Получение данных пользователя из БД по id
     *
     * @param int $id
     *
     * @return array|null
     */
    public function getUserById(int $id)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("SELECT id, login, password, username, amount FROM user WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetchAll();

        return count($result) == 1 ? $result[0] : null;
    }

    /**
     * Получение данных пользователя из БД по логину
     *
     * @param string $login
     *
     * @return array|null
     */
    public function getUserByLogin(string $login)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("SELECT id, login, password, username, amount FROM user WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $result = $stmt->fetchAll();

        return count($result) == 1 ? $result[0] : null;
    }
}