<?php

    function send_mail_to_user($user_mail, $subject, $message){
        $headers = 'From: itcollabhub@development-team.ru'       . "\r\n" .
                     'Reply-To: itcollabhub@development-team.ru' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
                     
        mail($user_mail, $subject, $message, $headers);
    }
    
?>