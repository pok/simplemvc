<?php 

namespace App\Controller;

class Login extends \Core\Controller
{
    #[\Core\Route('/login', method: 'GET')]
    public function loginRoute() {
        return $this->renderStandardTemplate('Login', []);
    }
}