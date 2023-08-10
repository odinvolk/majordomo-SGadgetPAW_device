<?php
//На основной экран (работает только 1) /comm/other/home
$name = $this->getProperty("namePAW");

    $topic = $name. "/comm/other/home";
    mqttMob($topic, true, 0, 0);
