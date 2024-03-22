<?php
$rq = $_POST['Request'];

// Блок профиля пользователя
$user_requests = array("GetUserInformation", "GetUserFriends", "GetUserFriendsR", 
                    "GetUsers", "GetFriendAllLinks", "DeleteFriend", "SendRequestToAddFriend", 
                    "AddFriend", "GetAllLinks");

if(in_array($rq, $user_requests)){
    require('/home/a0773839/domains/development-team.ru/reg/profile.php');
    $user_mail = $_POST['UserMail'];
    $user_name = $_POST['UserName'];
    $user_id = $_POST['UserId'];
    $id = $_POST['Id'];
    $req = $rq;
    $arr = array();

    if(strcmp($req, "GetUserInformation") == 0)
        $arr = array('name' => get_user_name($user_mail), 'urlImg' => get_user_urlImg($user_mail), 'projects' => get_user_projects($user_mail), 'topScore' => get_user_top_score($user_mail), 'topStatus' => get_user_top_status($user_mail), 'rFr' => get_user_fr_r($user_mail), 'activityProjects' => get_user_activity_projects($user_mail), 'archiveProjects' => get_user_archive_projects($user_mail));
    if(strcmp($req, "GetFriendAllLinks") == 0)
        $arr = array('tgLink' => get_user_tg_link2($user_id), 'vkLink' => get_user_vk_link2($user_id), 'webLink' => get_user_web_link2($user_id));
    if(strcmp($req, "DeleteFriend") == 0)
        $arr = array('ret' => delete_friend($user_mail, $id));
    if(strcmp($req, "SendRequestToAddFriend") == 0)
        $arr = array('ret' => send_request_to_add_friend($user_mail, $id));
    if(strcmp($req, "AddFriend") == 0)
        $arr = array('ret' => add_friend1($user_mail, $id));
    if(strcmp($req, "GetAllLinks") == 0)
        $arr = array('tgLink' => get_user_tg_link($user_mail), 'vkLink' => get_user_vk_link($user_mail), 'webLink' => get_user_web_link($user_mail));

    if(strcmp($req, "GetUserFriends") == 0){
        $a = get_friends($user_mail);
        $arr = array('ret' => "$a[1];$a[2];$a[3];$a[4];$a[5]");
    }
    if(strcmp($req, "GetUserFriendsR") == 0){
        $a = get_friendsr($user_mail);
        $arr = array('ret' => "$a[1];$a[2];$a[3];$a[4];$a[5]");
    }
    if(strcmp($req, "GetUsers") == 0){
        $a = get_users($user_name, $user_mail);
        $arr = array('ret' => "$a[1];$a[2];$a[3];$a[4];$a[5]");
    }

    echo json_encode($arr);
}
else if(strcmp($rq, "CreateNameLog1") == 0){
    require('/home/a0773839/domains/development-team.ru/reg/profile.php');
    $user_image = $_FILES['file']['tmp_name'];
    $user_name = $_POST['UserName'];
    $user_mail = $_POST['UserMail'];
    
    $tg_link = $_POST['LinkTG'];
    $vk_link = $_POST['LinkVK'];
    $web_link = $_POST['LinkWEB'];
    
    if(isset($_FILES['file'])){
        $arr1 = array('ret' => send_user_link_tg($user_mail, $tg_link));
        $arr2 = array('ret' => send_user_link_vk($user_mail, $vk_link));
        $arr3 = array('ret' => send_user_link_web($user_mail, $web_link));
        
        $arr = array('ret' => create_name1($user_name, $user_image, $user_mail));
        echo json_encode($arr);
    }
    else{
        $arr1 = array('ret' => send_user_link_tg($user_mail, $tg_link));
        $arr2 = array('ret' => send_user_link_vk($user_mail, $vk_link));
        $arr3 = array('ret' => send_user_link_web($user_mail, $web_link));
        
        $arr = array('ret' => create_name_without_image($user_name, $user_mail));
            
        echo json_encode($arr);
    }
}





