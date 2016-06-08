<?php

/**
 * Class SessionController - Realizar a Autenticação dos usuários
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Login');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $this->tag->setDefault('email', 'jpaulo.bcc@gmail.com');
            $this->tag->setDefault('password', '');
        }
    }

    private function _registerSession(User $user)
    {
        $this->session->set(
            'auth',
            array(
                'id' => $user->id,
                'user' => $user->name
            )
        );
    }

    public function startAction()
    {

        // Post da tela de login
        if ($this->request->isPost()) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('pass');

            $user = User::findFirst(
                array(
                    "email = :email: AND password = :password:",
                    'bind' => array('email' => $email, 'password' => sha1($password))
                )
            );
            if ($user != false) {
                $this->_registerSession($user);
                $this->flash->success('Bem vindo ' . $user->name . '!!');
                return $this->forward('category/index');
            }

            $this->flash->error('Dados Inválidos');
        }

        return $this->forward('session/index');
    }

    /**
     * Logout - Finaliza a sessão atual e redireciona para a home
     *
     * @return unknown
     */

    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Até logo!');
        
        return $this->forward('index');
    }
}