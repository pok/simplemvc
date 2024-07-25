<?php 

namespace App\Controller;

class User extends \Core\Controller
{
    #[\Core\Authorize('admin')]
    #[\Core\Route('/users', method: 'GET')]
    public function listUsers() {
        echo 'This is the list users route';
    }

    #[\Core\Route('/users/{id}', method: 'GET')]
    public function getUser() {
        echo 'This is the get user route';
    }
    
    #[\Core\Route('/users', method: 'POST')]
    public function createUser() {
        echo 'This is the create user route';
    }
    
    #[\Core\Route('/users/{id}', method: 'DELETE')]
    public function deleteUser() {
        echo 'This is the delete user route';
    }
    
    #[\Core\Route('/users/{id}', method: 'PUT')]
    public function updateUser() {
        echo 'This is the update user route';
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