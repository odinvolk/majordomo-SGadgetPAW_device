<?php
//Остановить речь [логическое] //$this->setProperty("comm_tts_stop", true);

$preTopic = $this->getProperty("preTopic");
$nameTopic = $this->getProperty("namePAW");

    $topic = $nameTopic. "/comm/tts/stop";
    mqttMob($topic, true, 0, 0);

