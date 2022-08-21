<?php
define('THEME_DIR', get_stylesheet_directory());
define('THEME_URL', get_stylesheet_directory_uri());

$file_includes = [
    'inc/athelstan-asset.php',
    'inc/athelstan-setup.php',
    'inc/athelstan-custom-field.php',
];
foreach ($file_includes as $file) {
    if (!$filePath = locate_template($file)) {
        trigger_error(sprintf(__('Missing included file'), $file), E_USER_ERROR);
    }
    require_once $filePath;
}

function image_iframe_youtube($url){
    if(!empty($url) && isset($url)){
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $url_type=substr( $url, 0, 29);
            if($url_type=='https://www.youtube.com/embed'){
                $id_image=substr( $url, 30 );
                $url_image="https://img.youtube.com/vi/".$id_image."/hqdefault.jpg";
                $url='<img weight="100" height="100" class="lazyframe-image" src="'.$url_image.'" alt="'.$id_image.'" data-src="https://www.youtube.com/embed/'.$id_image.'">';
            }elseif($url_type=='https://www.youtube.com/watch'){
                $id_image=substr( $url, 32 );
                $url_image="https://img.youtube.com/vi/".$id_image."/hqdefault.jpg";
                $url='<img weight="100" height="100" class="lazyframe-image" src="'.$url_image.'" alt="'.$id_image.'" data-src="https://www.youtube.com/embed/'.$id_image.'">';
            }
        } else {
            $url="<div class='image-error'>Lỗi: Nhập link sẽ tốt hơn!</div>";
        }
    }else{
        $url="<div class='image-error'>Lỗi: Yêu cầu phải nhập link!</div>";
    }
    $data=array(
        'url'=>$url,
        'link_embed'=>"https://www.youtube.com/embed/".$id_image,
    );
    return $data;
}