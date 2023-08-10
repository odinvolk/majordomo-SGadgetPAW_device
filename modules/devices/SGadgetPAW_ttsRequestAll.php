<?php
// Сообщение для устройства голосовое all_devices_tts_request (PAW/all_devices/tts/request)

if (!isset($params['VALUE'])) { 
    $value = $this->getProperty('all_devices_tts_request');
} else {
    $value = $params['VALUE'];
}
//Передаем в MQTT
    $topic = "PAW/all_devices/tts/request";
    mqttMob($topic, $value, 0, 0);
