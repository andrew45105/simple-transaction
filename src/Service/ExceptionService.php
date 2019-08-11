<?php

namespace App\Service;

use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

/**
 * Class ExceptionService
 * @package App\Service
 */
class ExceptionService
{
    /**
     * Глобальный обработчик исключений
     *
     * @param \Exception $exception
     */
    public function handleGlobal(\Exception $exception)
    {
        $rs = new ResponseService();
        switch (get_class($exception)) {
            case HttpRouteNotFoundException::class:
                echo $rs->getView('error/404');
                break;
            case HttpMethodNotAllowedException::class:
                echo $rs->getView('error/405');
                break;
            default:
                echo $rs->getView('error/500', [
                    'message' => $exception->getMessage(),
                ]);
                break;
        }
    }
}