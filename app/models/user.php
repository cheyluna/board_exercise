<?php
class User extends AppModel
{
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
}
