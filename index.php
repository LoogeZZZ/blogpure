<?php
  session_start();

  require_once "core/lib.php";
  require_once "config.php";

  if(isset($_GET["create"])) require_once "core/create.php";
  if(isset($_GET["edit"]) or isset($_GET["update"])) require_once "core/update.php";
  if(isset($_GET["remove"]) or isset($_GET["delete"])) require_once "core/delete.php";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>BezBlog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main>
    <header>
      <h1>BezBlog</h1>
      <p>новости из мира</p>
    </header>
    <nav>
      <?php
        if($_SERVER["REQUEST_URI"] != "/") echo '<a href="/" id="main">Главная</a>';
      ?>
      <a href="?admin" id="login">Админ</a>
    </nav>
    <!-- Новости: начало -->

    <?php
      if(isset($_GET["admin"]) or $id) require_once "core/admin.php";
      else require_once "core/read.php";
    ?>
    
    <!-- Новости: конец -->
    <footer>
      <h3>Все права защищены &copy; Безусов 2015-<?= date("Y")?></h3>
      <p>Всё крутится под PHP сервером на PHP-<?=PHP_VERSION?></p>
    </footer>
  </main>
</body>
</html>