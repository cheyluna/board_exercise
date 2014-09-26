<h1>All threads</h1>

<table class="table table-condensed table-striped table-hover">
    <thead>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Date Created</th>
    </tr>
    </thead>
    <?php foreach ($threads as $v): ?>
    <tr>
        <td><a href="<?php eh(url('thread/view', array('thread_id'=>$v->id))) ?>">
            <?php eh($v->title) ?>
            </a>
        </td>
        <td>
            <?php eh($v->name) ?>
        </td>
        <td>
            <?php eh($v->created) ?>
        </td>
    </tr>
    <?php endforeach ?>
</table>
        
<div class="pagination">
    <?php echo $page_links ?>
</div>

<a class="btn btn-primary" href="<?php eh(url('thread/create')) ?>">Create New Thread</a>
