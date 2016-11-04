<?php
    session_start();

    $data_dir = $_SERVER['DOCUMENT_ROOT'].$index_path.'/data/';
    $bookmark_file = $data_dir.'bookmarks.json';

    function getFiles($path){
        $deny_file = ['', '.', '..', 'index', 'index.php'];
        $rep = opendir($_SERVER['DOCUMENT_ROOT'].$path);
        $out = [];
        while ($file = readdir($rep)){
            if( !in_array($file, $deny_file) ){
                if (is_dir($file)){
                    $out[] = ['name'=>$file, 'route'=>$path.$file, 'type'=>'folder'];
                }elseif(is_file($file)){
                    $out[] = ['name'=>$file, 'route'=>$path.$file, 'type'=>'file'];
                }else{
                    $out[] = ['name'=>$file, 'route'=>$path.$file, 'type'=>'link'];
                }
            }
        }
        return $out;
    }

    function getFileLink($path, $name){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$path)){
            return '<li><a href="'.$path.'">'.$name.'</a></li>';
        }
        return false;
    }
    
    function getBookmarks(){
        global $bookmark_file;
        if(file_exists($bookmark_file)){
            $bookmarks = file_get_contents($bookmark_file);
            return json_decode($bookmarks, true);
        }else{
            if(@file_put_contents($bookmark_file , json_encode(array()))){
                return getBookmarks();
            }
            return false;
        }
    }
    
    function setFlash($type, $msg){
        $_SESSION['msg_flash'][] = array(
            'type'=>$type,
            'msg' => $msg
        );
        return true;
    }
    
    function printFlash($close = true){
        global $lang;
        $alert = '';
        if(isset($_SESSION['msg_flash']) && is_array($_SESSION['msg_flash'])){
            foreach($_SESSION['msg_flash'] as $flash) {
                if($flash['type'] == 'success'){
                    $class = 'alert-success';
                }elseif($flash['type'] == 'error'){
                    $class = 'alert-danger';
                }else{
                    $class = 'alert-info';
                }
                
                $alert .= '<div class="alert '.$class.'">'.$lang[$flash['msg']].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            }
            if($close){
                unset($_SESSION['msg_flash']);
            }
        }
        return $alert;
    }

?>