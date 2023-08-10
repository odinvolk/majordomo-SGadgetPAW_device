<?php
//Отправить текст в речь для устройства [строка] через (comm_tts_request)
if (!isset($params['VALUE'])) { 
    $value = $this->getProperty('comm_tts_request');//    return;
} else {
    $value = $params['VALUE'];
}
//Передаем в MQTT
//$preTopic = $this->getProperty("preTopic");
$nameTopic = $this->getProperty("namePAW");
    $topic = $nameTopic. "/comm/tts/request";
    mqttMob($topic, $value, 0, 0);

//PAW/redmi10/comm/tts/request	dfe
//PAW/redmi10/info/tts/status	start
//PAW/redmi10/info/tts/status	done