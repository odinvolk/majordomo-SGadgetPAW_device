<?php
//Тип подсветки автоматический или ручной [логический] (auto manual)
$name = $this->getProperty("namePAW");

if (!isset($params['VALUE'])) {
    $value = $this->getProperty('info_display_mode');
    if ($value <> "manual") { $value = "manual";
    } else { $value = "auto";
    }
} else {
    $value = $params['VALUE'];
}

    $topic = $name. "/comm/display/mode";
    mqttMob($topic, $value, 0, 0);
