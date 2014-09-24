<?php
class User extends AppModel
{
    private $is_failed_login = false;

    const MIN_USER_LENGTH = 1;
    const MAX_USER_LENGTH = 20;
    const MIN_PASSWORD_LENGTH = 1;
    const MAX_PASSWORD_LENGTH = 20;

    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', self::MIN_USER_LENGTH, self::MAX_USER_LENGTH,
            ),
        ),

        'password' => array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD_LENGTH, self::MAX_PASSWORD_LENGTH,
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
        array($user->username, $user->sha1_password)
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
