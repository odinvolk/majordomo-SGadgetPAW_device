<?php
//Установите время подсветки [число] (сек) через (comm_display_timeOff)

$name = $this->getProperty("namePAW");

if (!isset($params['VALUE'])) { 
    $value = $this->getProperty('info_display_timeOff');
} else {
    $value = $params['VALUE'];
}
//Передаем в MQTT
    $topic = $name. "/comm/display/timeOff";
    mqttMob($topic, $value, 0, 0);
