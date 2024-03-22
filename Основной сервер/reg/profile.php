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
    
    // GetUserInformation
    function get_user_name($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        return $user->name;
    }
    function get_user_urlImg($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        if($user->top_status == "Заблокирован") return "https://serveritcollabhub.development-team.ru/images/ban.png";
        
        return $user->photo_local_link;
    }
    function get_user_projects($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        return $user->activity_projects;
    }
    function get_user_top_score($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        if($user->top_status == "Заблокирован") return 0;
        
        return $user->top_score;
    }
    function get_user_top_status($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        return $user->top_status;
    }
    function get_user_fr_r($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($user == ""){
            return "Пользователя с такой почтой не существует";
        }
        
        if(strcmp($user->friendsR, "Нет запросов") == 0) return "0";
        
        return "1";
    }
    function get_user_activity_projects($user_mail){
        $project_id = R::getAll("SELECT * FROM projects");
        
        $ids = array();
        
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        $user_id = $user->id;
        
        foreach ($project_id as &$value){
            //$friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            if (strpos($value["peoples"], $user_id) !== false && (int)$value["isEnd"] == 0) {
                $ids = array_merge($ids, array($value["id"]));
            }
        }
        
        if(empty($ids)){ 
            return 0;
        }
        
        return count($ids);
    }
    function get_user_archive_projects($user_mail){
        $project_id = R::getAll("SELECT * FROM projects");
        
        $ids = array();
        
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        $user_id = $user->id;
        
        foreach ($project_id as &$value){
            //$friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            if (strpos($value["peoples"], $user_id) !== false && (int)$value["isEnd"] == 1) {
                $ids = array_merge($ids, array($value["id"]));
            }
        }
        
        if(empty($ids)){ 
            return 0;
        }
        
        return count($ids);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //GetUserFriends
    
    function get_friends($user_mail){
        $friends_id1 = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($friends_id1 == ""){
            return array(1 => "Нет1друзей564", 2 => "Нет1друзей564", 3 => "Нет1друзей564", 4 => "Нет1друзей564", 5 => "Нет1друзей564");
        }
        $friends_id2 = $friends_id1->friends;
        $projects = explode(",", $friends_id1->projects);
        
        if($friends_id2 == "Нет друзей") return array(1 => "Нет1друзей564", 2 => "Нет1друзей564", 3 => "Нет1друзей564", 4 => "Нет1друзей564", 5 => "Нет1друзей564");
        $friends_id = explode(",", $friends_id2);
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        $scores = array();
        $projects1 = array();
        $pr = array();
        
        for($i = 0; $i < count($friends_id); $i++){
            $friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            
            $ids = array_merge($ids, array($friend->id));
            $names = array_merge($names, array($friend->name));
            $photoLinks = array_merge($photoLinks, array($friend->photoLocalLink));
            $scores = array_merge($scores, array($friend->topScore));
            $projects1 = array_merge($projects1, explode(",", $friend->photoLocalLink));
            
            $pr = array_merge($pr, array("ITCollabHub"));
        }
        return array(1 => implode(",", $names), 2 => implode(",", $photoLinks), 3 => implode(",", $ids), 4 => implode(",", $scores), 5 => implode(",", $pr));
    }
    
    //GetUserFriendsR
    
    function get_friendsr($user_mail){
        $friends_id1 = R::findOne('users', 'mail = ?', array($user_mail));
        
        if($friends_id1 == ""){
            return array(1 => "Нет1друзей564", 2 => "Нет1друзей564", 3 => "Нет1друзей564", 4 => "Нет1друзей564", 5 => "Нет1друзей564");
        }
        $friends_id2 = $friends_id1->friendsR;
        
        if($friends_id2 == "Нет запросов") return array(1 => "Нет1друзей564", 2 => "Нет1друзей564", 3 => "Нет1друзей564", 4 => "Нет1друзей564", 5 => "Нет1друзей564");
        $friends_id = explode(",", $friends_id2);
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        $scores = array();
        $projects1 = array();
        $pr = array();
        
        for($i = 0; $i < count($friends_id); $i++){
            $friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            
            $ids = array_merge($ids, array($friend->id));
            $names = array_merge($names, array($friend->name));
            $photoLinks = array_merge($photoLinks, array($friend->photoLocalLink));
            $scores = array_merge($scores, array($friend->topScore));
            $projects1 = array_merge($projects1, explode(",", $friend->photoLocalLink));
            
            $pr = array_merge($pr, array("ITCollabHub"));
        }
        //return array(1 => "Нет1друзей564", 2 => "Нет1друзей564", 3 => "Нет1друзей564", 4 => "Нет1друзей564", 5 => "Нет1друзей564");
        return array(1 => implode(",", $names), 2 => implode(",", $photoLinks), 3 => implode(",", $ids), 4 => implode(",", $scores), 5 => implode(",", $pr));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // GetUsers
    
    function get_users($user_name, $user_mail){

        $friends_id = R::getAll("SELECT * FROM users");
        
        $ids = array();
        $names = array();
        $photoLinks = array();
        $scores = array();
        $projects1 = array();
        $pr = array();
        
        $user_user_user = R::findOne('users', 'mail = ?', array($user_mail));
        $array_user_user = explode(",", $user_user_user->friendsR);
        $array_user_user1 = explode(",", $user_user_user->friends);
        
        foreach ($friends_id as &$value){
            //$friend = R::findOne('users', 'id = ?', array($friends_id[$i]));
            if (strpos($value["name"], $user_name) !== false && $user_mail != $value["mail"] && array_search($value["id"], $array_user_user) === false && array_search($value["id"], $array_user_user1) === false) {
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //GetFriendAllLinks
    
    function get_user_tg_link2($user_id){
        $user = R::findOne('users', 'id = ?', array($user_id));
        
        if(strcmp($user->telegramLink, "https://") == 0){
            return "null";
        }

        return $user->telegramLink;

    }
    function get_user_vk_link2($user_id){
        $user = R::findOne('users', 'id = ?', array($user_id));
        
        if(strcmp($user->vkLink, "https://") == 0){
            return "null";
        }

        return $user->vkLink;

    }
    function get_user_web_link2($user_id){
        $user = R::findOne('users', 'id = ?', array($user_id));
        
        if(strcmp($user->websiteLink, "https://") == 0){
            return "null";
        }

        return $user->websiteLink;

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //DeleteFriend
    
    function delete_friend($user_mail, $id){
        $user1 = R::findOne('users', 'mail = ?', array($user_mail));
        $user2 = R::findOne('users', 'id = ?', array($id));
        
        $id1 = $user1->id;
        $id2 = $user2->id;
        
        $friends1_vsp = $user1->friends;
        $friends2_vsp = $user2->friends;
        
        $friends1 = explode(",", $friends1_vsp);
        $friends2 = explode(",", $friends2_vsp);
        $friends1 = array_diff($friends1, [$id2]);
        $friends2 = array_diff($friends2, [$id1]);
        
        if(count($friends1) == 0){
            $user1->friends = "Нет друзей";
        }
        else{
            $user1->friends = implode(",", $friends1);
        }
        if(count($friends2) == 0){
            $user2->friends = "Нет друзей";
        }
        else{
            $user2->friends = implode(",", $friends2);
        }
        
        R::store($user1);
        R::store($user2);
        
        return "Друг удалён";
    }
    
    
    // AddFriend
    
    function add_friend1($user_mail, $id){
        $user1 = R::findOne('users', 'mail = ?', array($user_mail));
        $user2 = R::findOne('users', 'id = ?', array($id));
        
        $friends1 = $user1->friends;
        $friends2 = $user2->friends;
        if(strcmp($friends1, "Нет друзей") == 0){
            $friends1 = $id;
        }
        else{
            $friends1 = $friends1 . "," . $id;
        }
        if(strcmp($friends2, "Нет друзей") == 0){
            $friends2 = $user1->id;
        }
        else{
            $friends2 = $friends2 . "," . $user1->id;
        }
        $user1->friends = $friends1;
        $user2->friends = $friends2;
        
        $friendsr = $user1->friends_r;
        
        $friends_r_id = explode(",", $friendsr);
        
        $key = array_search($id, $friends_r_id);
        unset($friends_r_id[$key]);
        $friends_r_id = array_values($friends_r_id);
        
        if(empty($friends_r_id)){
            $user1->friends_r = "Нет запросов";
        }
        else{
            $user1->friends_r = implode(",", $friends_r_id);
        }
        
        R::store($user1);
        R::store($user2);
        
        $user3 = R::findOne('users', 'mail = ?', array($user_mail));
        $user4 = R::findOne('users', 'id = ?', array($id));
        $arr_rr1_vsp = $user3->friends;
        $arr_rr1 = explode(",", $arr_rr1_vsp);
        $arr_rr1 = array_unique($arr_rr1);
        $arr_rr2_vsp = $user4->friends;
        $arr_rr2 = explode(",", $arr_rr2_vsp);
        $arr_rr2 = array_unique($arr_rr2);
        $user3->friends = implode(",", $arr_rr1);
        $user4->friends = implode(",", $arr_rr2);
        R::store($user3);
        R::store($user4);
        
        return "Друг добавлен";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // CreateNameLog1
    
    function send_user_link_tg($user_mail, $tg_link){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $user->telegramLink = $tg_link;
        
        R::store($user);
        return "Успешно";
    }
    function send_user_link_vk($user_mail, $vk_link){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $user->vkLink = $vk_link;
        
        R::store($user);
        return "Успешно";
    }
    function send_user_link_web($user_mail, $web_link){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        $user->websiteLink = $web_link;
        
        R::store($user);
        return "Успешно";
    }
    
    function create_name1($name, $image, $mail){
        $user = R::findOne('users', 'mail = ?', array($mail));
        
        file_put_contents(__DIR__ . '/lol.txt', $name);
        
        $user->name = $name;
        move_uploaded_file($image, "/home/a0773839/domains/development-team.ru/public_html/serveritcollabhub/images/" . strval($user->photoName) . "(1)" . ".png");
        $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/" . strval($user->photoName) . "(1)" . ".png";
        $user->photoName = (strval($user->photoName) . "(1)");
        
        R::store($user);
        
        if($user->name != "") {
            return "Сохранено";
        }
        
        return "Ошибка";
        
    }
    function create_name_without_image($name, $mail){
        $user = R::findOne('users', 'mail = ?', array($mail));
        
        $user->name = $name;
        //$tmp = "https://serveritcollabhub.development-team.ru/images/" . "itcollabhub" . ".png";
        //$user->photoLocalLink = $tmp;
        
        R::store($user);
        
        if($user->name != "") {
            return "Сохранено";
        }
        
        return "Ошибка";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // SendRequestToAddFriend
    
    function send_request_to_add_friend($user_mail, $id){
        $user1 = R::findOne('users', 'id = ?', array($id));
        $user2 = R::findOne('users', 'mail = ?', array($user_mail));
        $vsp = array($user1->friends_r);
        
        if(strcmp($user1->friends_r, "Нет запросов") == 0){
            $vsp = array($user2->id);
        }
        else{
            $vsp = array_merge($vsp, array($user2->id));
        }
        
        $user1->friends_r = implode(",", $vsp);
        
        R::store($user1);
        
        return "Запрос отправлен";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // GetAllLinks
    
    function get_user_tg_link($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if(strcmp($user->telegramLink, "https://") == 0){
            return "null";
        }

        return $user->telegramLink;

    }
    function get_user_vk_link($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if(strcmp($user->vkLink, "https://") == 0){
            return "null";
        }

        return $user->vkLink;

    }
    function get_user_web_link($user_mail){
        $user = R::findOne('users', 'mail = ?', array($user_mail));
        
        if(strcmp($user->websiteLink, "https://") == 0){
            return "null";
        }

        return $user->websiteLink;

    }
?>