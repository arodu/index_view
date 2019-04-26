<?php
    $config = [
        'server_software' => @array_shift(explode(' ', $_SERVER['SERVER_SOFTWARE'])),
        'lang' => substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2),
        'server_name' => $_SERVER['SERVER_NAME'],
        'folder' => dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME']).'/',
        'path' => ( dirname($_SERVER['SCRIPT_NAME'])=='/' ? '/' : dirname($_SERVER['SCRIPT_NAME']).'/' ),
        'remote_addr' => $_SERVER['REMOTE_ADDR'],
        'server_addr' => $_SERVER['SERVER_ADDR'],
        'php_version' => phpversion(),
    ];

    if(file_exists($core_dir.'/lang/'.$config['lang'].'.php')){
        include($core_dir.'/lang/'.$config['lang'].'.php');
    }else{
        include($core_dir.'/lang/en.php');
    }

    include($core_dir.'/bin/functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <title><?= $config['server_name'] ?></title>
    <link rel="stylesheet" href="<?php echo $index_path.'/vendor/bootstrap/dist/css/bootstrap.min.css'?>" />
    <link rel="stylesheet" href="<?php echo $index_path.'/bin/css/style.css'?>" />

    <style media="screen">
        .list-group-hover {
            color: #555;
            text-decoration: none;
            background-color: #f5f5f5;
        }
    </style>

</head>
<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $config['path'] ?>"><?php echo $config['server_software'] ?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">

                <p class="navbar-text">
                    <span class="badge"><span class="glyphicon glyphicon-map-marker"></span><?= $config['remote_addr'] ?></span>
                    <span class="glyphicon glyphicon-resize-horizontal"></span>
                    <span class="badge"><span class="glyphicon glyphicon-globe"></span><?= $config['server_addr'] ?></span>
                </p>


                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" data-toggle="modal" data-target="#bookmarkModal" data-type="add"><span class="glyphicon glyphicon-plus"></span><?= $lang['add'] ?></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span><?= $lang['options'] ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php echo getFileLink($index_path.'/bin/info.php', 'PHP Info') ?>
                            <?php echo getFileLink('/phpmyadmin', 'PhpMyAdmin') ?>
                            <?php echo getFileLink('/PhpMyAdmin', 'PhpMyAdmin') ?>
                            <?php echo getFileLink('/phpmyadmin', 'PhpMyAdmin', '/usr/share/webapps/phpMyAdmin') ?>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">

        <?php  if(!is_writable($data_dir)): ?>
            <div class="alert alert-warning">
                <strong>Warning: </strong><?php printf($lang['no_write'], $data_dir); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <?php endif; ?>

        <?= printFlash() ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading"><?= $lang['bookmarks'] ?></div>
                    <div class="list-group">
                        <?php
                            $bookmarks = getBookmarks();
                            if(!empty($bookmarks)){
                                foreach ($bookmarks as $id => $bookmark):
                                    ?>
                                    <span class="list-group-item" >
                                        <a href="<?= $bookmark['url'] ?>" data-id="<?= $id ?>">
                                            <span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span>
                                            &nbsp;&nbsp;<?= $bookmark['name'] ?>
                                        </a>
                                        <div class="controls pull-right hidden">
                                            <a href="<?= $bookmark['url'] ?>" target="_blank"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>&nbsp;
                                            <a href="#" data-toggle="modal" data-target="#bookmarkModal" data-type="edit" data-name="<?= $bookmark['name'] ?>" data-url="<?= $bookmark['url'] ?>" data-id="<?= $id ?>"><span class=" glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;
                                            <a href="#" data-toggle="modal" data-target="#bookmarkDeleteModal" data-type="delete" data-name="<?= $bookmark['name'] ?>" data-id="<?= $id ?>"><span class=" glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                        </div>
                                    </span>
                                    <?php
                                endforeach;
                            }else{
                                echo '<span href="#" class="list-group-item text-center">'.$lang['no_info'].'</span>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><?= $lang['files_in_folder'].' <code>'.$config['folder'].'</code>' ?></div>
                    <!-- <div class="panel-body"></div> -->
                    <div class="list-group">
                        <?php
                            foreach (getFiles($config['path']) as $file):
                                switch($file['type']){
                                    case 'file': $icon='glyphicon glyphicon-file'; break;
                                    case 'folder': $icon='glyphicon glyphicon-folder-open'; break;
                                    case 'link': $icon='glyphicon glyphicon-link'; break;
                                    default: $icon='glyphicon glyphicon-file'; break;
                                }

                                /*
                                $icon = function($file['type']){
                                    switch($file['type']){
                                        case 'file': return 'glyphicon glyphicon-file';
                                        case 'folder': return 'glyphicon glyphicon-folder-open';
                                        case 'link': return 'glyphicon glyphicon-link';
                                        default: return 'glyphicon glyphicon-file';
                                    }
                                } */

                                ?>
                                <span class="list-group-item" >
                                    <a href="<?= $file['route'] ?>">
                                        <span class="<?= $icon ?>" aria-hidden="true"></span>
                                        &nbsp;&nbsp;<?= $file['name'] ?>
                                    </a>
                                    <div class="controls pull-right hidden">
                                        <a href="<?= $file['route'] ?>" target="_blank"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a>&nbsp;
                                        <a href="#" data-toggle="modal" data-target="#bookmarkModal" data-type="add" data-name="<?= $file['name'] ?>" data-url="<?= $file['route'] ?>">
                                            <span class=" glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                </span>
                                <?php
                            endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="col-md-6 text-left">
                <p class="text-muted"><?= $_SERVER['HTTP_USER_AGENT'] ?></p>
            </div>
            <div class="col-md-6 text-right">
                <p class="text-muted">PHP <?= $config['php_version'] ?></p>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="bookmarkModal" tabindex="-1" role="dialog" aria-labelledby="bookmarkModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"><?= $lang['bookmarks'] ?></h4>
                </div>
                <form action="<?= $index_path.'/bin/bookmarks.php' ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input-name" class="control-label"><?= $lang['name'] ?></label>
                        <input id="input-name" type="text" class="form-control" name="name" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="input-url" class="control-label"><?= $lang['url'] ?></label>
                        <input id="input-url" type="text" class="form-control" name="url" value="http://" required="required" />
                    </div>

                    <input id="input-type" type="hidden" name="type" value="add" />
                    <input id="index-path" type="hidden" name="path" value="<?= $index_path ?>" />
                    <input id="input-id" type="hidden" name="id" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $lang['close'] ?></button>
                    <input type="submit" class="btn btn-primary" value="<?= $lang['save'] ?>" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bookmarkDeleteModal" tabindex="-1" role="dialog" aria-labelledby="bookmarkDeleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= $lang['delete_confirm'] ?></h4>
                </div>
                <form action="<?= $index_path.'/bin/bookmarks.php' ?>" method="post">
                <!-- <div class="modal-body"></div> -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label"><?= $lang['name'] ?></label>
                        <p id="delete-input-name" class="form-control-static"></p>
                    </div>
                    <input id="delete-input-type" type="hidden" name="type" value="delete" />
                    <input id="delete-index-path" type="hidden" name="path" value="<?= $index_path ?>" />
                    <input id="delete-input-id" type="hidden" name="id" value="" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $lang['close'] ?></button>
                    <input type="submit" class="btn btn-danger" value="<?= $lang['delete'] ?>" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo $index_path.'/vendor/jquery/dist/jquery.min.js' ?>" charset="utf-8"></script>
    <script src="<?php echo $index_path.'/vendor/bootstrap/dist/js/bootstrap.min.js' ?>" charset="utf-8"></script>

    <script type="text/javascript">
        $(function(){
            $('#bookmarkModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var type = button.data('type')
                var modal = $(this)
                if(type == 'add'){
                    modal.find('.modal-title').text('<?= $lang['bookmarks'].': '.$lang['add']?>')
                }else if(type == 'edit'){
                    modal.find('.modal-title').text('<?= $lang['bookmarks'].': '.$lang['edit']?>')
                }

                modal.find('#input-name').val('')
                if(button.data('name') != undefined){
                    modal.find('#input-name').val( button.data('name') )
                }

                modal.find('#input-url').val('http://')
                if(button.data('url') != undefined){
                    modal.find('#input-url').val(button.data('url'))
                }

                modal.find('#input-id').val('')
                if(button.data('id') != undefined){
                    modal.find('#input-id').val(button.data('id'))
                }

                modal.find('#input-type').val(type)
            })

            $('#bookmarkDeleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                modal.find('#delete-input-name').html(button.data('name'))
                modal.find('#delete-input-id').val(button.data('id'))
            })

            $('.list-group-item').on('mouseover',function(){
                $(this).addClass('list-group-hover');
                $(this).find('.controls').removeClass('hidden');
            })
            .on('mouseleave',function(){
                $(this).removeClass('list-group-hover');
                $(this).find('.controls').addClass('hidden');
            })

        })

    </script>
</body>
</html>
