<h1>Login</h1>

<?php if ($user->hasError()): ?>
    <div class="alert alert-block">

    <h4 class="alert-heading">Validation error!</h4>
    <?php if (!empty($user->validation_errors['username']['length'])): ?>
        <div><em>Username</em> must be between
        <?php eh($user->validation['username']['length'][1]) ?> and
        <?php eh($user->validation['username']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>

    <?php if (!empty($user->validation_errors['password']['length'])): ?>
        <div><em>Password</em> must be between
        <?php eh($user->validation['password']['length'][1]) ?> and
        <?php eh($user->validation['password']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>

    </div>
<?php endif ?>

<form class="well" method="post" action="<?php eh(url('login/checkUserLogin')) ?>">
    <label>Username</label>
    <input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
    <label>Password</label>
    <input type="text" class="span2" name="password" value="<?php eh(Param::get('password')) ?>">
    <br />
    <input type="hidden" name="page_next" value="thread/index">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
