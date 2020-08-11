<?php $current = $path ?>

<div class="card border-dark mb-4">
  <div class="card-header bg-dark text-light">Files in folder <code class="bg-light"><?= $current ?></code></div>
  <ul class="list-group list-group-flush">

      <?php if($current !== ''){ ?>
        <li class="list-group-item">
          <a href="#">..</a>
        </li>
        <?php //var_dump($current) ?>
      <?php } ?>

      <?php foreach (getFiles($current) as $file): ?>
        <?php
          switch($file['type']){
            
            case 'folder':
                $route = '?path='.$file['route'].'/';
              break;
          
            case 'link':
            case 'file':
            case 'app':
            default:
                $route = $file['route'];
              break;
          }  
        ?>

        <li class="list-group-item">
          <a href="<?= $route ?>">
            <?= $file['name'] ?>
          </a>
        </li>

      <?php endforeach; ?>
  </ul>
</div>

<pre>
<?php //var_dump($config) ?>
<?php //var_dump($current) ?>

</pre>