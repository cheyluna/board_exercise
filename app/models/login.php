<?php
class Login extends AppModel
{
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
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }
}
