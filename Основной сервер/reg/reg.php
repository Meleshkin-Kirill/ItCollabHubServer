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
    
    function get_project_adds_users($ids){
        $vsp = explode(',', $ids);
        //$ids = array();
        $names = array();
        $photoLinks = array();
        
        foreach($vsp as &$value){
            $user = R::findOne('users', 'id = ?', array($value));
            
            //$ids = array_merge($ids, array($value));
            $names = array_merge($names, array($user->name));
            $photoLinks = array_merge($photoLinks, array($user->photoLocalLink));
        }
        
        $arr = array('names' => implode('🕰', $names), 'photoLocalLinks' => implode('🕰', $photoLinks));
        return json_encode($arr);
    }
    
    function set_project_is_end($project_id, $user_mail, $users_ins){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->is_end = 1;
            R::store($project);
            
            // Тут была скрыта тайна, как начисляются очки, но для не ленивых можно посмотреть тут: https://itcollabhub.xyz/f/f.png
            
            
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    function save_changes_from_project_with_image_and_opens($project_id, $user_mail, $project_name, $project_image, $project_is_open, $project_is_visible){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->name = $project_name;
            $project->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . $project_id . ".png";
            move_uploaded_file($project_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . $project_id . ".png");
            $project->is_open = $project_is_open;
            $project->is_visible = $project_is_visible;
            R::store($project);
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    function save_changes_from_project_without_image_and_opens($project_id, $user_mail, $project_name, $project_is_open, $project_is_visible){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->name = $project_name;
            //$project->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . $project_id . ".png";
            //move_uploaded_file($project_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . $project_id . ".png");
            $project->is_open = $project_is_open;
            $project->is_visible = $project_is_visible;
            R::store($project);
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    function save_changes_from_project_with_image_and_links($project_id, $user_mail, $project_name, $project_image, $project_tg, $project_vk, $project_web){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->name = $project_name;
            $project->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . $project_id . ".png";
            move_uploaded_file($project_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . $project_id . ".png");
            $project->tg = $project_tg;
            $project->vk = $project_vk;
            $project->webs = $project_web;
            R::store($project);
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    function save_changes_from_project_without_image_and_links($project_id, $user_mail, $project_name, $project_tg, $project_vk, $project_web){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->name = $project_name;
            //$project->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . $project_id . ".png";
            //move_uploaded_file($project_name, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . $project_id . ".png");
            $project->tg = $project_tg;
            $project->vk = $project_vk;
            $project->webs = $project_web;
            R::store($project);
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    function save_changes_from_project_with_image_and_description($project_id, $user_mail, $project_name, $project_image, $project_description){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->name = $project_name;
            $project->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . $project_id . ".png";
            move_uploaded_file($project_image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . $project_id . ".png");
            $project->description = $project_description;
            R::store($project);
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    function save_changes_from_project_without_image_and_description($project_id, $user_mail, $project_name, $project_description){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->name = $project_name;
            //$project->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . $project_id . ".png";
            //move_uploaded_file($project_name, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . $project_id . ".png");
            $project->description = $project_description;
            R::store($project);
            return "Всё ок";
        }
        
        return "Ошибка";
    }
    
    
    //////////////////////////////////////
    
    
    
    
    
    function get_peoples_from_project($project_id, $user_mail){
        if(strcmp(get_project_is_lider($project_id, $user_mail), "1") == 0){
            $ids = array();
            $names = array();
            $photos = array();
            
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $peopl = explode(',', $project->peoples);
            
            foreach($peopl as &$value){
                $p = R::findOne('users', 'id = ?', array($value));
                
                $ids = array_merge($ids, array($value));
                $names = array_merge($names, array($p->name));
                $photos = array_merge($photos, array($p->photoLocalLink));
            }
            
            $arr = array('ids' => str_replace(',', '🕰', implode(',', $ids)), 'names' => str_replace(',', '🕰', implode(',', $names)), 'photos' => str_replace(',', '🕰', implode(',', $photos)));
            return json_encode($arr);
            
            //return $project->peoples;
        }
        $arr = array('ids' => "Ошибка", 'names' => "Ошибка", 'photos' => "Ошибка");
        return json_encode($arr);
    }
    
    
    
    
    
    // Блок регистрации
    function reg_new_user($name, $password, $mail){
        date_default_timezone_set('UTC-3');
        
        $user = R::dispense('users');
        $repeatChecker = R::findOne('users', 'mail = ?', array($mail));
        
        if(isset($repeatChecker)){
            return "Такая почта уже используется";
        }
        
        $user->name = "";
        $user->mail = $mail;
        $user->password = $password;
        $user->role = "Tester";
        $user->data = date("m.d.y");
        $user->time = date("H:i:s");
        $user->topScore = 0.0;
        $user->topStatus = "Новый пользователь";
        $user->activityProjects = "Нет проектов";
        $user->friends = "Нет друзей";
        $user->friendsR = "Нет запросов";
        $user->telegramLink = "https://";
        $user->vkLink = "https://";
        $user->websiteLink = "https://";
        $tmp = "/home/a0773839/domains/development-team.ru/user_images/1.png";
        $user->photoLocalLink = $tmp;
        $user->photoName = "";
        
        $user->rProjects = "Нет запросов";
        
        R::store($user);
        
        $us = R::findOne('temporaryusers', 'mail = ?', array($mail));
        $us_id = $us->id;
        R::hunt('temporaryusers', 'id = ?', [$us_id]);
        
        
        $user = R::findOne('users', 'mail = ?', array($mail));
        if($user != "") return "Успешная регистрация";
        
        return "Ошибка регистрации";
    }
    function post_to_new_user_code($mail){
        $user = R::findOne('users', 'mail = ?', array($mail));
        if($user != "") return "Пользователь с такой почтой уже существует";
        
        $user = R::dispense('temporaryusers');
        
        $codes = rand(100000, 999999);
        $user->mail = $mail;
        $user->code = $codes;
        $user->data = date("m.d.y");
        $user->time = date("H:i:s");
        R::store($user);
        
        send_mail_to_user($mail, "Подтверждение почты. ITCollabHub", "Ваш код для подтверждения: " . $codes);
        
        $user = R::findOne('temporaryusers', 'mail = ?', array($mail));
        if($user != "") return "Код отправлен";
        
        return "Код не отправлен. Ошибка";
    }
    function checker_code($mail, $code){
        $user = R::findOne('temporaryusers', 'mail = ?', array($mail));
        
        if($user->code == $code){
            return "Проверка почты прошла успешно";
        }
        
        return "Неверный код";
    }
    function create_name($name, $image, $mail){
        $user = R::findOne('users', 'mail = ?', array($mail));
        
        $user->name = $name;
        $tmp = "https://serveritcollabhub.development-team.ru/images/" . $user->id . ".png";
        move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/images/" . $user->id . ".png");
        $user->photoLocalLink = $tmp;
        $user->photoName = strval($user->id);
        
        R::store($user);
        
        if($user->name != "") {
            return "Сохранено";
        }
        
        return "Ошибка";
        
    }
    
    
    
    // Блок входа
    function user_log_in_mail($mail){
        $user = R::findOne('users', 'mail = ?', array($mail));
        if($user == "") return "Пользователя с такой почтой не существует";
        
        $user = R::dispense('temporary2users');
        
        $codes = rand(100000, 999999);
        $user->mail = $mail;
        $user->code = $codes;
        $user->data = date("m.d.y");
        $user->time = date("H:i:s");
        R::store($user);
        
        send_mail_to_user($mail, "Восстановление пароля. ITCollabHub", "Ваш код для продолжения: " . $codes);
        
        $user = R::findOne('temporary2users', 'mail = ?', array($mail));
        if($user != "") return "Код отправлен";
        
        return "Код не отправлен. Ошибка";
    }
    function user_log_in_mail2($mail, $code){
        $user = R::findOne('temporary2users', 'mail = ?', array($mail));
        
        if($user->code == $code){
            $user1 = R::findOne('users', 'mail = ?', array($mail));
            
            $us = R::findOne('temporary2users', 'mail = ?', array($mail));
            $us_id = $us->id;
            R::hunt('temporary2users', 'id = ?', [$us_id]);
            
            send_mail_to_user($mail, "Восстановление пароля. ITCollabHub", "Ваш пароль: " . $user1->password);
            return "Проверка почты прошла успешно";
        }
        
        return "Неверный код";
    }
    function user_log_in($mail, $pass){
        $user = R::findOne('users', 'mail = ?', array($mail));
        if($user == ""){
            $arr = array('ret' => "Пользователя с такой почтой не существует");
            return json_encode($arr);
        }
        
        if($user->password == $pass){
            $arr = array('ret' => "Успешный вход", 'name' => $user->name);
            return json_encode($arr);
        }
        else{
            $arr = array('ret' => 'Неверный пароль');
            return json_encode($arr);
        }
    }
    
    // Блок профиля пользователя
    
    
    
    
    
    function get_user_id($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        return $user->id;
    }
    
    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    // ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ
    
    
    
    
    function proverka($user_mail){
        $user_user_user = R::findOne('users', 'mail = ?', array($user_mail));
         return $user_user_user->friendsR;
    }
    
    
    
    function get_users_to_project($user_name, $user_mail){

        $friends_id = R::getAll("SELECT * FROM users");
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        $scores = array();
        $projects1 = array();
        $pr = array();
        
        $user_user_user = R::findOne('users', 'mail = ?', array($user_mail));
        $array_user_user1 = explode(",", $user_user_user->friends);
        
        foreach ($friends_id as &$value){
            //$friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            if (strpos($value["name"], $user_name) !== false && $user_mail != $value["mail"] && array_search($value["id"], $array_user_user1) !== false) {
                $ids = array_merge($ids, array($value["id"]));
                $names = array_merge($names, array($value["name"]));
                $photoLinks = array_merge($photoLinks, array($value["photo_local_link"]));
                $scores = array_merge($scores, array($value["top_score"]));
                //$projects1 = array_merge($projects1, explode(",", $friend->photoLocalLink));
                
                $pr = array_merge($pr, array("ITCollabHub"));
            }
        }
        
        if(empty($ids)){ 
            return array(1 => "Нет1друзей564", 2 => "Нет1друзей564", 3 => "Нет1друзей564", 4 => "Нет1друзей564", 5 => "Нет1друзей564");
        }
        
        return array(1 => implode(",", $names), 2 => implode(",", $photoLinks), 3 => implode(",", $ids), 4 => implode(",", $scores), 5 => implode(",", $pr));
    }
    
    function get_Ivan($ivan){
        $friends_id = R::findAll('users', 'name = ?', array($ivan));
        return $friends_id[1]->id;
    }
    
    
    
    
    
    
    
    function get_tbl(){
        $a = R::getAll("SELECT * FROM users");
        return $a;
    }
    
    function gr_projects($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        if(strcmp($user->rProjects, "Нет запросов") == 0){
            return "0";
        }
        
        return "1";
    }
    
    // Блок проектов
    
    function add_user_to_project($user_mail, $project_id){
        $arr = explode(',' ,R::findOne('users', 'mail = ?', array($user_mail))->rProjects);
        for($i = 0; $i < count($arr); $i++){
            if($arr[$i] == $project_id){
                unset($arr[$i]);
                break;
            }
        }
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        
        $project = R::findOne('projects', 'id = ?', array($project_id));
        $project->peoples = $project->peoples . ',' . $user->id;
        R::store($project);
        
        if(empty($arr)){
            $user->rProjects = "Нет запросов";
        }
        else{
            $user->rProjects = implode(',', $arr);
        }
        R::store($user);
        
        return "Okey";
    }
    
    function not_add_user_to_project($user_mail, $project_id){
        $arr = explode(',' ,R::findOne('users', 'mail = ?', array($user_mail))->rProjects);
        for($i = 0; $i < count($arr); $i++){
            if($arr[$i] == $project_id){
                unset($arr[$i]);
                break;
            }
        }
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        if(empty($arr)){
            $user->rProjects = "Нет запросов";
        }
        else{
            $user->rProjects = implode(',', $arr);
        }
        R::store($user);
        
        return "Okey";
    }
    
    
    function send_r_to_people($id, $projects_id){
        $ids = explode(",", $id);
        $ids = array_unique($ids);
        foreach ($ids as $v){
            $user = R::findOne('users', 'id = ?', array($v));
            if(strcmp($user->rProjects, "Нет запросов") == 0){
                $user->rProjects = $projects_id;
            }
            else{
                $user->rProjects = $user->rProjects . "," . $projects_id;
            }
            R::store($user);
        }
    }
    
    function reg_new_project($pr_name, $pr_description, $peoples, $ids, $purposes, $tasks, $image){

        date_default_timezone_set('UTC-3');

        
        $project = R::dispense('projects');
        
        $project->name = $pr_name;
        
        if(empty($pr_description)) $project->description = "Описание отсутствует";
        else $project->description = $pr_description;
        
        $people1 = R::findOne('users', 'mail = ?', array($peoples));
        
        $ppss = explode('🕰', $purposes);
        $p = array();
        for($i = 0; $i < count($ppss); $i+=2){
            $count_users = R::count( 'purposes' );
            $p = array_merge($p, array(($count_users + 1)));
            $purposes_table = R::dispense('purposes');
            $purposes_table->name = $ppss[$i];
            $purposes_table->description = $ppss[$i + 1];
            $purposes_table->isEnd = 0;
            $purposes_table->photoLocalLink = "";
            R::store($purposes_table);
        }
        
        $pbpbss = explode('🕰', $tasks);
        $pb = array();
        for($i = 0; $i < count($pbpbss); $i+=2){
            $count_users = R::count( 'problems' );
            $pb = array_merge($pb, array(($count_users + 1)));
            $problems_table = R::dispense('problems');
            $problems_table->name = $pbpbss[$i];
            $problems_table->description = $pbpbss[$i + 1];
            $problems_table->isEnd = 0;
            $problems_table->isLife = 1;
            $problems_table->photoLocalLink = "";
            R::store($problems_table);
        }
        
        $project->purposes = implode(',', $p);
        $project->problems = implode(',', $pb);
        $project->deadlines = "Нет";
        $project->tasks = "Нет";
        $project->peoples = $people1->id;
        $project->data = date("d.m.y");
        $project->time = date("H:i:s");
        $project->tg = "Нет";
        $project->vk = "Нет";
        $project->webs = "Нет";
        
        
        $tmp = "";
        $project->photoLocalLink = $tmp;
        $project->photoName = "";
        $project->isOpen = 0;
        $project->isEnd = 0;
        $project->isVisible = 0;
        $project->files = "Нет файлов";
        $project->ads = "Нет объявлений";
        
        R::store($project);
        
        $urlToImg = "";
        $pr = R::findLast('projects', 'name = ?', array($pr_name));
        $iddd = $pr->id;
        if(strcmp($image, "") == 0){
            $urlToImg = "https://serveritcollabhub.development-team.ru/project_image/" . "moaiitcollabhub" . ".png";
            $pr->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . "moaiitcollabhub" . ".png";
        }
        else{
            $urlToImg = "https://serveritcollabhub.development-team.ru/project_image/" . strval($iddd) . ".png";
            $pr->photoLocalLink = "https://serveritcollabhub.development-team.ru/project_image/" . strval($iddd) . ".png";
            move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/project_image/" . strval($iddd) . ".png");
        }
        $pr->photoName = strval($iddd);
        R::store($pr);
        
        foreach ($p as &$value){
            $vsp4 = R::findLast('purposes', 'id = ?', array($value));
            $vsp4->photoLocalLink = $urlToImg;
            R::store($vsp4);
        }
        foreach ($pb as &$value){
            $vsp4 = R::findLast('problems', 'id = ?', array($value));
            $vsp4->photoLocalLink = $urlToImg;
            R::store($vsp4);
        }
        
        if(strcmp($ids, "Пользователи были не выбраны") == 0){
            return "Успешно";
        }
        
        send_r_to_people($ids, $iddd);
        return "Успешно";
    }
    
    function get_user_projects5($user_mail){
        $project_id = R::getAll("SELECT * FROM projects");
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        $descriptions = array();
        $ends = array();
        
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        $user_id = $user->id;
        $user_name = array();
        $user_img = array();
        $user_score = array();
        
        foreach ($project_id as &$value){
            //$friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            if (strpos($value["peoples"], $user_id) !== false && $value["is_end"] != 1) {
                $ids = array_merge($ids, array($value["id"]));
                $names = array_merge($names, array($value["name"]));
                $photoLinks = array_merge($photoLinks, array($value["photo_local_link"]));
                $descriptions = array_merge($descriptions, array($value["description"]));
                $ends = array_merge($ends, array(get_project_is_end($value["id"])));
                
                $vsp4 = explode(',', $value["peoples"])[0];
                $us = R::findOne('users', 'id = ?', array($vsp4));
                $user_name = array_merge($user_name, array($us->name));
                $user_score = array_merge($user_score, array($us->topScore));
                $user_img = array_merge($user_img, array($us->photoLocalLink));
                //$projects1 = array_merge($projects1, explode(",", $friend->photoLocalLink));
                
                //$pr = array_merge($pr, array("ITCollabHub"));
            }
        }
        
        if(empty($ids)){ 
            return array(1 => "Нет1проектов564", 2 => "Нет1проектов564", 3 => "Нет1проектов564", 4 => "Нет1проектов564", 5 => "Нет1проектов564", 6 => "Нет1проектов564", 7 => "Нет1проектов564", 8 => "Нет1проектов564");
        }
        
        return array(1 => implode(",", $names), 2 => implode(",", $photoLinks), 3 => implode(",", $ids), 4 => implode(",", $descriptions), 5 => implode(",", $user_name), 6 => implode(",", $user_img), 7 => implode(",", $user_score), 8 => implode(",", $ends));
    }
    
    function get_user_projects50($user_mail){
        $project_id = R::getAll("SELECT * FROM projects");
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        $descriptions = array();
        $ends = array();
        
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        $user_id = $user->id;
        $user_name = array();
        $user_img = array();
        $user_score = array();
        
        foreach ($project_id as &$value){
            //$friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            if (strpos($value["peoples"], $user_id) !== false && $value["is_end"] == 1) {
                $ids = array_merge($ids, array($value["id"]));
                $names = array_merge($names, array($value["name"]));
                $photoLinks = array_merge($photoLinks, array($value["photo_local_link"]));
                $descriptions = array_merge($descriptions, array($value["description"]));
                $ends = array_merge($ends, array(get_project_is_end($value["id"])));
                
                $vsp4 = explode(',', $value["peoples"])[0];
                $us = R::findOne('users', 'id = ?', array($vsp4));
                $user_name = array_merge($user_name, array($us->name));
                $user_score = array_merge($user_score, array($us->topScore));
                $user_img = array_merge($user_img, array($us->photoLocalLink));
                //$projects1 = array_merge($projects1, explode(",", $friend->photoLocalLink));
                
                //$pr = array_merge($pr, array("ITCollabHub"));
            }
        }
        
        if(empty($ids)){ 
            return array(1 => "Нет1проектов564", 2 => "Нет1проектов564", 3 => "Нет1проектов564", 4 => "Нет1проектов564", 5 => "Нет1проектов564", 6 => "Нет1проектов564", 7 => "Нет1проектов564", 8 => "Нет1проектов564");
        }
        
        return array(1 => implode(",", $names), 2 => implode(",", $photoLinks), 3 => implode(",", $ids), 4 => implode(",", $descriptions), 5 => implode(",", $user_name), 6 => implode(",", $user_img), 7 => implode(",", $user_score), 8 => implode(",", $ends));
    }
    
    function get_user_r_projects5($user_mail){
        $rproject = explode(",", R::findOne('users', 'mail = ?', array($user_mail))->rProjects);
        
        if(strcmp($rproject[0], "Нет запросов") == 0){ 
            return array(1 => "Нет1проектов564", 2 => "Нет1проектов564", 3 => "Нет1проектов564");
        }
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        
        foreach ($rproject as &$value){
            $project = R::findOne('projects', 'id = ?', array($value));
            $ids = array_merge($ids, array($value));
            $names = array_merge($names, array($project->name));
            $photoLinks = array_merge($photoLinks, array($project->photoLocalLink));
        }
        
        
        
        return array(1 => implode(",", $names), 2 => implode(",", $photoLinks), 3 => implode(",", $ids));
    }
    
    function get_project_name($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        return $project->name;
    }
    function get_project_description($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        return $project->description;
    }
    function get_project_urlImg($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        return $project->photo_local_link;
    }
    
    function get_project_is_end($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $purposes = explode(',', $project->purposes);
        $n = count($purposes) * 20;
        $keys = 0;
        for($i = 0; $i < count($purposes); $i++){
            $pp = R::findOne('purposes', 'id = ?', array($purposes[$i]));
            $keys = $keys + (20 * (int)($pp->isEnd));
        }
        
        $problems = explode(',', $project->problems);
        $n = $n + count($problems) * 5;
        for($i = 0; $i < count($problems); $i++){
            $pp = R::findOne('problems', 'id = ?', array($problems[$i]));
            if((int)$pp->isLife == 1){
                $keys = $keys + (5 * (int)($pp->isEnd));
            }
            else{
                $n -= 1;
            }
        }
        
        return (int)($keys / $n * 100);
    }
    
    function get_project_purposes($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $purposes = explode(',', $project->purposes);
        $n = count($purposes);
        $keys = 0;
        for($i = 0; $i < count($purposes); $i++){
            $pp = R::findOne('purposes', 'id = ?', array($purposes[$i]));
            $keys = $keys + (int)$pp->isEnd;
        }
        
        return $keys . "/" . $n;
    }
    
    function get_purposes($id){
        $ids = explode(',', $id);
        $text = "";
        foreach ($ids as &$value){
            $purpose = R::findOne('purposes', 'id = ?', array($value));
            $text = $text . $purpose->name . '🕰' . $purpose->description . '🕰' . $purpose->isEnd . '🕰' . $purpose->photoLocalLink . '🕰';
        }
        $text = substr($text, 0, strlen($text) - 4);
        return $text;
    }
    
    function get_project_problems($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $problems = explode(',', $project->problems);
        $n = count($problems);
        $keys = 0;
        for($i = 0; $i < count($problems); $i++){
            $pp = R::findOne('problems', 'id = ?', array($problems[$i]));
            if((int)$pp->isLife == 1){
                $keys = $keys + (int)($pp->isEnd);
            }
            else{
                $n -= 1;
            }
        }
        
        return $keys . "/" . $n;
    }
    
    function get_project_tasks($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $tasks = explode(',', $project->tasks);
        $n = count($tasks);
        $keys = 0;
        for($i = 0; $i < count($tasks); $i++){
            $pp = R::findOne('tasks', 'id = ?', array($tasks[$i]));
            if((int)$pp->isLife == 1){
                $keys = $keys + (int)($pp->isComplete);
            }
            else{
                $n -= 1;
            }
        }
        
        return $keys . "/" . $n;
    }
    
    function get_problems($id){
        $ids = explode(',', $id);
        $text = "";
        foreach ($ids as &$value){
            $problem = R::findOne('problems', 'id = ?', array($value));
            $text = $text . $problem->name . '🕰' . $problem->description . '🕰' . $problem->isEnd . '🕰' . $problem->photoLocalLink . '🕰';
        }
        $text = substr($text, 0, strlen($text) - 4);
        return $text;
    }
    
    function get_project_peoples($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $peoples = explode(',', $project->peoples);
        $n = count($peoples);
        
        return $n;
    }
    
    function get_project_time($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $text = $project->data . " " . $project->time;
        
        return $text;
    }
    
    function get_project_time1($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $text = $project->data . " " . $project->time;
        $text = substr_replace($text, '.20', 5, 1);
        $date = $text;
        $diff = time() - strtotime($date);
        $days = intval($diff / 86400);
        $hours = intval($diff / 3600) - ($days * 24);
        
        $txt1 = " ";
        if(11 <= $days && $days <= 19){
            $txt1 = $days . " дней";
        }
        else if($days % 10 == 1){
            $txt1 = $days . " день";
        }
        else if($days % 10 >= 5 || $days % 10 == 0){
            $txt1 = $days . " дней";
        }
        else{
            $txt1 = $days . " дня";
        }
        
        $txt2 = " ";
        if(11 <= $hours && $hours <= 19){
            $txt2 = $hours . " часов";
        }
        else if($hours % 10 == 1){
            $txt2 = $hours . " час";
        }
        else if($hours % 10 >= 5 || $hours % 10 == 0){
            $txt2 = $hours . " часов";
        }
        else{
            $txt2 = $hours . " часа";
        }
        
        return $txt1 . " " . $txt2;
    }
    
    function get_project_tg($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $text = $project->tg;
        
        return $text;
    }
    
    function get_project_vk($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $text = $project->vk;
        
        return $text;
    }
    
    function get_project_webs($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $text = $project->webs;
        
        return $text;
    }
    
    function get_project_purposes_ids($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $ids = $project->purposes;
        
        return $ids;
    }
    
    
    
    function get_project_problems_ids($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        $ids = $project->problems;
        $ids = explode(',', $ids);
        
        $res = array();
        
        foreach ($ids as &$id){
            $problem = R::findOne('problems', 'id = ?', array($id));
            if((int)$problem->isLife == 1){
                $res = array_merge($res, array($id));
            }
        }
        
        $res = implode(',', $res);
        return $res;
    }
    
    function get_project_is_open($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        return $project->is_open;
    }
    
    function get_project_is_visible($pr_id){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        
        return $project->is_visible;
    }
    
    function get_project_is_lider($pr_id, $user_mail){
        $project = R::findOne('projects', 'id = ?', array($pr_id));
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $is = $project->peoples;
        $is1 = explode(',', $is);
        
        if($is1[0] == $user->id) return "1";
        
        return "0";
    }
    
    function set_purpose_complete($purpose_id, $user_mail, $pr_id){
        if(strcmp(get_project_is_lider($pr_id, $user_mail), "1") == 0){
            $purpose = R::findOne('purposes', 'id = ?', array($purpose_id));
            $purpose->isEnd = 1;
            R::store($purpose);
        }
    }
    
    function set_problem_complete($problem_id, $user_mail, $pr_id){
        if(strcmp(get_project_is_lider($pr_id, $user_mail), "1") == 0){
            $problem = R::findOne('problems', 'id = ?', array($problem_id));
            $problem->isEnd = 1;
            R::store($problem);
        }
    }
    
    function create_purpose1($purpose_name, $project_id, $purpose_description, $image, $mail){
        $a = get_project_is_lider($project_id, $mail);
        if((int)$a == 1){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->purposes = $project->purposes . "," . (R::count('purposes') + 1);
            R::store($project);
            
            $purpose = R::dispense('purposes');
            $purpose->name = $purpose_name;
            $purpose->description = $purpose_description;
            $purpose->isEnd = "0";
            $purpose->photoLocalLink = "https://serveritcollabhub.development-team.ru/purposes_image/" . strval(R::count('purposes') + 1) . ".png";
            move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/purposes_image/" . strval(R::count('purposes') + 1) . ".png");
            R::store($purpose);
        }
        
        return "Okey";
        
    }
    function create_purpose_without_image($purpose_name, $project_id, $purpose_description, $mail){
        $a = get_project_is_lider($project_id, $mail);
        if((int)$a == 1){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->purposes = $project->purposes . "," . (R::count('purposes') + 1);
            R::store($project);
            
            $project1 = R::findOne('projects', 'id = ?', array($project_id));
            
            $purpose = R::dispense('purposes');
            $purpose->name = $purpose_name;
            $purpose->description = $purpose_description;
            $purpose->isEnd = "0";
            $purpose->photoLocalLink = $project1->photoLocalLink;
            R::store($purpose);
        }
        
        return $a;
    }
    
    function create_problem1($problem_name, $project_id, $problem_description, $image, $mail){
        $a = get_project_is_lider($project_id, $mail);
        if((int)$a == 1){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->problems = $project->problems . "," . (R::count('problems') + 1);
            R::store($project);
            
            $problem = R::dispense('problems');
            $problem->name = $problem_name;
            $problem->description = $problem_description;
            $problem->isEnd = "0";
            $problem->isLife = "1";
            $problem->photoLocalLink = "https://serveritcollabhub.development-team.ru/problems_image/" . strval(R::count('problems') + 1) . ".png";
            move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/problems_image/" . strval(R::count('problems') + 1) . ".png");
            R::store($problem);
        }
        
        return "Okey";
        
    }
    
    function change_problem1($problem_name, $project_id, $problem_description, $image, $mail, $pr_id){
        $a = get_project_is_lider($project_id, $mail);
        if((int)$a == 1){
            
            $problem = R::findOne('problems', 'id = ?', array($pr_id));
            $problem->name = $problem_name;
            $problem->description = $problem_description;
            $problem->photoLocalLink = "https://serveritcollabhub.development-team.ru/problems_image/" . $pr_id . ".png";
            move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/problems_image/" . $pr_id . ".png");
            R::store($problem);
        }
        
        return "Okey";
        
    }
    
    function create_problem_without_image($problem_name, $project_id, $problem_description, $mail){
        $a = get_project_is_lider($project_id, $mail);
        if((int)$a == 1){
            $project = R::findOne('projects', 'id = ?', array($project_id));
            $project->problems = $project->problems . "," . (R::count('problems') + 1);
            R::store($project);
            
            $project1 = R::findOne('projects', 'id = ?', array($project_id));
            
            $problem = R::dispense('problems');
            $problem->name = $problem_name;
            $problem->description = $problem_description;
            $problem->isEnd = "0";
            $problem->isLife = "1";
            $problem->photoLocalLink = $project1->photoLocalLink;
            R::store($problem);
        }
        
        return "Okey";
    }
    
    function change_problem_without_image($problem_name, $project_id, $problem_description, $mail, $pr_id){
        $a = get_project_is_lider($project_id, $mail);
        if((int)$a == 1){
            $problem = R::findOne('problems', 'id = ?', array($pr_id));
            $problem->name = $problem_name;
            $problem->description = $problem_description;
            R::store($problem);
        }
        
        return "Okey";
        
    }
    
    function set_problem_delete($problem_id, $user_mail, $pr_id){
        if(strcmp(get_project_is_lider($pr_id, $user_mail), "1") == 0){
            $problem = R::findOne('problems', 'id = ?', array($problem_id));
            $problem->isLife = 0;
            R::store($problem);
        }
    }
    
?>