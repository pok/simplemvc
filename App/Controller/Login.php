<?php 

namespace App\Controller;

class Login extends \Core\Controller
{
    #[\Core\Route('/login', method: 'GET')]
    public function loginRoute() {
        return $this->renderStandardTemplate('Login', []);
    }
    
    #[\Core\Route('/login', method: 'POST')]
    public function loginPostRoute() {

        $params = $this->request->getParams();
        $connection = \Core\Db::getConnection();

        $userModel = new \App\Model\User($connection);
        $user = $userModel->getUserByUsernameAndPassword($params['username'], $params['password']);

        if (isset($user['id'])) {
            $this->sessionManager->set('user_id', $user['id']);
            $this->sessionManager->set('user_role', $user['role']);
        }

        // TODO: Handle database access

        // return $this->renderStandardTemplate('Login', []);
    }
}