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
?>

<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.72.0">
    <title><?= $config['http_host'] ?></title>

    <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link href="<?= $index_path ?>/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
    <!-- Custom styles for this template -->
    <!--<link href="sticky-footer-navbar.css" rel="stylesheet"> -->
    <style>
      main > .container {
        padding: 60px 15px 0;
      }
    </style>
  </head>
  <body class="d-flex flex-column h-100">
    
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container">
            <a class="navbar-brand" href="<?= $config['path'] ?>"><?php echo $config['server_software'] ?></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
                </ul>
                <form class="d-flex">
                <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            </div>
        </nav>
    </header>

    <!-- Begin page content -->
    <main class="flex-shrink-0 mt-4">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          <div class="card border-success mb-4">
            <div class="card-header bg-success text-light">Bookmarks</div>
            <div class="card-body text-info"></div>
            <div class="card-footer"></div>
          </div>

          <div class="card border-info mb-4">
            <div class="card-header bg-info text-light d-flex">
              <span class="card-title">
                Themes
                <code class="bg-light">/srv/http/themes</code>  
              </span>

              <div class="ml-auto dropdown">
                <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </div>  
              
            </div>
            <div class="card-body text-info"></div>
            <div class="card-footer"></div>
          </div>

        </div>

        <div class="col-md-6">
          <div class="card border-dark mb-4">
            <div class="card-header bg-dark text-light">Files in folder <code>/srv/http/</code></div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>
        </div>
    </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
    <div class="container d-md-flex">
          <div class="text-muted"><?= $_SERVER['HTTP_USER_AGENT'] ?></div>
          <div class="text-muted ml-auto"><a href="<?= $index_path.'/bin/info.php' ?>">PHP <?= $config['php_version'] ?></a></div>
        <!--<span class="text-muted">Place sticky footer content here.</span>-->
    </div>
    </footer>

    <script src="<?= $index_path ?>/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-DBjhmceckmzwrnMMrjI7BvG2FmRuxQVaTfFYHgfnrdfqMhxKt445b7j3KBQLolRl" crossorigin="anonymous"></script>  
      
  </body>
</html>
