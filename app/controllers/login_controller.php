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
                    $user = $login->checkValidUser($user);
                } catch (Exception $e) {
                    $user->error_message = $e->getMessage();
                    $page = 'index';
                } 
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        if(!empty($user->error_message)) {
            return $this->render($page);
        } 
         
        redirect($page);
    }
}
