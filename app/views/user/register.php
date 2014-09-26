<h1>User Registration</h1>

<?php if ($user->hasError()): ?>
    <div class="alert alert-block">

    <h4 class="alert-heading">Validation error!</h4>
    <?php if (!empty($user->validation_errors['name']['format'])): ?>
        <div><em>Name</em> must contain letters only.</div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['email']['format'])): ?>
        <div>Invalid <em>email address</em>.</div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['email']['availability'])): ?>
        <div><em>Email Address</em> already used by another user.</div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['username']['length'])): ?>
        <div><em>Username</em> must be between
        <?php eh($user->validation['username']['length'][1]) ?> and
        <?php eh($user->validation['username']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['username']['availability'])): ?>
        <div><em>Username</em> already exists.</div>
    <?php endif?>
    <?php if (!empty($user->validation_errors['password']['length'])): ?>
        <div><em>Password</em> must be between
        <?php eh($user->validation['password']['length'][1]) ?> and
        <?php eh($user->validation['password']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['confirm_password']['match'])): ?>
        <div><em>Passwords</em> do not match.</div>
    <?php endif ?>

    </div>
<?php endif ?>

<form class="well" method="POST" action="<?php eh(url('user/register')) ?>">
<table class="table-condensed">
    <tr>
        <td> <label>Name:</label> </td>
        <td> <input type="text" class="span3" name="name" value="<?php eh(Param::get('name')) ?>"> </td>
    </tr>
    <tr>
        <td> <label>Email Address:</label> </td>
        <td> <input type="text" class="span3" name="email" value="<?php eh(Param::get('email')) ?>"> </td>
    </tr>
    <tr>
        <td> <label>Username:</label> </td>
        <td> <input type="text" class="span3" name="username" value="<?php eh(Param::get('username')) ?>"> </td>
    </tr>
    <tr>
        <td> <label>Password:</label> </td>
        <td> <input type="password" class="span3" name="password" value="<?php eh(Param::get('password')) ?>"> </td>
    </tr>
    <tr>
        <td> <label>Confirm Password:</label> </td>
        <td> <input type="password" class="span3" name="confirm_password" value="<?php eh(Param::get('confirm_password')) ?>"> </td>
    </tr>
    <tr>
        <td> </td>
        <td> <button type="submit" class="btn btn-block btn-primary" name="btnRegister">Submit</button> </td>
    </tr>
</table>

<input type="hidden" name="next_page" value="register_ok">
</form>
