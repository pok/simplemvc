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
                $authorizeAttributes = $reflectionMethod->getAttributes(\Core\Authorize::class);

                
                foreach ($routeAttributes as $routeAttribute) {
                    $requireRole = false;
                    if (count($authorizeAttributes) > 0) {
                        $auth = $authorizeAttributes[0]->newInstance();
                        $requireRole = $auth->getRole();

                    }
                    $route = $routeAttribute->newInstance();
                    $this->routes[$reflectionMethod->class.'--'.$reflectionMethod->name] = [
                        'class'  => $reflectionMethod->class,
                        'method' => $reflectionMethod->name,
                        'route'  => $route,
                        'requireRole' => $requireRole
                    ];
                }
            }
        }

    }

    public function match(): ?array
    {
        $baseURI = preg_quote(SITEROOT, '/');
        $request = preg_replace("/^{$baseURI}/", '', $_SERVER['REQUEST_URI']);
        $request = (empty($request) ? '/': $request);

        foreach ($this->routes as $route) {
            if ($this->matchRequest($request, $route['route'], $params)) {
                return [
                    'class'  => $route['class'],
                    'method' => $route['method'],
                    'params' => $params,
                    'requireRole' => $route['requireRole']
                ];
            }
        }

        echo 'ROUTE NOT FOUND :(';

        return null;
    }

    private function matchRequest(string $request, Route $route, ?array &$params = []): bool
    {
        $requestArray = explode('/', $request);
        $pathArray = explode('/', $route->getPath());

        $requestArray = array_values(array_filter($requestArray, 'strlen'));
        $pathArray = array_values(array_filter($pathArray, 'strlen'));

        // Not the right method
        if ($_SERVER['REQUEST_METHOD'] !== $route->getMethod()) {
            return false;
        }

        if (!(count($requestArray) === count($pathArray))) {
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