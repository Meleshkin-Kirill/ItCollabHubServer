<?php
    include 'mail1.php';
    include 'rb.php';
    R::setup('ХОСТ БД', 'ЛОГИН ОТ БД', 'ПАРОЛЬ ОТ БД');
    
    if(!R::testConnection()){
        echo "ОШИБКА ПОДКЛЮЧЕНИЯ";
        exit;
    }
    
    
    // Баны пользователей
    $users = R::findAll('users');
    
    for($i = 1; $i <= count($users); $i++){
        $user_score = $users[$i]->topScore;
        $user_status = $users[$i]->topStatus;
        $user_name = $users[$i]->name;
        $user_mail = $users[$i]->mail;
        
        if($user_score < 100){
            if($user_status != "Новый пользователь"){
                $user = R::findOne('users', 'mail = ?', array($user_mail));
                
                $user->topStatus = "Новый пользователь";
                
                R::store($user);
            }
        }
        else if($user_score < 300){
            if($user_status != "Активный пользователь"){
                $user = R::findOne('users', 'mail = ?', array($user_mail));
                
                $user->topStatus = "Активный пользователь";
                
                R::store($user);
                
                send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Активный пользователь'.");
            }
        }
        else if($user_score < 1000){
            if($user_status != "Бронзовый пользователь"){
                $user = R::findOne('users', 'mail = ?', array($user_mail));
                
                $user->topStatus = "Бронзовый пользователь";
                
                R::store($user);
                
                send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Бронзовый пользователь'.");
            }
        }
        else if($user_score < 2500){
            if($user_status != "Серебряный пользователь"){
                if($user_status == "Бронзовый пользователь"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->topStatus = "Серебряный пользователь";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Серебряный пользователь'.");
                }
                else if($user_status != "Заблокирован"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->name = $user->name . " - заблокирован";
                    $user->topStatus = "Заблокирован";
                    $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/ban.png";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Блокировка аккаунта. ITCollabHub", "Здравствуйте, $name. Мы обнаружили подозрительную активность на вашем аккаунте, в свзяи с чем вынуждены заблокировать ваш аккаунта. Для разблокировки аккаунта напишите нам на почту help@dv-team.ru.");
                }
            }
        }
        else if($user_score < 7000){
            if($user_status != "Золотой пользователь"){
                if($user_status == "Серебряный пользователь"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->topStatus = "Золотой пользователь";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Золотой пользователь'.");
                }
                else if($user_status != "Заблокирован"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->name = $user->name . " - заблокирован";
                    $user->topStatus = "Заблокирован";
                    $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/ban.png";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Блокировка аккаунта. ITCollabHub", "Здравствуйте, $name. Мы обнаружили подозрительную активность на вашем аккаунте, в свзяи с чем вынуждены заблокировать ваш аккаунта. Для разблокировки аккаунта напишите нам на почту help@dv-team.ru.");
                }
            }
        }
        else if($user_score < 17000){
            if($user_status != "Гранд-пользователь (уровень 1)"){
                if($user_status == "Золотой пользователь"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->topStatus = "Гранд-пользователь (уровень 1)";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Гранд-пользователь (уровень 1)'.");
                }
                else if($user_status != "Заблокирован"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->name = $user->name . " - заблокирован";
                    $user->topStatus = "Заблокирован";
                    $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/ban.png";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Блокировка аккаунта. ITCollabHub", "Здравствуйте, $name. Мы обнаружили подозрительную активность на вашем аккаунте, в свзяи с чем вынуждены заблокировать ваш аккаунта. Для разблокировки аккаунта напишите нам на почту help@dv-team.ru.");
                }
            }
        }
        else if($user_score < 30000){
            if($user_status != "Гранд-пользователь (уровень 2)"){
                if($user_status == "Гранд-пользователь (уровень 1)"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->topStatus = "Гранд-пользователь (уровень 2)";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Гранд-пользователь (уровень 2)'.");
                }
                else if($user_status != "Заблокирован"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->name = $user->name . " - заблокирован";
                    $user->topStatus = "Заблокирован";
                    $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/ban.png";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Блокировка аккаунта. ITCollabHub", "Здравствуйте, $name. Мы обнаружили подозрительную активность на вашем аккаунте, в свзяи с чем вынуждены заблокировать ваш аккаунта. Для разблокировки аккаунта напишите нам на почту help@dv-team.ru.");
                }
            }
        }
        else if($user_score < 50000){
            if($user_status != "Гранд-пользователь (уровень 3)"){
                if($user_status == "Гранд-пользователь (уровень 2)"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->topStatus = "Гранд-пользователь (уровень 3)";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Гранд-пользователь (уровень 3)'.");
                }
                else if($user_status != "Заблокирован"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->name = $user->name . " - заблокирован";
                    $user->topStatus = "Заблокирован";
                    $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/ban.png";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Блокировка аккаунта. ITCollabHub", "Здравствуйте, $name. Мы обнаружили подозрительную активность на вашем аккаунте, в свзяи с чем вынуждены заблокировать ваш аккаунта. Для разблокировки аккаунта напишите нам на почту help@dv-team.ru.");
                }
            }
        }
        else{
            if($user_status != "Бриллиантовый пользователь"){
                if($user_status == "Гранд-пользователь (уровень 3)"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->topStatus = "Бриллиантовый пользователь";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Повышение уровня! ITCollabHub", "Здравствуйте, $name! Ваш уровень повышен до 'Бриллиантовый пользователь'.");
                }
                else if($user_status != "Заблокирован"){
                    $user = R::findOne('users', 'mail = ?', array($user_mail));
                    
                    $user->name = $user->name . " - заблокирован";
                    $user->topStatus = "Заблокирован";
                    $user->photoLocalLink = "https://serveritcollabhub.development-team.ru/images/ban.png";
                    
                    R::store($user);
                    
                    send_mail_to_user($user_mail, "Блокировка аккаунта. ITCollabHub", "Здравствуйте, $name. Мы обнаружили подозрительную активность на вашем аккаунте, в свзяи с чем вынуждены заблокировать ваш аккаунта. Для разблокировки аккаунта напишите нам на почту help@dv-team.ru.");
                }
            }
        }
    }
    
    
    date_default_timezone_set('UTC-3');
    
    // Объявления
    $ads = R::findAll('ads');
    
    for($i = 1; $i <= count($ads); $i++){
        $iddd = $ads[$i]->id;
        $text = $ads[$i]->time;
        $text = substr_replace($text, '.20', 5, 1);
        $date = $text;
        $diff = strtotime(substr_replace(date("d.m.y"), '.20', 5, 1)) - strtotime($text);
        $days = intval($diff / 86400);
        
        if($days == 1){
            $ad = R::findOne('ads', 'id = ?', array($iddd));
            
            $ad->isFix = 0;
            
            R::store($ad);
        }
        if($days >= 4){
            $ad = R::findOne('ads', 'id = ?', array($iddd));
            
            $ad->isLife = 0;
            
            R::store($ad);
        }
    }
    
    
    // Дедлайны
    $tas = R::findAll('tasks');
    
    for($i = 1; $i <= count($tas); $i++){
        if(strcmp($tas[$i]->endTime, "Нет") == 0){
            continue;
        }
        else{
            $date2 = new DateTime(str_replace(".", "-", $tas[$i]->endTime));
            $date = new DateTime(date("d-m-Y"));
            
            if($date2->getTimestamp() - $date->getTimestamp() <= 0){
                $task = R::findOne('tasks', 'id = ?', array($tas[$i]->id));
                $task->isComplete = 1;
                R::store($task);
            }
        }
    }
    
    // Очистка ненужных таблиц
    R::wipe('temporaryusers');
    R::wipe('temporary2users');
?>