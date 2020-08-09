<?php
  $config = [
    'data_dir' => $_SERVER['DOCUMENT_ROOT'].$index_path.'/data/',
    'bookmark_file' => 'bookmarks.json',
    'deny_files' = ['', '.', '..', 'index', 'index_view', 'index.php'],
  ];
