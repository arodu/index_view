<?php
    define('DS', DIRECTORY_SEPARATOR);
    $config = [
        'server_software' => @array_shift(explode(' ', $_SERVER['SERVER_SOFTWARE'])),
        'lang' => substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2),
        'http_host' => $_SERVER['HTTP_HOST'],
        'folder' => dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME']).DS,
        'path' => ( dirname($_SERVER['SCRIPT_NAME'])==DS ? DS : dirname($_SERVER['SCRIPT_NAME']).DS ),
        'remote_addr' => $_SERVER['REMOTE_ADDR'],
        'server_addr' => $_SERVER['SERVER_ADDR'],
        'php_version' => phpversion(),
    ];

    if(file_exists($core_dir.DS.'lang'.DS.$config['lang'].'.php')){
        include($core_dir.DS.'lang'.DS.$config['lang'].'.php');
    }else{
        include($core_dir.DS.'lang'.DS.'en.php');
    }

    include($core_dir.DS.'bin'.DS.'functions.php');

    $path = isset($_GET['path']) ? $_GET['path'] : '';


?>

<!doctype html>
<html lang="en" class="h-100">
  <?php include('includes/head.php') ?>

  <body class="d-flex flex-column h-100">
    
  <header>
    <?php include('includes/navbar.php') ?>
  </header>

  <!-- Begin page content -->
  <main class="flex-shrink-0 mt-4">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          
          <?php include('includes/bookmarks.php') ?>

          <?php include('includes/folder.php') ?>

        </div>

        <div class="col-md-6">
          <?php include('includes/current.php') ?>
        </div>
    </div>
    </main>

    <?php include('includes/footer.php') ?>

    <script src="<?= $index_path ?>/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-DBjhmceckmzwrnMMrjI7BvG2FmRuxQVaTfFYHgfnrdfqMhxKt445b7j3KBQLolRl" crossorigin="anonymous"></script>  
      
  </body>
</html>
