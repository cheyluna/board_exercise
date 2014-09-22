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

<?php if ($user->isFailedLogin()): ?>
    <div class="alert alert-block">

    <h4 class="alert-heading">Validation error!</h4>
    <div>Invalid <em>username</em> or <em>password</em>.</div>

    </div>
<?php endif ?>

<form class="well" method="post" action="<?php eh(url('user/login')) ?>">
    <label>Username</label>
    <input type="text" class="span3" name="username" title="<?php eh(Param::get('username')) ?>">
    <label>Password</label>
    <input type="text" class="span3" name="password" title="<?php eh(Param::get('password')) ?>">
    <br />
    <input type="hidden" name="page_next" value="home">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div>
<em>Don't have an account yet?</em>
<a class="btn btn-danger" href="<?php eh(url('user/register')) ?>">Register Here</a>
</div>
