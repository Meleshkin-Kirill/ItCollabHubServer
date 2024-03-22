<?php
    include_once '/mail_library/mail1.php';
    include_once 'rb.php';
    
    if(!R::testConnection()){
        R::setup('ХОСТ БД', 'ЛОГИН ОТ БД', 'ПАРОЛЬ ОТ БД');
    }
    
    if(!R::testConnection()){
        echo "ОШИБКА ПОДКЛЮЧЕНИЯ";
        exit;
    }
    
    function create_text_block($project_id, $user_mail, $text_block){
        date_default_timezone_set('UTC-3');
    
        $block = R::dispense('texts');
        $block->projectID = $project_id;
        $block->text = $text_block;
        $block->data = date("d.m.Y");
        $block->time = date("H:i:s");
        
        R::store($block);
        
        return R::count('texts');
    }
    function create_link_block($project_id, $user_mail, $name_link_block, $link_block){
        date_default_timezone_set('UTC-3');
    
        $block = R::dispense('links');
        $block->projectID = $project_id;
        $block->name = $name_link_block;
        if(filter_var($link_block, FILTER_VALIDATE_URL)){
            $block->link = $link_block;
        }
        else{
            $block->link = "https://itcollabhub.xyz/";
        }
        $block->data = date("d.m.Y");
        $block->time = date("H:i:s");
        
        R::store($block);
        
        return R::count('links');
    }
    function create_image_block($project_id, $user_mail, $name_image_block, $image){
        date_default_timezone_set('UTC-3');
        
        $vsp = R::count('images');
    
        $block = R::dispense('images');
        $block->projectID = $project_id;
        $block->name = $name_image_block;
        
        move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/blocks/images/" . (strval($vsp) + 1) . ".png");
        $block->photoLocalLink = "https://serveritcollabhub.development-team.ru/blocks/images/" . (strval($vsp) + 1) . ".png";
        
        $block->data = date("d.m.Y");
        $block->time = date("H:i:s");
        
        R::store($block);
        
        return R::count('images');
    }
    function create_youtube_block($project_id, $user_mail, $name_YouTube_block, $YouTube_block){
        date_default_timezone_set('UTC-3');
    
        $block = R::dispense('youtube');
        $block->projectID = $project_id;
        $block->name = $name_YouTube_block;
        $block->link = $YouTube_block;
        $block->data = date("d.m.Y");
        $block->time = date("H:i:s");
        
        R::store($block);
        
        return R::count('youtube');
    }
?>