<?php
class User extends AppModel
{
    private $is_failed_login = false;

    const MIN_USER_LENGTH = 1;
    const MAX_USER_LENGTH = 20;
    const MIN_PASSWORD_LENGTH = 1;
    const MAX_PASSWORD_LENGTH = 20;

    public $validation = array(
        'name' => array (
            'format' => array(
                'letters_only',
            ),
        ),

        'email' => array(
            'format' => array(
                'email_valid',
            ),
            'availability' => array(
                'is_not_available',
            ),
        ),

        'username' => array(
            'length' => array(
                'validate_between', self::MIN_USER_LENGTH, self::MAX_USER_LENGTH,
            ),
            'availability' => array(
                'is_not_available',
            ),
        ),

        'password' => array(
            'length' => array(
                'validate_between', self::MIN_PASSWORD_LENGTH, self::MAX_PASSWORD_LENGTH,
            ),
        ),

        'confirm_password' => array(
            'match' => array(
                'match_password',
            ),
        ),
    );

    /**
    * Add a new user
    * @param $user
    */
    public function register(User $user)
    {
        $this->validation['name']['format'][] = $this->name;
        $this->validation['email']['format'][] = $this->email;
        $this->email_exists = $this->checkAvailability($this->email, $check='email');
        $this->validation['email']['availability'][] = $this->email_exists;
        $this->validation['email']['availability'][] = true;
        $this->username_exists = $this->checkAvailability($this->username, $check='username');
        $this->validation['username']['availability'][] = $this->username_exists;
        $this->validation['username']['availability'][] = true;
        $this->validation['confirm_password']['match'][] = $this->password;
        $this->validation['confirm_password']['match'][] = $this->confirm_password;
        $this->validate();

        if($this->hasError()) {
            throw new ValidationException("invalid inputs");
        } else {
            $params = array(
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'password' => sha1($this->password)
            );
        }

        $db = DB::conn();
        $db->insert('user', $params);
    }

    /**
    * Check if username/email already exists
    * @return single value
    */
    public function checkAvailability($input, $check)
    {
        switch ($check) {
            case 'username':
               $query = "SELECT username FROM user WHERE username = ?";
                break;
            case 'email':
                $query = "SELECT email FROM user WHERE email = ?";
                break;
            default:
                $query = "";
                break;
        }

        $db = DB::conn();
        $row = $db->value($query, array($input));
        return $row;
    }

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
