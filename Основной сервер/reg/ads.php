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
    
    function get_project_is_lider_function_for_ads($pr_id, $user_mail){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $is = $project->peoples;
        $is1 = explode(',', $is);
        
        if($is1[0] == $user->id) return "1";
        
        return "0";
    }
    
    function create_ad_without_image($ad_name, $project_id, $user_mail, $advertisement){
        $a = get_project_is_lider_function_for_ads($project_id, $user_mail);
        if((int)$a == 1){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            if($project->ads == "Нет объявлений"){
                $project->ads = (R::count('ads') + 1);
            }
            else{
                $project->ads = $project->ads . "," . (R::count('ads') + 1);
            }
            R::store($project);
            
            $project1 = R::findOne('projects', 'id = ?', array($project_id));
            
            $ad = R::dispense('ads');
            $ad->name = $ad_name;
            $ad->isLife = "1";
            $ad->isFix = "1";
            $ad->photoLocalLink = $project1->photoLocalLink;
            $ad->advertisement = $advertisement;
            $ad->time = date("d.m.y");
            R::store($ad);
        }
        
        return "Okey";
    }
    
    function create_ad1($ad_name, $project_id, $file_image, $user_mail, $advertisement){
        $a = get_project_is_lider_function_for_ads($project_id, $user_mail);
        if((int)$a == 1){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            if($project->ads == "Нет объявлений"){
                $project->ads = (R::count('ads') + 1);
            }
            else{
                $project->ads = $project->ads . "," . (R::count('ads') + 1);
            }
            R::store($project);
            
            $ad = R::dispense('ads');
            $ad->name = $ad_name;
            $ad->isLife = "1";
            $ad->isFix = "1";
            $ad->photoLocalLink = "https://serveritcollabhub.development-team.ru/ads_image/" . strval(R::count('ads') + 1) . ".png";
            move_uploaded_file($file_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/ads_image/" . strval(R::count('ads') + 1) . ".png");
            $ad->advertisement = $advertisement;
            $ad->time = date("d.m.y");
            R::store($ad);
        }
        
        return "Okey";
    }
    
    function get_ads($id){
        $ids = explode(',', $id);
        $text = "";
        foreach ($ids as &$value){
            $file = R::findOne('ads', 'id = ?', array($value));
            $text = $text . $file->name . '🕰' . $file->advertisement . '🕰' . $file->photoLocalLink . '🕰';
        }
        $text = substr($text, 0, strlen($text) - 4);
        return $text;
    }
    
    function delete_ad1($project_id, $user_mail, $ad_id){
        $a = get_project_is_lider_function_for_ads($project_id, $user_mail);
        if((int)$a == 1){
            
            $ad = R::findOne('ads', 'id = ?', array($ad_id));
            $ad->isLife = 0;
            R::store($ad);
        }
        
        return "Okey";
    }
    
    function get_project_ads_ids1($add_id){
        $file = R::findOne('projects', 'id = ?', array($add_id));
        
        $ids = $file->ads;
        $ids = explode(',', $ids);
        
        $res = array();
        
        foreach ($ids as &$id){
            $file_file = R::findOne('ads', 'id = ?', array($id));
            if((int)$file_file->isLife == 1 && (int)$file_file->isFix == 1){
                $res = array_merge($res, array($id));
            }
        }
        
        $res = implode(',', $res);
        return $res;
    }
    
    function get_project_ads_ids2($add_id){
        $file = R::findOne('projects', 'id = ?', array($add_id));
        
        $ids = $file->ads;
        $ids = explode(',', $ids);
        
        $res = array();
        
        foreach ($ids as &$id){
            $file_file = R::findOne('ads', 'id = ?', array($id));
            if((int)$file_file->isLife == 1 && (int)$file_file->isFix == 0){
                $res = array_merge($res, array($id));
            }
        }
        
        $res = implode(',', $res);
        return $res;
    }
    
    function change_ad_without_image($ad_name, $project_id, $user_mail, $advertisement, $ad_id){
        $a = get_project_is_lider_function_for_ads($project_id, $user_mail);
        if((int)$a == 1){
            
            $ad = R::findOne('ads', 'id = ?', array($ad_id));
            $ad->name = $ad_name;
            $ad->advertisement = $advertisement;
            R::store($ad);
        }
        
        return "Okey";
        
    }

    function change_ad1($ad_name, $project_id, $file_image, $user_mail, $advertisement, $ad_id){
        $a = get_project_is_lider_function_for_ads($project_id, $user_mail);
        if((int)$a == 1){
            
            $ad = R::findOne('ads', 'id = ?', array($ad_id));
            $ad->name = $ad_name;
            $ad->photoLocalLink = "https://serveritcollabhub.development-team.ru/ads_image/" . $ad_id . ".png";
            move_uploaded_file($file_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/ads_image/" . $ad_id . ".png");
            $ad->advertisement = $advertisement;
            R::store($ad);
        }
        
        return "Okey";
        
    }    
    
?>