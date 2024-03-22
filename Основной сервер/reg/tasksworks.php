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
    
    function get_project_is_lider_function_for_tasksworks($pr_id, $user_mail){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $is = $project->peoples;
        $is1 = explode(',', $is);
        
        if($is1[0] == $user->id) return "1";
        
        return "0";
    }
    
    function create_work_to_task($project_id, $user_mail, $task_id, $text_blocks, $link_blocks, $image_blocks){
        //if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            date_default_timezone_set('UTC-3');
            
            $user = R::findOne('users', 'mail = ?', array($user_mail));
            
            $work = R::dispense('works');
            $work->projectID = $project_id;
            $work->taskID = $task_id;
            $work->userID = $user->id;
            $work->textBlocks = $text_blocks;
            $work->linkBlocks = $link_blocks;
            $work->imageBlocks = $image_blocks;
            $work->data = date("d.m.Y");
            $work->time = date("H:i:s");
            
            R::store($work);
            
            $task = R::findOne('tasks', 'id = ?', array($task_id));
            
            if(strcmp($task->completes, "Нет") == 0){
                $task->completes = R::count('works');
            }
            else{
                $task->completes = $task->completes . "," . R::count('works');
            }
            
            R::store($task);
            
            return "Всё ок";
        //}
        //return "Ошибка";
    }
    
    function get_works_from_task($project_id, $user_mail, $task_id){
        if(strcmp(get_project_is_lider_function_for_tasksworks($project_id, $user_mail), "1") == 0){
            $ids = array();
            $names = array();
            $photos = array();
            
            $task = R::findOne('tasks', 'id = ?', array($task_id));
            $tas = explode(',', $task->completes);
            
            if(strcmp($task->completes, "Нет") == 0){
                $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'photos' => "Ошибка");
                return json_encode($arr);
            }
            
            foreach($tas as &$value){
                $t = R::findOne('works', 'id = ?', array($value));
                
                $ids = array_merge($ids, array($value));
                
                $vsp2 = $t->userID;
                $user = R::findOne('users', 'id = ?', array($vsp2));
                
                $names = array_merge($names, array($user->name));
                $photos = array_merge($photos, array($user->photoLocalLink));
            }
            if(empty($ids)){
                $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'photos' => "Ошибка");
                return json_encode($arr);
            }
            
            $arr = array('ids' => str_replace(',', '🕰', implode(',', $ids)), 'names' => str_replace(',', '🕰', implode(',', $names)), 'photos' => str_replace(',', '🕰', implode(',', $photos)));
            return json_encode($arr);
        }
        $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'photos' => "Ошибка");
        return json_encode($arr);
    }
    
    function get_one_work($project_id, $user_mail, $work_id){
        if(strcmp(get_project_is_lider_function_for_tasksworks($project_id, $user_mail), "1") == 0){
            $work = R::findOne('works', 'id = ?', array($work_id));
            
            $text_blocks = $work->textBlocks;
            $link_blocks = $work->linkBlocks;
            $image_blocks = $work->imageBlocks;
            
            $vsp_arr_txt = explode(',', $text_blocks);
            $vsp_arr_link = explode(',', $link_blocks);
            $vsp_arr_image = explode(',', $image_blocks);
            
            $txt_array = array();
            $link_array1 = array();
            $link_array2 = array();
            $image_array1 = array();
            $image_array2 = array();
            
            foreach($vsp_arr_txt as &$value){
                $p = R::findOne('texts', 'id = ?', array($value));
                $txt_array = array_merge($txt_array, array($p->text));
            }
            foreach($vsp_arr_link as &$value){
                $p = R::findOne('links', 'id = ?', array($value));
                $link_array1 = array_merge($link_array1, array($p->name));
                $link_array2 = array_merge($link_array2, array($p->link));
            }
            foreach($vsp_arr_image as &$value){
                $p = R::findOne('images', 'id = ?', array($value));
                $image_array1 = array_merge($image_array1, array($p->name));
                $image_array2 = array_merge($image_array2, array($p->photoLocalLink));
            }
            
            $arr = array('text_blocks' => str_replace(',', '🕰', implode(',', $txt_array)), 'link_blocks_names' => str_replace(',', '🕰', implode(',', $link_array1)), 'link_blocks_links' => str_replace(',', '🕰', implode(',', $link_array2)), 'image_blocks_names' => str_replace(',', '🕰', implode(',', $image_array1)), 'image_blocks_links' => str_replace(',', '🕰', implode(',', $image_array2)));
            return json_encode($arr);
        }
        $arr = array('text_blocks' => "Ошибка", 'link_blocks_names' => "Ошибка", 'link_blocks_links' => "Ошибка", 'image_blocks_names' => "Ошибка", 'image_blocks_links' => "Ошибка");
        return json_encode($arr);
    }
?>