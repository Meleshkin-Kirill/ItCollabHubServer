<?php
    include_once __DIR__ . '/mail_library/mail1.php';
    include_once 'rb.php';
    
    if(!R::testConnection()){
        R::setup('ХОСТ БД', 'ЛОГИН ОТ БД', 'ПАРОЛЬ ОТ БД');
    }
    
    if(!R::testConnection()){
        echo "ОШИБКА ПОДКЛЮЧЕНИЯ";
        exit;
    }
    
    function get_project_is_lider_function_for_files($pr_id, $user_mail){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $is = $project->peoples;
        $is1 = explode(',', $is);
        
        if($is1[0] == $user->id) return "1";
        
        return "0";
    }
    
    function create_file_without_image($file_name, $project_id, $user_mail, $file_link){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1 || (int)$a == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            if($project->files == "Нет файлов"){
                $project->files = (R::count('files') + 1);
            }
            else{
                $project->files = $project->files . "," . (R::count('files') + 1);
            }
            R::store($project);
            
            $project1 = R::findOne('projects', 'id = ?', array($project_id));
            
            $file = R::dispense('files');
            $file->name = $file_name;
            $file->isLife = "1";
            $file->isFix = "0";
            $file->photoLocalLink = $project1->photoLocalLink;
            $file->fileLink = $file_link;
            R::store($file);
        }
        
        return "Okey";
    }
    
    function create_file1($file_name, $project_id, $file_image, $user_mail, $file_link){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1 || (int)$a == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            if($project->files == "Нет файлов"){
                $project->files = (R::count('files') + 1);
            }
            else{
                $project->files = $project->files . "," . (R::count('files') + 1);
            }
            R::store($project);
            
            $file = R::dispense('files');
            $file->name = $file_name;
            $file->isLife = "1";
            $file->isFix = "0";
            $file->photoLocalLink = "https://serveritcollabhub.development-team.ru/files_image/" . strval(R::count('files') + 1) . ".png";
            move_uploaded_file($file_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/files_image/" . strval(R::count('files') + 1) . ".png");
            $file->fileLink = $file_link;
            R::store($file);
        }
        
        return "Okey";
    }
    
    function get_files($id){
        $ids = explode(',', $id);
        $text = "";
        foreach ($ids as &$value){
            $file = R::findOne('files', 'id = ?', array($value));
            $text = $text . $file->name . '🕰' . $file->fileLink . '🕰' . $file->isFix . '🕰' . $file->photoLocalLink . '🕰';
        }
        $text = substr($text, 0, strlen($text) - 4);
        return $text;
    }
    
    function detached_file1($project_id, $user_mail, $file_id){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1 || (int)$a == 0){
            
            $file = R::findOne('files', 'id = ?', array($file_id));
            $file->isFix = 0;
            R::store($file);
        }
        
        return "Okey";
    }
    
    function fix_file1($project_id, $user_mail, $file_id){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1 || (int)$a == 0){
            
            $file = R::findOne('files', 'id = ?', array($file_id));
            $file->isFix = 1;
            R::store($file);
        }
        
        return "Okey";
    }
    
    function delete_file1($project_id, $user_mail, $file_id){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1){
            
            $file = R::findOne('files', 'id = ?', array($file_id));
            $file->isLife = 0;
            R::store($file);
        }
        
        return "Okey";
    }
    
    function get_project_files_ids($pr_id){
        $file = R::findOne('projects', 'id = ?', array($pr_id));
        
        $ids = $file->files;
        $ids = explode(',', $ids);
        
        $res = array();
        
        foreach ($ids as &$id){
            $file_file = R::findOne('files', 'id = ?', array($id));
            if((int)$file_file->isLife == 1){
                $res = array_merge($res, array($id));
            }
        }
        
        $res = implode(',', $res);
        return $res;
    }
    
    function change_file_without_image($file_name, $project_id, $user_mail, $file_link, $file_id){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1 || (int)$a == 0){
            
            $file = R::findOne('files', 'id = ?', array($file_id));
            $file->name = $file_name;
            $file->fileLink = $file_link;
            R::store($file);
        }
        
        return "Okey";
        
    }
    
    function change_file1($file_name, $project_id, $file_image, $user_mail, $file_link, $file_id){
        $a = get_project_is_lider_function_for_files($project_id, $user_mail);
        if((int)$a == 1 || (int)$a == 0){
            
            $file = R::findOne('files', 'id = ?', array($file_id));
            $file->name = $file_name;
            $file->photoLocalLink = "https://serveritcollabhub.development-team.ru/files_image/" . $file_id . ".png";
            move_uploaded_file($file_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/files_image/" . $file_id . ".png");
            $file->fileLink = $file_link;
            R::store($file);
        }
        
        return "Okey";
    }
?>