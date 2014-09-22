<?php
class UserController extends AppController
{
    public function register()
    {
    }

    public function login()
    {
        if(is_logged_in() === true) {
            redirect($controller = 'thread');
        }

        $user = new User;
        $page = Param::get('page_next', 'login');

        switch ($page) {
            case 'login':
                break;
            case 'home':
                $user->username = Param::get('username');
                $user->password = sha1(param::get('password'));

                try {
                    $account = $user->checkValidUser($user);
                    $_SESSION['id'] = $account->id;
                    $_SESSION['username'] = $account->username;
                    $_SESSION['name'] = $account->name;
                } catch (Exception $e) {
                    $page = 'login';
                } 
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        redirect($controller = 'login');
    }
}
