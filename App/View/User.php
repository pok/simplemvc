<?php 
namespace App\Controller;

class UserView extends Core\View
{
    public function __construct()
    {
        echo "USER CONTROLLER";
    }

    // Show the product attributes based on the id.
    public function showAction(int $id, RouteCollection $routes)
    {
        $user = new App\Model\User();
        $user->getFirst($id);

        // require_once APP_ROOT . '/views/product.php';
    }

    public function isAuthorized(){

        $role = Session::getUserRole();
        if(isset($role) && $role === "admin"){
            return true;
        }
        return false;
    }
}