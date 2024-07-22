<?php

namespace Core;

class Router {

    private array $routes = [];

    public function __construct(string $rootPath) {
        $controllers = $this->getControllers($rootPath);
        $this->loadRoutes($controllers);
    }

    public function getControllers($rootPath, $childPath = '') {
        $controllers = [];

        $files = scandir($rootPath.$childPath, SCANDIR_SORT_ASCENDING);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || 0 === stripos($file, 'Abstract')) {
                continue;
            }

            if (is_dir($rootPath.$childPath.DIRECTORY_SEPARATOR.$file)) {
                $controllers = [...$controllers, ...$this->getControllers($rootPath,$childPath.DIRECTORY_SEPARATOR.$file)];
                continue;
            }
    
            $file = explode('.', $file);
            $file = $file[0];

            array_push(
                $controllers,
                $childPath.DIRECTORY_SEPARATOR.$file
            );
        }

        return $controllers;
    }

    public function loadRoutes($controllers)
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass('App\\Controller\\'.str_replace(DIRECTORY_SEPARATOR, '\\', substr($controller, 1)));

            foreach ($reflectionController->getMethods() as $reflectionMethod) {
                $routeAttributes = $reflectionMethod->getAttributes(\Core\Route::class);

                foreach ($routeAttributes as $routeAttribute) {
                    $route = $routeAttribute->newInstance();
                    $this->routes[$route->getName()] = [
                        'class'  => $reflectionMethod->class,
                        'method' => $reflectionMethod->name,
                        'route'  => $route,
                    ];
                }
            }
        }

    }

    public function match(): ?array
    {
        echo SITEROOT;

        // $request = substring(strlen(SITEROOT), $_SERVER['REQUEST_URI']);

        // echo $request;

        // if (!empty($this->baseURI)) {
        //     $baseURI = preg_quote($this->baseURI, '/');
        //     $request = preg_replace("/^{$baseURI}/", '', $request);
        // }
        // $request = (empty($request) ? '/': $request);

        // foreach ($this->routes as $route) {
        //     if ($this->matchRequest($request, $route['route'], $params)) {
        //         return [
        //             'class'  => $route['class'],
        //             'method' => $route['method'],
        //             'params' => $params,
        //         ];
        //     }
        // }

        return null;
    }

    private function matchRequest(string $request, Route $route, ?array &$params = []): bool
    {
        $requestArray = explode('/', $request);
        $pathArray = explode('/', $route->getPath());

        // Remove empty values in arrays
        $requestArray = array_values(array_filter($requestArray, 'strlen'));
        $pathArray = array_values(array_filter($pathArray, 'strlen'));

        if (!(count($requestArray) === count($pathArray)) || ($_SERVER['REQUEST_METHOD'] !== $route->getMethod())) {
            return false;
        }

        foreach ($pathArray as $index => $urlPart) {
            if (isset($requestArray[$index])) {
                if (str_starts_with($urlPart, '{')) {
                    $routeParameter = explode(' ', preg_replace('/{([\w\-%]+)(<(.+)>)?}/', '$1 $3', $urlPart));
                    $paramName = $routeParameter[0];
                    $paramRegExp = (empty($routeParameter[1]) ? '[\w\-]+': $routeParameter[1]);

                    if (preg_match('/^' . $paramRegExp . '$/', $requestArray[$index])) {
                        $params[$paramName] = $requestArray[$index];

                        continue;
                    }
                } elseif ($urlPart === $requestArray[$index]) {
                    continue;
                }
            }

            return false;
        }

        return true;
    }
}