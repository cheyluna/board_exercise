<?php
class ThreadController extends AppController
{
    public function __construct($name)
    {
        parent::__construct($name);
        if(is_logged_in() === false) {
            redirect($controller = 'user');
        }
    }

    public function index()
    {
        $page = Pagination::setPage(Param::get('page'));
        $sort_by = Param::get('sort_by');
        $sort_order = Param::get('sort_order');

        $threads = Thread::getAll($sort_by, $sort_order, $page);
        $page_links = Pagination::createPageLinks($page, Thread::countThreads());

        $this->set(get_defined_vars());
    }

    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments();

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
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
