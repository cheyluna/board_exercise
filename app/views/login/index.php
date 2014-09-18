<h1>Login</h1>

<form class="well" method="post" action="<?php eh(url('')) ?>">
    <label>Username</label>
    <input type="text" class="span2" name="title" value="<?php eh(Param::get('title')) ?>">
    <label>Password</label>
    <input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
    <br />
    <input type="hidden" name="page_next" value="create_end">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
