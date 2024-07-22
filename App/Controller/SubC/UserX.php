<?php 

namespace App\Controller\SubC;

class UserX extends \Core\Controller
{
    public function __construct()
    {
        echo "USER CONTROLLER";
    }


    #[\Core\Route('/users', method: 'GET')]
    public function listUsers() {
        echo 'This is the list users route';
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