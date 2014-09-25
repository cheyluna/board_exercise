<?php
class UserController extends AppController
{
    public function register()
    {
        if(is_logged_in()) {
            redirect($controller = 'thread');
        }

        $user = new User;
        $page = Param::get('next_page', 'register');

        switch ($page) {
            case 'register':
                break;
            case 'register_ok':
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                $user->username = Param::get('username');
                $user->password = Param::get('password');
                $user->confirm_password = Param::get('confirm_password');   

                try {
                    $user->register($user);
                } catch (ValidationException $e) {
                    $page = 'register';
                }
                break;
            default:
                throw new NotFoundException("{$page} not found");
            break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function login()
    {
        if(is_logged_in()) {
            redirect($controller = 'thread');
        }

        $user = new User;
        $page = Param::get('page_next', 'login');

        switch ($page) {
            case 'login':
                break;
            case 'home':
                $user->username = Param::get('username');
                $user->password = param::get('password');
                $user->sha1_password = sha1($user->password);

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

    public function profile()
    {
        if(is_logged_in() === false) {
            redirect();
        }

        $update = false;
        $user = new User;
        $user->id = $_SESSION['id'];
        $details = $user->getDetails($user->id);

        if(isset($_POST['btnEdit'])) {
            try {
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                $user->password = Param::get('password');
                $user->confirm_password = Param::get('confirm_password');
                $update = $user->updateProfile($user);
            } catch (ValidationException $e) {
                //invalid input message set to view
            }
        }

        $this->set(get_defined_vars());
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        redirect($controller = 'login');
    }
}
