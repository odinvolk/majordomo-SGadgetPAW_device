<?php
//Вывести устройство из спящего режима [логическое] 0/1 (true/false) PAW/redmi10/info/display/status PAW/redmi10/comm/display/status

if ($params['NEW_VALUE'] == $params['OLD_VALUE']) return;
$state = $params['NEW_VALUE'];

switch ($state) {
    case 'false': $state = '0'; break;   // $this->callMethod('turnOff'); break; // Off
    case 'true': $state = '1'; break;   //$this->callMethod('turnOn'); break; // On
    case 0: break;
    case 1: break;
    case 'clicked': $state = '1'; break;
     default: $state = '0'; break;
}
$this->setProperty('display_status', $state);
$name = $this->getProperty("namePAW");

    $topic = $name. "/comm/display/toWake";
    mqttMob($topic, $state, 0, 0);
