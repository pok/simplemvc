<?php 

namespace App\Controller;

class Home extends \Core\Controller
{
    public function __construct()
    {
        echo "HOME CONTROLLER";
    }


    #[\Core\Route('/', method: 'GET')]
    public function listHome() {
        echo 'This is the list home route';
    }

    // Show the product attributes based on the id.
    // public function showAction(int $id, RouteCollection $routes)
    // {
    //     $user = new App\Model\User();
    //     $user->getFirst($id);

    //     // require_once APP_ROOT . '/views/product.php';
    // }

    // public function isAuthorized(){

    //     $role = Session::getUserRole();
    //     if(isset($role) && $role === "admin"){
    //         return true;
    //     }
    //     return false;
    // }
}