<?php
//Ответ от «диалогов» приходит в JSON формате и публикуется в топике /info/alert/response
// http://192.168.8.129:8080/api/set.json?alert=message&title=Title&negative=no&positive=yes&neutral=other&cancel=true

$message = $params['VALUE']; // Принимаем данные

$desc = $this->description;
$name=$this->getProperty('namePAW');
$msl = 0;
$msl = $this->getProperty('minMsgLevel');
//$status=$this->getProperty('info_alert_response');
$registerEvent_st = $this->getProperty('registerEvent_status');
$registerProperties_st = $this->getProperty('registerProperties_status');

// получаем такой json {"id": "2","state": "Yes"}
$json = json_decode($message, true, JSON_UNESCAPED_UNICODE); // декодируем в массив php
//----------------------- Раскладываем данные по переменным
$id = $json['id'];
$state = $json['state'];
//----------------------- Записываем данные в свойства
 if ($registerProperties_st)
 {
     $this->setProperty('id_alert', $id);   // sg($ot.'.id_alert', $id);
     $this->setProperty('state_alert', $state);
 }
//---------------------- Добавляем трансляцию в registerEvent
 if ($registerEvent_st)
 {
     registerEvent($name.'/info/alert/response', $json); //PAW/ZB602KL/info/alert/response
    //getURL('/api/events/'.$name.'/info/alert/response?param='.$json);
 }
//----------------------- Варианты ответов
switch ($state) {
    case 'Yes': break;
    case 'No': break;
    case 'Neutral': break;
    case 'Cancel': break;
    case 'Да': break;
    case 'Нет': break;
    case 'Незнаю': break;
    case 'Возможно': break;
    case 'Пофиг': break;
    case 'Забить': break;
     default: say('Принят неизвесный ответ - '.$json['state'].' для устройства '.$desc, $msl);
                break;
}
//----------------------- Настройка логики ответов
switch ($id) {
    case '24': //say('Принят id - '.$json['id'].' для устройства '.$desc, $msl);
               if ($json['state'] == 'Да') { say('Принят - Да от - '.$desc, $msl); } //callMethodSafe('NobodyHomeMode.activate');
               if ($json['state'] == 'Нет') { say('Принят - Нет от - '.$desc, $msl); }
               if ($json['state'] == 'Пофиг') { say('Принят - Пофиг от - '.$desc, $msl); }
        break;
    case '45': say('Принят id - '.$json['id'].' для устройства '.$desc, $msl);
               if ($json['state'] == 'Да') { say('Принят - Да от - '.$desc, $msl); }
               if ($json['state'] == 'Нет') { say('Принят - Нет от - '.$desc, $msl); }
               if ($json['state'] == 'Возможно') { say('Принят - Возможно от - '.$desc, $msl); }
        break;
    case '85': say('Принят id - '.$json['id'].' для устройства '.$desc, $msl);
               if ($json['state'] == 'Да') { say('Принят - Да от - '.$desc, $msl); }
               if ($json['state'] == 'Нет') { say('Принят - Нет от - '.$desc, $msl); }
               if ($json['state'] == 'Пофиг') { say('Принят - Пофиг от - '.$desc, $msl); }
        break;
    default: //say('Принят неизвесный id - '.$json['id'].' для устройства '.$desc, $msl);
        break;
}
//----------------------- данные
//{"alert":"Turn the lights off?","title":"Свет","negative":"Нет","positive":"Да","neutral":"Пофиг","sound":"false","id":24}');
//----------------------- Формируем ответ
//$array='{"noti":"Павлик дома", "title":"Ответ", "info":"Павлик журавлик", "vibrate":"true", "sound":"true", "light":"true", "id":85}';
$array = array(
	'noti' => $state,
	'title' => 'Ответ',
	'info' => 'Ответная реакция',
	'vibrate' => 'true',
	'sound' => 'true',
	'light' => 'true',
	'id' => $id,
);

$json = json_encode($array, true, JSON_UNESCAPED_UNICODE);
//Передаем в MQTT
    $topic = $name. "/comm/notification/create";
    mqttMob($topic, $json, 0, 0);
