<?php
//$message = $params['VALUE']; // Принимаем данные

$desc = $this->description;
$name=$this->getProperty('namePAW');
$registerEvent_st = $this->getProperty('registerEvent_status');
$registerProperties_st = $this->getProperty('registerProperties_status');

// получаем такой json массив
// {"provider":"NETWORK","latitude":"59.8891361","longitude":"30.4508703","speed":"0.0","unixTime":"1679920005729","date":"2023-03-27","time":"15:26:45"}
$json = json_decode($params['VALUE'], true);
//----------------------- Записываем данные (если нужно)
 if ($registerProperties_st)
 {
     $this->setProperty('provider', $json['provider']);   // sg($ot.'.v',$ver);
     $this->setProperty('latitude', $json['latitude']);
     $this->setProperty('longitude', $json['longitude']);
     $this->setProperty('speed', $json['speed']);
     $this->setProperty('unixTime', $json['unixTime']);
     $this->setProperty('date', $json['date']);
     $this->setProperty('time', $json['time']);
 }
//Добавляем трансляцию в registerEvent (если нужно)
 if ($registerEvent_st)
 {
     $array = array('provider'=>$json['provider'],'latitude'=>$json['latitude'],'longitude'=>$json['longitude'],'speed'=>$json['speed'],'date'=>$json['time'],'time'=>$json['time'],'desc'=>$desc);
     registerEvent($name.'/info/location', $array);
 }
