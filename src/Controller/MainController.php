<?php

namespace App\Controller;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends BaseController
{
    /**
     * Маршрут GET /
     */
    public function getIndex()
    {
        if (!$this->userLogged()) {
            header('Location: /login');
        }
        $id = $this->getUserId();
        // Закрываем сессию после получения id текущего пользователя
        session_write_close();

        if (!$user = $this->getDBService()->getUserById($id)) {
            return $this->getErrorView('Пользователь не найден' , '/');
        }

        return $this->getView('main', [
            'title' => 'Управление средствами аккаунта',
            'user'  => $user,
        ]);
    }

    /**
     * Маршрут POST /
     */
    public function postIndex()
    {
        if (!$this->userLogged()) {
            header('Location: /login');
        }
        $id = $this->getUserId();
        // Закрываем сессию после получения id текущего пользователя
        session_write_close();

        if (!$user = $this->getDBService()->getUserById($id)) {
            return $this->getErrorView('Пользователь не найден' , '/');
        }

        $clearTextSum = strip_tags(trim($_POST['sum']));
        $sum = round(floatval($clearTextSum), 2);
        if (!$sum) {
            return $this->getErrorView('Некорректная сумма списания ' . $clearTextSum , '/');
        }
        // Первичная проверка суммы
        if ($sum > floatval($user['amount'])) {
            return $this->getErrorView('Сумма списания больше имеющейся', '/');
        }

        $pdo = $this->getPDO();
        $pdo->setAttribute(\PDO::ATTR_PERSISTENT, true);
        $pdo->beginTransaction();

        try {
            // Списываем только, если сумма не больше имеющейся
            $stmt = $pdo->prepare("UPDATE user SET amount = CASE WHEN amount >= :sum THEN amount - :sum ELSE amount END WHERE id = :id");
            $stmt->execute([':sum' => $sum, ':id' => $id]);

            // Какие-то другие возможные действия

            $pdo->commit();

            header('Location: /');

        } catch (\Exception $e) {
            $pdo->rollBack();
            // Запись в лог/БД $e->getMessage()
            // ...
            return $this->getErrorView('Ошибка при списании средств', '/');
        }
    }

    /**
     * Маршрут GET /login
     */
    public function getLogin()
    {
        if ($this->userLogged()){
            header('Location: /');
        }

        return $this->getView('login', [
            'title' => 'Форма входа',
        ]);
    }

    /**
     * Маршрут POST /login
     */
    public function postLogin()
    {
        if ($this->userLogged()){
            header('Location: /');
        }

        $login = trim(strip_tags($_POST['login']));
        $password = trim(strip_tags($_POST['password']));
        if (!$login || !$password) {
            return $this->getErrorView('Не указан логин или пароль' , '/login');
        }

        if ($user = $this->getDBService()->getUserByLogin($login)) {
            $hash = $user['password'];
            if (password_verify($password, $hash)) {
                session_start();
                $this->loginUser($user['id']);
                header('Location: /');
            }
        }
        return $this->getErrorView('Неверный логин или пароль' , '/login');
    }

    /**
     * Маршрут GET /logout
     */
    public function getLogout()
    {
        $this->logoutUser();
        header('Location: /login');
    }
}