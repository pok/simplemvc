<?php 

namespace App\Controller\SubC;

class UserX extends \Core\Controller
{
    public function __construct()
    {
        echo "USER CONTROLLER";
    }


    // #[\Core\Route('/users/userC', method: 'GET')]
    // public function listUsers() {
    //     echo 'This is the user c test';
    // }
}