<?php 
    $type = $_POST['type'];
    $index_path = $_POST['path'];
    include('functions.php');
    
    if($type == 'add'){
        $bookmarks = getBookmarks();
        $bookmarks[] = array('name' => $_POST['name'], 'url' => $_POST['url']);
        if(file_put_contents($bookmark_file , json_encode($bookmarks))){
            setFlash('success', 'saved');
        }else{
            setFlash('error', 'no_saved');
        }
    }elseif($type == 'edit'){
        $bookmarks = getBookmarks();
        $bookmarks[$_POST['id']] = array('name' => $_POST['name'], 'url' => $_POST['url']);
        if(file_put_contents($bookmark_file , json_encode($bookmarks))){
            setFlash('success', 'saved');
        }else{
            setFlash('error', 'no_saved');
        }
    }elseif($type == 'delete'){
        $bookmarks = getBookmarks();
        unset($bookmarks[$_POST['id']]);
        if(file_put_contents($bookmark_file , json_encode($bookmarks))){
            setFlash('success', 'deleted');
        }else{
            setFlash('error', 'no_deleted');
        }
    }

    header("Location: ".$_SERVER['HTTP_REFERER']);
?>