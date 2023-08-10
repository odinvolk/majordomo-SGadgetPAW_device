<?php
//$desc = $this->description;
$name = $this->getProperty("namePAW");
//Удалить все уведомления [логическое]
//$this->setProperty("comm_notification_delete", true);

//Добавляем трансляцию в MQTT
//if ($mqtt_st)
//{
    $topic = $name. "/comm/notification/delete";
    mqttMob($topic, true, 0, 0);
//}
