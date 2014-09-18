<?php
class LoginController extends AppController
{
    public function index()
    {
        // TODO: Show login page
        $this->set(get_defined_vars());
    }

    public function checkUserLogin()
    {
        $unvalidated_user = new User;
        $page = Param::get('page_next');

        switch ($page) {
            case 'thread/index':
                $unvalidated_user->username = Param::get('username');
                $unvalidated_user->password = Param::get('password');
                $validated_user = Login::checkValidUser($unvalidated_user);
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
}
