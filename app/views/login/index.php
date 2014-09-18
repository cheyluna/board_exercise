<h1>Login</h1>

<form class="well" method="post" action="<?php eh(url('login/checkUserLogin')) ?>">
    <label>Username</label>
    <input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
    <label>Password</label>
    <input type="text" class="span2" name="password" value="<?php eh(Param::get('password')) ?>">
    <br />
    <input type="hidden" name="page_next" value="thread/index">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
