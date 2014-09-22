<?php
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 30,
            ),
        ),
    );

    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }

    public static function getAll($sort_by, $order, $page)
    {
        $threads = array();
        $order_by = self::sortThreads($sort_by, $order);

        $db = DB::conn();
        $rows = $db->rows("SELECT t.id, t.title, u.username, t.created FROM thread t
        INNER JOIN user u ON t.user_id = u.id {$order_by}");
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }

        $limit = Pagination::MAX_ROWS;
        $offset = ($page - 1) * Pagination::MAX_ROWS;
        return array_slice($threads, $offset, $limit);
    }

    public function getComments()
    {
        $comments = array();

        $db = DB::conn();
        $rows = $db->rows(
        'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC',
        array($this->id)
        );
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }

        return $comments;
    }

    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }

        $db = DB::conn();
        $db->query(
        'INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()',
        array($this->id, $comment->username, $comment->body)
        );
    }

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }

        $db = DB::conn();
        $db->begin();
        $params = array(
            'title' => $this->title,
        );
        $db->insert('thread', $params);
        $this->id = $db->lastInsertId();

        // write first comment at the same time
        $this->write($comment);

        $db->commit();
    }


    /**
    * Sort all threads
    * @param $sort_by, $sort_order
    * @return order by query script
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
                $order_by = "ORDER BY u.username ASC";
                break;
        }
        return $order_by;
    }

    /**
    * Count total number of all threads in DB for pagination
    * @return int
    */
    public static function countThreads()
    {
        $db = DB::conn();
        $thread_count = $db->value("SELECT COUNT(id) FROM thread");

        return $thread_count;
    }
}
