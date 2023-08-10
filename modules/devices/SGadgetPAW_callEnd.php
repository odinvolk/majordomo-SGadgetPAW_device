<?php
$name = $this->getProperty("namePAW");
//Закончить вызов (повесить трубку) пока не понятно

    $topic = $name. "/comm/call/end";
    mqttMob($topic, true, 0, 0);
