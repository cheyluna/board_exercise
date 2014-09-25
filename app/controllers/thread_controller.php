<?php
class ThreadController extends AppController
{
    public function __construct($name)
    {
        parent::__construct($name);
        if (is_logged_in() === false) {
            redirect($controller = 'user');
        }
    }

    /**
    * View threads made by all users
    */

    public function index()
    {
        $page = Pagination::setPage(Param::get('page'));

        $threads = Thread::getAll($page);
        $page_links = Pagination::createPageLinks($page, Thread::countThreads());

        $this->set(get_defined_vars());
    }

    /**
    * View all comments for a specific thread
    */
    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $page = Pagination::setPage(Param::get('page'));

        $comments = $thread->getComments($page);
        Pagination::$pagination_for = 'comment';
        $page_links = Pagination::createPageLinks($page, Thread::countComments($thread->id));

        $this->set(get_defined_vars());
    }

    /**
    * Write a new comment for a specific thread
    */
    public function write()
    {
        $comment = new Comment;
        $thread = Thread::get(Param::get('thread_id'));
        $page = Param::get('page_next');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');

                try {
                    $thread->write($comment);
                } catch (ValidationException $e) {
                    $page = 'write';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    /**
    * Create a new thread
    */
    public function create()
    {
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');

        switch ($page) {
            case 'create':            
                break;
            case 'create_end':
                $thread->title = Param::get('title');
                $comment->body = Param::get('body');

                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {                    
                    $page = 'create';
                }                    
                break;
            default:
                throw new NotFoundException("{$page} is not found");    
                break;
        }

        $this->set(get_defined_vars());    
        $this->render($page);
    }
}
