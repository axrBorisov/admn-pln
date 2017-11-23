<?php

class Router
{

    /**
     * @param Request $request
     */
    public static function route(Request $request): void
    {
        $controller = ucfirst($request->getController()) . 'Controller';
        $method = 'action_' . $request->getMethod();

        $args = $request->getArgs();
        $controllerFile = SITE_PATH . '/controllers/' . $controller . '.php';
        try {
            if (!is_readable($controllerFile)) {
                throw new RuntimeException('An unknown error occurred while accessing the controller');
            }

            include_once $controllerFile;

            /** @var BaseController $controller */
            $controller = new $controller;
            $method = is_callable([$controller, $method]) ? $method : 'Index';
            if (!empty($args)) {
                $controller->request($method, $args);
            } else {
                $controller->request($method);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            $controller = new ErrorController($request->getController());
            $controller->error();
        }

}
}