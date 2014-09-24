<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DietCake <?php eh($title) ?></title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
      }
    </style>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <?php if (isset($_SESSION['username'])): ?>
          <a class="brand pull-left" href="#"><i class="icon-fire"></i> DietCake Board Exercise</a>
          <a class="btn btn-danger btn-small navbar-btn pull-right" href="<?php eh(url('user/logout')) ?>">Log Out</a>
          <a class="btn btn-info btn-small navbar-btn pull-right" href="<?php eh(url('user/profile')) ?>"><i class="icon-user"></i> Profile</a>
          <a class="btn btn-default btn-small navbar-btn pull-right" href="/"><i class="icon-home"></i> Home</a>
          <p class="navbar-text pull-right">Hello <?php eh($_SESSION['name'])?>!&nbsp;</p>
          </p>
          <? else: ?>
          <a class="brand pull-left" href="#"><i class="icon-fire"></i> DietCake Board Exercise</a>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $_content_ ?>

    </div>

    <script>
    console.log(<?php eh(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
