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
     * @var ConfigService
     */
    private $config;

    /**
     * @var DBService
     */
    private $db;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->config   = new ConfigService();
        $this->db       = new DBService($this->config);
    }

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
        return $this->config->get($key);
    }

    /**
     * Получение объекта DBService
     *
     * @return DBService
     */
    public function getDBService()
    {
        return $this->db;
    }

    /**
     * Получение объекта PDO
     *
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->db->getPDO();
    }

    /**
     * Проверка залогинен ли пользователь
     *
     * @return bool
     */
    public function userLogged()
    {
        return isset($_SESSION['id']) && is_numeric($_SESSION['id']);
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
        $_SESSION['id'] = $id;
    }

    /**
     * Удаление данных сессии пользователя
     */
    public function logoutUser()
    {
        unset($_SESSION['id']);
    }
}