// Блок тасков
$tasks_requests = array("CreateTask", "GetTasksFromProject", "CheckCountOfReadyWorksFromTask", 
                    "GetMoreInformationFromTaskFromProject", "SetTaskIsEnd", "GetDeadlinesFromProject");

if(in_array($rq, $tasks_requests)){
    require('/home/a0773839/domains/development-team.ru/reg/tasks.php');
    $req = $rq;
    $project_id = $_POST['ProjectID'];
    $user_mail = $_POST['UserMail'];
    $task_name = $_POST['TaskName'];
    $peoples_ids = $_POST['PeoplesIds'];
    $queue_blocks = $_POST['QueueBlocks'];
    $text_blocks = $_POST['TextBlocks'];
    $link_blocks = $_POST['LinkBlocks'];
    $image_blocks = $_POST['ImageBlocks'];
    $youtube_blocks = $_POST['YouTubeBlocks'];
    $task_id = $_POST['TaskID'];
    $end_time = $_POST['EndTime'];
    $arr = array();

    if(strcmp($rq, "CreateTask") == 0){
        $arr = array('ret' => create_task($project_id, $user_mail, $task_name, $peoples_ids, $queue_blocks, $text_blocks, $link_blocks, $image_blocks, $youtube_blocks, $end_time));
        echo json_encode($arr);
    }
    if(strcmp($rq, "SetTaskIsEnd") == 0){
        $arr = array('ret' => set_task_is_end($project_id, $user_mail, $task_id));
        echo json_encode($arr);
    }
    if(strcmp($rq, "GetTasksFromProject") == 0)
        echo get_tasks_from_project($project_id, $user_mail);
    if(strcmp($rq, "GetDeadlinesFromProject") == 0)
        echo get_deadlines_from_project($project_id, $user_mail);
    if(strcmp($rq, "CheckCountOfReadyWorksFromTask") == 0)
        echo check_count_of_ready_works_from_task($project_id, $user_mail, $task_id);
    if(strcmp($rq, "GetMoreInformationFromTaskFromProject") == 0)
        echo get_more_information_from_task_from_project($project_id, $user_mail, $task_id);
}





// Блок работ в тасках
$works_requests = array("CreateWorkInTask", "GetWorksFromTask", "GetMoreInformationFromWorkFromTask");

if(in_array($rq, $works_requests)){
    require('/home/a0773839/domains/development-team.ru/reg/tasksworks.php');
    $req = $rq;
    $project_id = $_POST['ProjectID'];
    $user_mail = $_POST['UserMail'];
    $task_id = $_POST['TaskID'];
    $text_blocks = $_POST['TextBlocks'];
    $link_blocks = $_POST['LinkBlocks'];
    $image_blocks = $_POST['ImageBlocks'];
    $work_id = $_POST['WorkID'];

    if(strcmp($rq, "CreateWorkInTask") == 0){
        $arr = array('ret' => create_work_to_task($project_id, $user_mail, $task_id, $text_blocks, $link_blocks, $image_blocks));
        echo json_encode($arr);
    }
    if(strcmp($rq, "GetWorksFromTask") == 0)
        echo get_works_from_task($project_id, $user_mail, $task_id);
    if(strcmp($rq, "GetMoreInformationFromWorkFromTask") == 0)
        echo get_one_work($project_id, $user_mail, $work_id);
}


// Блок блоков
$blocks_requests = array("CreateTextBlock", "CreateLinkBlock", "CreateImageBlock", "CreateYouTubeBlock");

