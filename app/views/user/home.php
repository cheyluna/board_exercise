<h1>Welcome <?php eh($_SESSION['name'])?>!</h1>

<p class="alert alert-success">
You have successfully logged in to your account.
</p>
<a class="btn btn-primary" href="<?php eh(url('thread/index')) ?>">View threads</a>
