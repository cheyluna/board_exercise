<h1>Edit Profile</h1>

<?php if($is_updated): ?>
    <div class="alert alert-block alert-success">
    <h4 class="alert-heading">Profile Updated!</h4>
    </div>
<?php endif ?>

<?php if ($user->hasError()): ?>
    <div class="alert alert-block">

    <h4 class="alert-heading">Validation error!</h4>
    <?php if (!empty($user->validation_errors['password']['length'])): ?>
        <div><em>Password</em> must be between
        <?php eh($user->validation['password']['length'][1]) ?> and
        <?php eh($user->validation['password']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['confirm_password']['match'])): ?>
        <div><em>Passwords</em> do not match.</div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['name']['format'])): ?>
        <div><em>Name</em> must contain letters only.</div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['email']['format'])): ?>
        <div>Invalid <em>email address</em>.</div>
    <?php endif ?>
    <?php if (!empty($user->validation_errors['email']['availability'])): ?>
        <div><em>Email Address</em> already used by another user.</div>
    <?php endif?>

    </div>
<?php endif ?>

<form class="well" method="POST" action="<?php eh(url('user/profile')) ?>">
<table class="table-condensed">
    <tr>
        <td> <label>Password:</label> </td>
        <td> <input type="password" class="span3" name="password" value="<?php eh(Param::get('password')) ?>" placeholder="********"> </td>
    </tr>
    <tr>
        <td> <label>Confirm Password:</label> </td>
        <td> <input type="password" class="span3" name="confirm_password" value="<?php eh(Param::get('confirm_password')) ?>" placeholder="********"> </td>
    </tr>
    <tr>
        <td> <label>Name:</label> </td>
        <td> <input type="text" class="span3" name="name" value="<?php eh(Param::get('name')) ?>" placeholder="<?php eh($details->name) ?>"> </td>
    </tr>
    <tr>
        <td> <label>Email Address:</label> </td>
        <td> <input type="text" class="span3" name="email" value="<?php eh(Param::get('email')) ?>" placeholder="<?php eh($details->email) ?>"> </td>
    </tr>
    <tr>
        <td> </td>
        <td> <button type="submit" class="btn btn-block btn-primary" name="btnEdit">Update</button> </td>
    </tr>
</table>
</form>
