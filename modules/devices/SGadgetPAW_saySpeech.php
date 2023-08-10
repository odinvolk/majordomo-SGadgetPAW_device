<?php
//Сообщение для Алисы голосовое
//sayTo("фраза",2,несуществующий терминал);
//sayReply($txt.".".$txt1.".".$txt2.".".$txt3.".".$status.".".$status1....
//sayTo("фраза",2,MAIN); PAW/all_devices/tts/request
$speech = $params['VALUE'];

$name = $this->getProperty('namePAW');
$msgLevel = $this->getProperty('msgLevelS');
//$from_user_id = '0'; // 0 = Алиса 1 = Admin 5 = Pavlik 6 = Kost ID пользователя можно посмотреть в адресной строке браузера в Пользователях

//Добавляем трансляцию в registerEvent
 if ($registerEvent_st)
 {
     registerEvent($name.'/info/speech/results', array('speech'=>$speech, 'from_user_id'=>$from_user_id));
 }
say($speech, $msgLevel); //, $from_user_id
