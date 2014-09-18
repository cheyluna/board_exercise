<?php
class LoginController extends AppController
{
    public function index()
    {
        $user = new User;

        // TODO: Show login page
        $this->set(get_defined_vars());
    }

    public function checkUserLogin()
    {
        $login = new Login;
        $user = new User;
        $page = Param::get('page_next', 'index');

        switch ($page) {
            case 'index':
                break;
            case 'thread/index':
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                try {
                    $login->checkValidUser($user);
                } catch (ValidationException $e) {
                    $page = 'index';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
}
