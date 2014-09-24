<h1><?php eh($thread->title) ?></h1>

<table class="table table-condensed table-striped table-hover">
    <thead>
    <tr>
        <th>Number</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Date Created</th>
    </tr>
    </thead>
    <?php foreach ($comments as $k => $v): ?>
    <tr>
        <td><?php eh($k + 1) ?></td>
        <td><?php eh($v->name) ?></td>
        <td><?php readable_text($v->body) ?></td>
        <td><?php eh($v->created) ?></td>
    </tr>
    <?php endforeach ?>
</table>

<div class="pagination">
    <?php echo $page_links ?>
</div>

<hr>
<form class="well" method="post" action="<?php eh(url("thread/write")) ?>">
    <label>Comment</label>
    <textarea name="body"><?php eh(Param::get("body")) ?></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>
</form> 
