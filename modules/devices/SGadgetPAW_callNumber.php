<?php
//Позвонить по номеру [номер] (comm_call_number)

$name = $this->getProperty("namePAW");

if (!isset($params['VALUE'])) { 
    $value = $this->getProperty('comm_call_number'); //    return;
} else {
    $value = $params['VALUE'];
}
//Передаем в MQTT
    $topic = $name. "/comm/call/number";
    mqttMob($topic, $value, 0, 0);

// PAW/RMX3430/info/call/status	connection
// PAW/RMX3430/info/call/status	disconnection
// PAW/RMX3430/info/call/status	ringing