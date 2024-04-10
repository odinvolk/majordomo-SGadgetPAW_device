<?php
/* SGadgetPAW_saySpeech.php
* Сообщение для Алисы голосовое 
*
* sayTo("фраза",2,несуществующий терминал);
* sayReply($txt.".".$txt1.".".$txt2.".".$txt3.".".$status.".".$status1....
* sayTo("фраза",2,MAIN); PAW/all_devices/tts/request
* 
* ProcessCommand($command) -- отправляет текстовую команду на исполнение (например, "скажи сколько время").
* Сами команды настраиваются методе ThisComputer->commandReceived.
* 
* $command = "$speech";
* ProcessCommand($command);
* processcommand
* context_activate(12); // запускает конкретный контекст
* processSubscriptionsSafe('SAY', array('level' => '20', 'message' => $speech));
* processSubscriptions('SAY', array('level' => '20', 'message' => $speech));
* ask($speech, 0, 0);
* say($speech, 0); //, $from_user_id
*/
$speech = $params['NEW_VALUE'];
/* */
if (isset($params['VALUE'])) { // проверяем есть ли $params['VALUE'] в сообщении
    $speech = $params['VALUE'];  // то принимаем $params['NEW_VALUE']
} else { 
    return;//$speech = $this->getProperty('info_speech_results');
} 

//$msl = $this->getProperty('msgLevel');
$msgLevel = getGlobal('ThisComputer.minMsgLevel');

if (preg_match('/передай (.+)/uis',$speech,$m)) {
    say($m[1], 1);
  return;
} elseif (preg_match('/павлик (.+)/uis',$speech,$m)) { 
    say($m[1], 1, 5,);
  return;
} elseif (preg_match('/громко (.+)/uis',$speech,$m)) { 
    say($m[1], 99);
  return;
} elseif (preg_match('/лапка (.+)/uis',$speech,$m)) { 
    processCommand($m[1]);
  return;
} elseif (preg_match('/маша/uis',$speech)) { 
    say("весна", 0);
  return;
} elseif (preg_match('/оля/uis',$speech)) { 
    say("если весна то лето", 0);
  return;
} else {
    getURL(BASE_URL.ROOTHTML."/command.php?qry=".urlencode($speech)."&user_id=5", 0);
    /* http://192.168.10.26/command.php?qry=привет&Submit=Say
    //$getInfo = getURL($ipterm.'/?cmd='.$cmd.'&text='.urlencode($text).'&locale='.$locale.'&password='.$pass.'&type=json', 0);
    //url: '/command.php?qry='+encodeURI(voiceStr.substring(keyWords)),
    //sayReplySafe($speech, 0);
    Обработчик скриптов /objects/?script=  
    Обработчик голосовых команд /command.php?qry=  
    Обработчик GPS /gps.php 
    Обработчик QR-кодов/popup/app_qrcodes.html?qr= 
    Обработчик событий /api/events/
    Обработчик видео сообщений /popup/app_videomessages.html
    Обработчик детектора лиц /objects/?script=facedetection
    BASE_URL.ROOTHTML.
    */
  return;
}

/*
* ID пользователя можно посмотреть в адресной строке браузера в Пользователях
* $from_user_id = '0'; 
* 0 = Алиса 
* 1 = Admin 
* 5 = Pavlik 
* 6 = Kost 
*/

$from_user_id = '1';
$ot = $this->object_title;
$name = $this->getProperty('namePAW');
//Добавляем трансляцию в registerEvent
 if ($this->getProperty('registerEvent_status'))
 {
    registerEvent($name.'/info/speech/results', array('speech'=>$speech, 'msgLevel'=>$msgLevel, 'from_user_id'=>$from_user_id));
 }
//Добавляем трансляцию в Telegram
if ($this->getProperty('registerTelegram_status'))
{
include_once(DIR_MODULES . 'telegram/telegram.class.php');
$telegram_module = new telegram();
//$telegram_module->sendMessageToAll($ot."-".$speech, null, '', !$isImportant);
$telegram_module->sendMessageToAll($ot."-".$speech, null, '', false);// со звуком
}