if(in_array($rq, $blocks_requests)){
    require('/home/a0773839/domains/development-team.ru/reg/blocks.php');
    $req = $rq;
    $project_id = $_POST['ProjectID'];
    $user_mail = $_POST['UserMail'];
    $text_block = $_POST['TextBlock'];
    $name_link_block = $_POST['NameLinkBlock'];
    $link_block = $_POST['LinkBlock'];
    $name_image_block = $_POST['NameImageBlock'];
    $image = $_FILES['file']['tmp_name'];
    $name_YouTube_block = $_POST['NameYouTubeBlock'];
    $YouTube_block = $_POST['YouTubeBlock'];

    $arr = array();

    if(strcmp($rq, "CreateTextBlock") == 0)
        $arr = array('ret' => create_text_block($project_id, $user_mail, $text_block));
    if(strcmp($rq, "CreateLinkBlock") == 0)
        $arr = array('ret' => create_link_block($project_id, $user_mail, $name_link_block, $link_block));
    if(strcmp($rq, "CreateImageBlock") == 0)
        $arr = array('ret' => create_image_block($project_id, $user_mail, $name_image_block, $image));
    if(strcmp($rq, "CreateYouTubeBlock") == 0)
        $arr = array('ret' => create_youtube_block($project_id, $user_mail, $name_YouTube_block, $YouTube_block));

    echo json_encode($arr);
}

// Блок файлов проекта
$files_requests = array("CreateFileWithoutImage", "CreateFile", "GetProjectFiles", "DetachedFile", "FixFile", "DeleteFile", "GetProjectFilesIds", "ChangeFileWithoutImage", "ChangeFile");

