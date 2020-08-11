<footer class="footer mt-auto py-3 bg-light">
    <div class="container d-md-flex">
          <div class="text-muted"><?= $_SERVER['HTTP_USER_AGENT'] ?></div>
          <div class="text-muted ml-auto"><a href="<?= $index_path.'/bin/info.php' ?>">PHP <?= $config['php_version'] ?></a></div>
        <!--<span class="text-muted">Place sticky footer content here.</span>-->
    </div>
</footer>