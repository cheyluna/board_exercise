<?php
class User extends AppModel
{
    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1, 20,
            ),
        ),

        'body' => array(
            'length' => array(
                'validate_between', 1, 20,
            ),
        ),
    );
}
