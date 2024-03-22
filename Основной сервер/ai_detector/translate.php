<?php
    function translate($text,$source_lang='ru',$target_lang='en'){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://translate.googleapis.com/translate_a/single?client=gtx&dt=t',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'sl='.$source_lang.'&tl='.$target_lang.'&q='.urlencode($text),
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/x-www-form-urlencoded'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $sentencesArray = json_decode($response, true);
      $sentences = "";
      foreach ($sentencesArray[0] as $s) {
            $sentences .= isset($s[0]) ? $s[0] : '';
        }
      
      return $sentences;
    }
?>