if(in_array($rq, $files_requests)){
    require('/home/a0773839/domains/development-team.ru/reg/files.php');
    $req = $rq;
    $file_image = $_FILES['file']['tmp_name'];
    $file_name = $_POST['FileName'];
    $file_link = $_POST['FileLink'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    $id = $_POST['FilesId'];
    $file_id = $_POST['FileId'];
    
    $arr = array();

    if(strcmp($rq, "CreateFileWithoutImage") == 0)
        $arr = array('ret' => create_file_without_image($file_name, $project_id, $user_mail, $file_link));
    if(strcmp($rq, "CreateFile") == 0)
        $arr = array('ret' => create_file1($file_name, $project_id, $file_image, $user_mail, $file_link));
    if(strcmp($req, "GetProjectFiles") == 0)
        $arr = array('ret' => get_files($id));
    if(strcmp($req, "DetachedFile") == 0)
        $arr = array('ret' => detached_file1($project_id, $user_mail, $file_id));
    if(strcmp($req, "FixFile") == 0)
        $arr = array('ret' => fix_file1($project_id, $user_mail, $file_id));
    if(strcmp($req, "DeleteFile") == 0)
        $arr = array('ret' => delete_file1($project_id, $user_mail, $file_id));
    if(strcmp($req, "GetProjectFilesIds") == 0)
        $arr = array('ret' => get_project_files_ids($project_id));
    if(strcmp($rq, "ChangeFileWithoutImage") == 0) 
        $arr = array('ret' => change_file_without_image($file_name, $project_id, $user_mail, $file_link, $file_id));
    if(strcmp($rq, "ChangeFile") == 0)
        $arr = array('ret' => change_file1($file_name, $project_id, $file_image, $user_mail, $file_link, $file_id));
    
    file_put_contents(__DIR__ . '/VaniniBagi.txt', json_encode($arr));
    echo json_encode($arr);
}





// Блок объявлений проекта
$ads_requests = array("CreateAdWithoutImage", "CreateAd", "GetProjectAds", "DeleteAd", "GetProjectAdsIds", "GetProjectAdsIds2", "ChangeAdWithoutImage", "ChangeAd");

if(in_array($rq, $ads_requests)){
    require('/home/a0773839/domains/development-team.ru/reg/ads.php');
    $req = $rq;
    $file_image = $_FILES['file']['tmp_name'];
    $ad_name = $_POST['AdName'];
    $advertisement = $_POST['Advertisement'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    $ad_id = $_POST['AdId'];
    $id = $_POST['AdsId'];
    
    $arr = array();

    if(strcmp($rq, "CreateAd") == 0)
        $arr = array('ret' => create_ad1($ad_name, $project_id, $file_image, $user_mail, $advertisement));
    if(strcmp($rq, "CreateAdWithoutImage") == 0) 
        $arr = array('ret' => create_ad_without_image($ad_name, $project_id, $user_mail, $advertisement));
    if(strcmp($rq, "ChangeAd") == 0)
        $arr = array('ret' => change_ad1($ad_name, $project_id, $file_image, $user_mail, $advertisement, $ad_id));
    if(strcmp($rq, "ChangeAdWithoutImage") == 0)
        $arr = array('ret' => change_ad_without_image($ad_name, $project_id, $user_mail, $advertisement, $ad_id));
    if(strcmp($rq, "GetProjectAdsIds") == 0)
        $arr = array('ret' => get_project_ads_ids1($project_id));
    if(strcmp($rq, "GetProjectAdsIds2") == 0)
        $arr = array('ret' => get_project_ads_ids2($project_id));
    if(strcmp($rq, "GetProjectAds") == 0)
        $arr = array('ret' => get_ads($id));
    if(strcmp($req, "DeleteAd") == 0)
        $arr = array('ret' => delete_ad1($project_id, $user_mail, $ad_id));

    echo json_encode($arr);
}






































include_once('/home/a0773839/domains/development-team.ru/reg/reg.php');
if(strcmp($rq, "GetProjectAddsUsers") == 0){
    $ids = $_POST['IDs'];
    
    echo get_project_adds_users($ids);
}

if(strcmp($rq, "SetProjectIsEnd") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $users_ins = $_POST['UsersIns'];
    
    $arr = array('ret' => set_project_is_end($project_id, $user_mail, $users_ins));
    echo json_encode($arr);
}

if(strcmp($rq, "SaveChangesFromProjectWithImageAndIsOpenAndIsVisibile") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $project_name = $_POST['ProjectName'];
    $project_image = $_FILES['file']['tmp_name'];
    
    $project_is_open = $_POST['ProjectIsOpen'];
    $project_is_visible = $_POST['ProjectIsVisible'];
    
    $arr = array('ret' => save_changes_from_project_with_image_and_opens($project_id, $user_mail, $project_name, $project_image, $project_is_open, $project_is_visible));
    echo json_encode($arr);
}

if(strcmp($rq, "SaveChangesFromProjectWithoutImageAndIsOpenAndIsVisibile") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $project_name = $_POST['ProjectName'];
    //$project_image = $_FILES['file']['tmp_name'];
    
    $project_is_open = $_POST['ProjectIsOpen'];
    $project_is_visible = $_POST['ProjectIsVisible'];
    
    $arr = array('ret' => save_changes_from_project_without_image_and_opens($project_id, $user_mail, $project_name, $project_is_open, $project_is_visible));
    echo json_encode($arr);
}

if(strcmp($rq, "SaveChangesFromProjectWithImageAndDescription") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $project_name = $_POST['ProjectName'];
    $project_image = $_FILES['file']['tmp_name'];
    
    $project_description = $_POST['ProjectDescription'];
    
    $arr = array('ret' => save_changes_from_project_with_image_and_description($project_id, $user_mail, $project_name, $project_image, $project_description));
    echo json_encode($arr);
}

if(strcmp($rq, "SaveChangesFromProjectWithoutImageAndDescription") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $project_name = $_POST['ProjectName'];
    
    $project_description = $_POST['ProjectDescription'];
    
    $arr = array('ret' => save_changes_from_project_without_image_and_description($project_id, $user_mail, $project_name, $project_description));
    echo json_encode($arr);
}

if(strcmp($rq, "SaveChangesFromProjectWithImageAndLinks") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $project_name = $_POST['ProjectName'];
    $project_image = $_FILES['file']['tmp_name'];
    
    $project_tg = $_POST['ProjectTG'];
    $project_vk = $_POST['ProjectVK'];
    $project_web = $_POST['ProjectWEB'];
    
    $arr = array('ret' => save_changes_from_project_with_image_and_links($project_id, $user_mail, $project_name, $project_image, $project_tg, $project_vk, $project_web));
    echo json_encode($arr);
}

if(strcmp($rq, "SaveChangesFromProjectWithoutImageAndLinks") == 0){
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $project_name = $_POST['ProjectName'];
    
    $project_tg = $_POST['ProjectTG'];
    $project_vk = $_POST['ProjectVK'];
    $project_web = $_POST['ProjectWEB'];
    
    $arr = array('ret' => save_changes_from_project_without_image_and_links($project_id, $user_mail, $project_name, $project_tg, $project_vk, $project_web));
    echo json_encode($arr);
}


if(strcmp($rq, "GetPeoplesFromProjects") == 0){
    $project_id = $_POST['ProjectID'];
    $user_mail = $_POST['UserMail'];
    echo get_peoples_from_project($project_id, $user_mail);
}



if(strcmp($rq, "CreateNameLog") == 0){
    $user_name = $_POST['UserName'];
    $user_mail = $_POST['UserMail'];
    
    if(isset($_FILES['file'])){
        $user_image = $_FILES['file']['tmp_name'];
        $arr = array('ret' => create_name($user_name, $user_image, $user_mail));
            
        echo json_encode($arr);
    }
    else{
        $arr = array('ret' => create_name_without_image($user_name, $user_mail));
            
        echo json_encode($arr);
    }
}


    
if(strcmp($rq, "CreateNewProject") == 0){
    $user_mail = $_POST['UserMail'];
    $p_name = $_POST['ProjectName'];
    $p_d = $_POST['ProjectDescription'];
    $p_p = $_POST['ProjectPurposes'];
    $p_t = $_POST['ProjectTasks'];
    $p_id = $_POST['UsersId'];
    $user_image = $_FILES['file']['tmp_name'];
    $arr = array('ret' => reg_new_project($p_name, $p_d, $user_mail, $p_id, $p_p, $p_t, $user_image));
    
    echo json_encode($arr);
}

if(strcmp($rq, "CreatePurpose") == 0){
    $purpose_image = $_FILES['file']['tmp_name'];
    $purpose_name = $_POST['PurposeName'];
    $purpose_description = $_POST['PurposeDescription'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $arr = array('ret' => create_purpose1($purpose_name, $project_id, $purpose_description, $purpose_image, $user_mail));
    echo json_encode($arr);
    
}

if(strcmp($rq, "CreatePurposeWithoutImage") == 0){
    $purpose_name = $_POST['PurposeName'];
    $purpose_description = $_POST['PurposeDescription'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $arr = array('ret' => create_purpose_without_image($purpose_name, $project_id, $purpose_description, $user_mail));
    echo json_encode($arr);
}

if(strcmp($rq, "CreateProblem") == 0){
    $problem_image = $_FILES['file']['tmp_name'];
    $problem_name = $_POST['ProblemName'];
    $problem_description = $_POST['ProblemDescription'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    $arr = array('ret' => create_problem1($problem_name, $project_id, $problem_description, $problem_image, $user_mail));
    echo json_encode($arr);
    
}

if(strcmp($rq, "CreateProblemWithoutImage") == 0){
    $problem_name = $_POST['ProblemName'];
    $problem_description = $_POST['ProblemDescription'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    
    
    $arr = array('ret' => create_problem_without_image($problem_name, $project_id, $problem_description, $user_mail));
    echo json_encode($arr);
}


if(strcmp($rq, "ChangeProblem") == 0){
    $problem_image = $_FILES['file']['tmp_name'];
    $problem_name = $_POST['ProblemName'];
    $problem_description = $_POST['ProblemDescription'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    $pr_id = $_POST['ProblemId'];
    
    $arr = array('ret' => change_problem1($problem_name, $project_id, $problem_description, $problem_image, $user_mail, $pr_id));
    echo json_encode($arr);
    
}

if(strcmp($rq, "ChangeProblemWithoutImage") == 0){
    $problem_name = $_POST['ProblemName'];
    $problem_description = $_POST['ProblemDescription'];
    $project_id = $_POST['ProjectId'];
    $user_mail = $_POST['UserMail'];
    $pr_id = $_POST['ProblemId'];
    
    $arr = array('ret' => change_problem_without_image($problem_name, $project_id, $problem_description, $user_mail, $pr_id));
    echo json_encode($arr);
}










if(isset($_POST['Request'])){
    
    $req = $_POST['Request'];
    if(strcmp($req, "RegNewUser") == 0){
        $user_name = $_POST['UserName'];
        $user_mail = $_POST['UserMail'];
        $user_pass = $_POST['UserPassword'];
        
        $arr = array('ret' => reg_new_user($user_name, $user_pass, $user_mail));
        
        echo json_encode($arr);
    }
    if(strcmp($req, "PostToNewUserCode") == 0){
        $user_mail = $_POST['UserMail'];
        $arr = array('ret' => post_to_new_user_code($user_mail));
        
        echo json_encode($arr);
    }
    if(strcmp($req, "CheckerCode") == 0){
        $user_mail = $_POST['UserMail'];
        $user_code = $_POST['UserCode'];
        
        $arr = array('ret' => checker_code($user_mail, $user_code));
        echo json_encode($arr);
    }
    
    // Блок входа
    if(strcmp($req, "UserLogInMail") == 0){
        $user_mail = $_POST['UserMail'];
        
        $arr = array('ret' => user_log_in_mail($user_mail));
        echo json_encode($arr);
    }
    if(strcmp($req, "UserLogInMai2l") == 0){
        $user_mail = $_POST['UserMail'];
        $user_code = $_POST['UserCode'];
        
        $arr = array('ret' => user_log_in_mail2($user_mail, $user_code));
        echo json_encode($arr);
    }
    if(strcmp($req, "UserLogIn") == 0){
        $user_mail = $_POST['UserMail'];
        $user_pass = $_POST['UserPassword'];
        
        //$arr = array('ret' => user_log_in($user_mail, $user_pass));
        echo user_log_in($user_mail, $user_pass);
        //echo "LoL";
    }
    
    
    
    if(strcmp($req, "GetUsersToProject") == 0){
        $user_name = $_POST['UserName'];
        $user_mail = $_POST['UserMail'];
        $a = get_users_to_project($user_name, $user_mail);
        $arr = array('ret' => "$a[1];$a[2];$a[3];$a[4];$a[5]");
        echo json_encode($arr);
    }
    
    
    
    if(strcmp($req, "GetUserProject") == 0){
        $user_mail = $_POST['UserMail'];
        $a = get_user_projects5($user_mail);
        $arr = array('ret' => "$a[1]🕰$a[2]🕰$a[3]🕰$a[4]🕰$a[5]🕰$a[6]🕰$a[7]🕰$a[8]");
        echo json_encode($arr);
    }
    if(strcmp($req, "GetUserProjectArchive") == 0){
        $user_mail = $_POST['UserMail'];
        $a = get_user_projects50($user_mail);
        $arr = array('ret' => "$a[1]🕰$a[2]🕰$a[3]🕰$a[4]🕰$a[5]🕰$a[6]🕰$a[7]🕰$a[8]");
        echo json_encode($arr);
    }
    if(strcmp($req, "GetProjectMainInformation") == 0){
        $project_id = $_POST['ProjectId'];
        $user_mail = $_POST['UserMail'];
        $arr = array('name' => get_project_name($project_id), 'urlImg' => get_project_urlImg($project_id), 'description' => get_project_description($project_id), 'isend' => get_project_is_end($project_id), 'purposes' =>  get_project_purposes($project_id), 'problems' => get_project_problems($project_id), 'tasks' => get_project_tasks($project_id),'peoples' => get_project_peoples($project_id), 'time' => get_project_time($project_id), 'time1' => get_project_time1($project_id), 'tg' => get_project_tg($project_id), 'vk' => get_project_vk($project_id), 'webs' => get_project_webs($project_id), 'purposesids' => get_project_purposes_ids($project_id), 'problemsids' => get_project_problems_ids($project_id), 'isl' => get_project_is_lider($project_id, $user_mail), 'isOpen' => get_project_is_open($project_id), 'isVisible' => get_project_is_visible($project_id));
        //$arr = array('name' => get_project_name($project_id), 'urlImg' => get_project_urlImg($project_id), 'description' => get_project_description($project_id));
        echo json_encode($arr);
    }
    if(strcmp($req, "GetProjectMainInformation1") == 0){
        $project_id = $_POST['ProjectId'];
        $user_mail = $_POST['UserMail'];
        $arr = array('name' => get_project_name($project_id), 'urlImg' => get_project_urlImg($project_id), 'description' => get_project_description($project_id), 'isend' => get_project_is_end($project_id), 'purposes' =>  get_project_purposes($project_id), 'problems' => get_project_problems($project_id), 'tasks' => get_project_tasks($project_id),'peoples' => get_project_peoples($project_id), 'time' => get_project_time($project_id), 'time1' => get_project_time1($project_id), 'tg' => get_project_tg($project_id), 'vk' => get_project_vk($project_id), 'webs' => get_project_webs($project_id), 'purposesids' => get_project_purposes_ids($project_id), 'problemsids' => get_project_problems_ids($project_id), 'isl' => get_project_is_lider($project_id, $user_mail), 'isOpen' => get_project_is_open($project_id), 'isVisible' => get_project_is_visible($project_id));
        //$arr = array('name' => get_project_name($project_id), 'urlImg' => get_project_urlImg($project_id), 'description' => get_project_description($project_id));
        echo json_encode($arr);
    }
    if(strcmp($req, "GetProjectProblemsIDs") == 0){
        $project_id = $_POST['ProjectId'];
        $arr = array('problemsids' => get_project_problems_ids($project_id));
        echo json_encode($arr);
    }
    if(strcmp($req, "GetProjectPurposesIDs") == 0){
        $project_id = $_POST['ProjectId'];
        $arr = array('purposesids' => get_project_purposes_ids($project_id));
        echo json_encode($arr);
    }
    
    
    if(strcmp($req, "GetRProjects") == 0){
        $user_mail = $_POST['UserMail'];
        $a = get_user_r_projects5($user_mail);
        $arr = array('ret' => "$a[1];$a[2];$a[3]");
        echo json_encode($arr);
    }
    if(strcmp($req, "AddUserToProject") == 0){
        $user_mail = $_POST['UserMail'];
        $project_id = $_POST['ProjectId'];
        $a = add_user_to_project($user_mail, $project_id);
        $arr = array('ret' => "Okey");
        echo json_encode($arr);
    }
    if(strcmp($req, "NotAddUserToProject") == 0){
        $user_mail = $_POST['UserMail'];
        $project_id = $_POST['ProjectId'];
        $a = not_add_user_to_project($user_mail, $project_id);
        $arr = array('ret' => "Okey");
        echo json_encode($arr);
    }
    if(strcmp($req, "GRProjects") == 0){
        $user_mail = $_POST['UserMail'];
        $arr = array('ret' => gr_projects($user_mail));
        echo json_encode($arr);
    }
    
    
    if(strcmp($req, "GetPurposes") == 0){
        $project_id = $_POST['ProjectId'];
        $arr = array('ret' => get_purposes($project_id));
        echo json_encode($arr);
    }
    
    if(strcmp($req, "GetProblems") == 0){
        $project_id = $_POST['ProjectId'];
        $arr = array('ret' => get_problems($project_id));
        echo json_encode($arr);
    }
    
    if(strcmp($req, "SetPurposeComplete") == 0){
        $purpose_id = $_POST['PurposeId'];
        $user_mail = $_POST['UserMail'];
        $project_id = $_POST['ProjectId'];
        $a = set_purpose_complete($purpose_id, $user_mail, $project_id);
        $arr = array('ret' => "Okey");
        echo json_encode($arr);
    }
    
    if(strcmp($req, "SetProblemComplete") == 0){
        $problem_id = $_POST['ProblemId'];
        $user_mail = $_POST['UserMail'];
        $project_id = $_POST['ProjectId'];
        $a = set_problem_complete($problem_id, $user_mail, $project_id);
        $arr = array('ret' => "Okey");
        echo json_encode($arr);
    }
    
    if(strcmp($req, "DeleteProblem") == 0){
        $problem_id = $_POST['ProblemId'];
        $user_mail = $_POST['UserMail'];
        $project_id = $_POST['ProjectId'];
        
        $a = set_problem_delete($problem_id, $user_mail, $project_id);
        $arr = array('ret' => "Okey");
        echo json_encode($arr);
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
?>