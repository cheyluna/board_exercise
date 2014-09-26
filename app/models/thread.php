<?php
class Thread extends AppModel
{
    CONST MIN_TITLE_LENGTH = 1;
    CONST MAX_TITLE_LENGTH = 30;

    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', self::MIN_TITLE_LENGTH, self::MAX_TITLE_LENGTH,
            ),
        ),
    );

    /**
    * Get details for single thread
    * @param integer $id thread ID
    * @return object $row
    */
    public static function get($thread_id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($thread_id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }

    /**
    * Get details for all threads
    * @param integer $page the current page number
    * @return array array_slice($threads, $offset, $limit)
    */
    public static function getAll($page)
    {
        $threads = array();

        $db = DB::conn();
        $rows = $db->rows('
            SELECT t.id, t.title, u.name, t.created
            FROM thread t
            INNER JOIN user u ON t.user_id = u.id
            ORDER BY created DESC'
        );
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }

        $limit = Pagination::MAX_ROWS;
        $offset = ($page - 1) * Pagination::MAX_ROWS;
        return array_slice($threads, $offset, $limit);
    }

    /**
    * Get comments for a specific thread
    * @param integer $page the current page number
    * @return array array_slice($comments, $offset, $limit)
    */
    public function getComments($page)
    {
        $comments = array();

        $db = DB::conn();
        $rows = $db->rows('
            SELECT c.id, c.body, u.name, c.created
            FROM comment c
            INNER JOIN user u ON c.user_id = u.id
            WHERE thread_id = ?
            ORDER BY created ASC',
            array($this->id)
        );
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }

        $limit = Pagination::MAX_ROWS;
        $offset = ($page - 1) * Pagination::MAX_ROWS;
        return array_slice($comments, $offset, $limit);
    }

    /**
    * Write a new comment
    * @param object $comment new comment object for validation before insert
    */
    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }

        $db = DB::conn();
        $db->query('
            INSERT INTO comment
            SET thread_id = ?, user_id = ?, body = ?',
            array($this->id, $_SESSION['id'], $comment->body)
        );
    }

    /**
    * Create a new thread along with its first comment
    * @param object $comment new comment object
    */
    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }

        try {
            $db = DB::conn();
            $db->begin();
            $params = array(
                'user_id' => $_SESSION['id'],
                'title' => $this->title,
            );
            $db->insert('thread', $params);

            // write first comment at the same time
            $this->id = $db->lastInsertId();
            $this->write($comment);

            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }


    /**
    * Sort all threads
    * @param string $sort_by column name to use for sorting
    * @param string $sort_order may be ASC or DESC
    * @return string $order_by
    */
    public static function sortThreads($sort_by, $sort_order)
    {
        switch ($sort_by) {
            case 'title':
                $order_by = "ORDER BY t.title {$sort_order}";
                break;
            case 'author':
                $order_by = "ORDER BY u.username {$sort_order}";
                break;
            case 'created':
                $order_by = "ORDER BY t.created {$sort_order}";
                break;
            default:
                $order_by = 'ORDER BY u.username ASC';
                break;
        }
        return $order_by;
    }

    /**
    * Count total number of all threads in DB for pagination
    * @return integer $thread_count
    */
    public static function countThreads()
    {
        $db = DB::conn();
        $thread_count = $db->value('SELECT COUNT(id) FROM thread');

        return $thread_count;
    }

    /**
    * Count total number of all comments per thread in DB for pagination
    * @return integer $comment_count
    */
    public static function countComments($thread_id)
    {
        $db = DB::conn();
        $comment_count = $db->value('
            SELECT COUNT(id)
            FROM comment
            WHERE thread_id = ?',
            array($thread_id)
        );

        return $comment_count;
    }
}
