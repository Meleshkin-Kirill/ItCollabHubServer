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
    
    function get_worker_in_project_function_for_tasks($project_id, $user_mail){
        $project = R::findOne('projects', 'id = ?', array($project_id));
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $is = $project->peoples;
        $is1 = explode(',', $is);
        
        if(in_array($user->id, $is1)) return "1";
        
        return "0";
    }
    
    function get_worker_in_task($project_id, $user_mail, $task_id){
        if(strcmp(get_worker_in_project_function_for_tasks($project_id, $user_mail), "1") == 0){
            $task = R::findOne('tasks', 'id = ?', array($task_id));
            $user = R::findOne('users', 'mail = ?', array($user_mail));
            
            $is = $task->peoples;
            $is1 = explode(',', $is);
            
            if(in_array($user->id, $is1)) return "1";
            
            return "0";
        }
        
        return "0";
    }
    
    
    function get_project_is_lider_function_for_tasks($pr_id, $user_mail){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $is = $project->peoples;
        $is1 = explode(',', $is);
        
        if($is1[0] == $user->id) return "1";
        
        return "0";
    }
    
    function create_task($project_id, $user_mail, $task_name, $peoples_ids, $queue_blocks, $text_blocks, $link_blocks, $image_blocks, $youtube_blocks, $end_time){
        if(strcmp(get_project_is_lider_function_for_tasks($project_id, $user_mail), "1") == 0){
            date_default_timezone_set('UTC-3');
            
            $project = R::findOne('projects', 'id = ?', array($project_id));
            
            $task = R::dispense('tasks');
            $task->name = $task_name;
            $task->peoples = $peoples_ids;
            $task->queueBlocks = $queue_blocks;
            $task->textBlocks = $text_blocks;
            $task->linkBlocks = $link_blocks;
            $task->imageBlocks = $image_blocks;
            $task->youtubeBlocks = $youtube_blocks;
            $task->completes = "Нет";
            $task->isComplete = 0;
            $task->isLife = 1;
            $task->data = date("d.m.Y");
            $task->time = date("H:i:s");
            
            if(is_null($end_time)){
                $task->endTime = "Нет";
            }
            else{
                $task->endTime = $end_time;
            }
            
            R::store($task);
            
            if(strcmp($project->tasks, "Нет") == 0){
                $project->tasks = R::count('tasks');
            }
            else{
                $project->tasks = $project->tasks . "," . R::count('tasks');
            }
            
            R::store($project);
            
            return "Всё ок";
        }
        return "Ошибка";
    }
    
    function get_tasks_from_project($project_id, $user_mail){
        //if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0 || strcmp(get_worker_in_task($project_id, $user_mail), "1") == 0){
            $ids = array();
            $names = array();
            $texts = array();
            $completes = array();
            
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $tas = explode(',', $project->tasks);
            
            if(strcmp($project->tasks, "Нет") == 0){
                $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'texts' => "Ошибка");
                return json_encode($arr);
            }
            
            foreach($tas as &$value){
                $t = R::findOne('tasks', 'id = ?', array($value));
                if((strcmp(get_project_is_lider_function_for_tasks($project_id, $user_mail), "1") == 0 || strcmp(get_worker_in_task($project_id, $user_mail, $value), "1") == 0) && (int)$t->isLife == 1 && strcmp($t->endTime, "Нет") == 0){
                    
                    
                    $ids = array_merge($ids, array($value));
                    $names = array_merge($names, array($t->name));
                    
                    $txt = explode(',', $t->textBlocks);
                    if(strcmp($t->textBlocks, "") == 0){
                        $texts = array_merge($texts, array("Нет описания"));
                    }
                    else{
                        $txt1 = $txt[0];
                        $vsp1 = R::findOne('texts', 'id = ?', array($txt1));
                        $texts = array_merge($texts, array($vsp1->text));
                    }
                    
                    $completes = array_merge($completes, array((int)($t->isComplete)));
                }
            }
            if(empty($ids)){
                $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'texts' => "Ошибка");
                return json_encode($arr);
            }
            
            $arr = array('ids' => str_replace(',', '🕰', implode(',', $ids)), 'names' => str_replace(',', '🕰', implode(',', $names)), 'texts' => str_replace(',', '🕰', implode(',', $texts)), 'complete' => str_replace(',', '🕰', implode(',', $completes)));
            return json_encode($arr);
        //}
    }
    
    function get_deadlines_from_project($project_id, $user_mail){
        //if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0 || strcmp(get_worker_in_task($project_id, $user_mail), "1") == 0){
            $ids = array();
            $names = array();
            $texts = array();
            $completes = array();
            $endTimes = array();
            
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $tas = explode(',', $project->tasks);
            
            if(strcmp($project->tasks, "Нет") == 0){
                $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'texts' => "Ошибка");
                return json_encode($arr);
            }
            
            foreach($tas as &$value){
                $t = R::findOne('tasks', 'id = ?', array($value));
                if((strcmp(get_project_is_lider_function_for_tasks($project_id, $user_mail), "1") == 0 || strcmp(get_worker_in_task($project_id, $user_mail, $value), "1") == 0) && (int)$t->isLife == 1 && strcmp($t->endTime, "Нет") != 0){
                    
                    
                    $ids = array_merge($ids, array($value));
                    $names = array_merge($names, array($t->name));
                    
                    $txt = explode(',', $t->textBlocks);
                    if(strcmp($t->textBlocks, "") == 0){
                        $texts = array_merge($texts, array("Нет описания"));
                    }
                    else{
                        $txt1 = $txt[0];
                        $vsp1 = R::findOne('texts', 'id = ?', array($txt1));
                        $texts = array_merge($texts, array($vsp1->text));
                    }
                    
                    $completes = array_merge($completes, array((int)($t->isComplete)));
                    
                    $date2_00 = new DateTime(str_replace(".", "-", $t->endTime));
                    $date_00 = new DateTime(date("d-m-Y"));
                    $end_time = ($date2_00->getTimestamp() - $date_00->getTimestamp()) * 1000;
                    $endTimes = array_merge($endTimes, array($end_time));
                    
                }
            }
            if(empty($ids)){
                $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'texts' => "Ошибка", 'endTime' => "Ошибка");
                return json_encode($arr);
            }
            
            $arr = array('endTime' => str_replace(',', '🕰', implode(',', $endTimes)), 'ids' => str_replace(',', '🕰', implode(',', $ids)), 'names' => str_replace(',', '🕰', implode(',', $names)), 'texts' => str_replace(',', '🕰', implode(',', $texts)), 'complete' => str_replace(',', '🕰', implode(',', $completes)));
            return json_encode($arr);
        //}
    }
    
    function check_count_of_ready_works_from_task($project_id, $user_mail, $task_id){
        if(strcmp(get_project_is_lider_function_for_tasks($project_id, $user_mail), "1") == 0){
            $task = R::findOne('tasks', 'id = ?', array($task_id));
            
            if(strcmp($task->completes, "Нет") == 0){
                $arr = array('ret' => 0);
                return json_encode($arr);
            }
            
            $ar = explode(',', $task->completes);
            
            $arr = array('ret' => count($ar));
            return json_encode($arr);
        }
    }
    
    function get_more_information_from_task_from_project($project_id, $user_mail, $task_id){
        if(strcmp(get_project_is_lider_function_for_tasks($project_id, $user_mail), "1") == 0 || strcmp(get_worker_in_task($project_id, $user_mail, $task_id), "1") == 0){
            $task = R::findOne('tasks', 'id = ?', array($task_id));
            
            $queue = $task->queueBlocks;
            $text_blocks = $task->textBlocks;
            $link_blocks = $task->linkBlocks;
            $image_blocks = $task->imageBlocks;
            $youtube_blocks = $task->youtubeBlocks;
            
            $end_time = "LoL";
            
            if(strcmp($task->endTime, "Нет") == 0){
                $end_time = "LoL";
            }
            else{
                $date2_00 = new DateTime(str_replace(".", "-", $task->endTime));
                $date_00 = new DateTime(date("d-m-Y"));
                
                $end_time = ($date2_00->getTimestamp() - $date_00->getTimestamp()) * 1000;
            }
            
            $vsp_arr_txt = explode(',', $text_blocks);
            $vsp_arr_link = explode(',', $link_blocks);
            $vsp_arr_image = explode(',', $image_blocks);
            $vsp_arr_youtube = explode(',', $youtube_blocks);
            
            $txt_array = array();
            $link_array1 = array();
            $link_array2 = array();
            $image_array1 = array();
            $image_array2 = array();
            $youtube_array1 = array();
            $youtube_array2 = array();
            
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
            foreach($vsp_arr_youtube as &$value){
                $p = R::findOne('youtube', 'id = ?', array($value));
                $youtube_array1 = array_merge($youtube_array1, array($p->name));
                $youtube_array2 = array_merge($youtube_array2, array($p->link));
            }
            
            $arr = array('endTime' => strval($end_time), 'queue_blocks' => $queue, 'text_blocks' => str_replace(',', '🕰', implode(',', $txt_array)), 'link_blocks_names' => str_replace(',', '🕰', implode(',', $link_array1)), 'link_blocks_links' => str_replace(',', '🕰', implode(',', $link_array2)), 'image_blocks_names' => str_replace(',', '🕰', implode(',', $image_array1)), 'image_blocks_links' => str_replace(',', '🕰', implode(',', $image_array2)), 'youtube_blocks_names' => str_replace(',', '🕰', implode(',', $youtube_array1)), 'youtube_blocks_links' => str_replace(',', '🕰', implode(',', $youtube_array2)));
            return json_encode($arr);
        }
        $arr = array('endTime' => "Ошибка", 'queue_blocks' => "Ошибка", 'text_blocks' => "Ошибка", 'link_blocks_names' => "Ошибка", 'link_blocks_links' => "Ошибка", 'image_blocks_names' => "Ошибка", 'image_blocks_links' => "Ошибка", 'youtube_blocks_names' => "Ошибка", 'youtube_blocks_links' => "Ошибка");
        return json_encode($arr);
    }
    
    function set_task_is_end($project_id, $user_mail, $task_id){
        if(strcmp(get_project_is_lider_function_for_tasks($project_id, $user_mail), "1") == 0){
            $task = R::findOne('tasks', 'id = ?', array($task_id));
            
            $task->isComplete = 1;
            
            R::store($task);
            
            return "Okey";
        }
        return "BamBanBap!";
    }
?>