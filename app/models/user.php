<?php
class User extends AppModel
{
    private $is_failed_login = false;

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1, 20,
            ),
        ),

        'password' => array(
            'length' => array(
                'validate_between', 1, 20,
            ),
        ),
    );

    public function checkValidUser(User $user)
    {
        if(!$user->validate()) {
            throw new ValidationException('invalid user');
        }

        $db = DB::conn();
        $row = $db->row(
        'SELECT * FROM user WHERE username = ? AND password = ?',
        array($user->username, $user->password)
        );

        if (!$row) {
            $this->is_failed_login = true;
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }

    /**
    * Flag for unsuccessful login
    */
    public function isFailedLogin()
    {
        return $this->is_failed_login;
    }
}
