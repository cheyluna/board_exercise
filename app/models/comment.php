<?php
class Comment extends AppModel
{
    CONST MIN_BODY_LENGTH = 1;
    CONST MAX_BODY_LENGTH = 200;

    public $validation = array(
        'body' => array(
            'length' => array(
                'validate_between', self::MIN_BODY_LENGTH, self::MAX_BODY_LENGTH,
            ),
        ),
    );
}
