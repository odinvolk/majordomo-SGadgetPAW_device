<?php
//$message = $params['VALUE']; // Принимаем данные

$desc = $this->description;
$name = $this->getProperty('namePAW');
/* 
* получаем json
* {"provider":"NETWORK","latitude":"59.8891361","longitude":"30.4508703","speed":"0.0","unixTime":"1679920005729","date":"2023-03-27","time":"15:26:45"}
*/
$json = json_decode($params['VALUE'], true);

//----------------------- Записываем данные (если нужно)
 if ($this->getProperty('registerProperties_status'))
 {
     $this->setProperty('provider', $json['provider']);   // sg($ot.'.v',$ver);
     $this->setProperty('latitude', $json['latitude']);
     $this->setProperty('longitude', $json['longitude']);
     $this->setProperty('speed', $json['speed']);
     $this->setProperty('unixTime', $json['unixTime']);
     $this->setProperty('date', $json['date']);
     $this->setProperty('time', $json['time']);
 }
//----------------------- Вычесляем и Записываем данные Адреса (если нужно)
 if ($this->getProperty('registerAddress_status'))
 {
/* Запрашиваем адрес по координатам GPS
* https://nominatim.openstreetmap.org/reverse?format=json&lat=59.9488781&lon=30.4822867
* ------------------------ получаем ответ в json
* {"place_id":182354640,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. http://osm.org/copyright","osm_type":"way","osm_id":23775575,"lat":"59.94788975","lon":"30.483103451012475","class":"building","type":"apartments","place_rank":30,"importance":9.99999999995449e-06,"addresstype":"building","name":"",
* 
* "display_name":"30 к2, проспект Энтузиастов, округ Пороховые, Санкт-Петербург, Северо-Западный федеральный округ, 195298, Россия",
* 
* "address":{"house_number":"30 к2","road":"проспект Энтузиастов","city_district":"округ Пороховые","city":"Санкт-Петербург","ISO3166-2-lvl15":"RU-SPE","state":"Санкт-Петербург","ISO3166-2-lvl4":"RU-SPE","region":"Северо-Западный федеральный округ","postcode":"195298","country":"Россия","country_code":"ru"},
* 
* "boundingbox":["59.9469038","59.9488750","30.4819948","30.4842128"]}
*/
$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=".$json['latitude']."&lon=".$json['longitude'];
$content = getURL($url,0);
$cont = json_decode($content, true);
//------------------------------------------------------------------------------------------------------------------------------
//------------30 к2, проспект Энтузиастов, округ Пороховые, Санкт-Петербург, Северо-Западный федеральный округ, 195279, Россия
     $this->setProperty('address_all', $cont['display_name']);  // Весь адрес строкой
/* 
* $cont2 = json_encode($content, true);
*      $this->setProperty('address_json', $cont2['address']);      // Весь адрес в json
* 
* echo "<br>Номер дома " .$cont['address']['house_number'];     // 30 к2
* echo "<br>Улица " .$cont['address']['road'];                  // проспект Энтузиастов
* echo "<br>Район " .$cont['address']['city_district'];         // округ Пороховые
* echo "<br>Город " .$cont['address']['city'];                  // Санкт-Петербург
* echo "<br>Регион " .$cont['address']['region'];               // Северо-Западный федеральный округ
* echo "<br>Почтовый индекс " .$cont['address']['postcode'];    // 195279
* echo "<br>Страна " .$cont['address']['country'];              // Россия
* echo "<br>Код города " .$cont['address']['country_code'];     // ru
* --------------------------------------------------------------------------------------------------------------------------
*    Передаем в MQTT PAW/RMX3430/info/location/json
*/
        $vol = '{"display_name": "'.$cont["display_name"].'"}'; // {"ph": "20 часов 20 минут","level": 3,"info": "Сообщение от Алисы"}
        $topic = $name. "/info/location/display_name";
    mqttMob($topic, $vol, 0, 0);

    //"address":{"house_number":"30 к2","road":"проспект Энтузиастов","city_district":"округ Пороховые","city":"Санкт-Петербург","ISO3166-2-lvl15":"RU-SPE","state":"Санкт-Петербург","ISO3166-2-lvl4":"RU-SPE","region":"Северо-Западный федеральный округ","postcode":"195298","country":"Россия","country_code":"ru"},
    $array2 = array('house_number'=>$cont['address']['house_number'],
                   'road'=>$cont['address']['road'],
                   'city_district'=>$cont['address']['city_district'],
                   'city'=>$cont['address']['city'],
                   'region'=>$cont['address']['region'],
                   'postcode'=>$cont['address']['postcode'],
                   'country'=>$cont['address']['country']);
        //$vol2 = '{"address": '.json_encode($array2, JSON_UNESCAPED_UNICODE).'}'; //true, 
        $vol2 = json_encode($array2, JSON_UNESCAPED_UNICODE); //true, 
        $topic2 = $name. "/info/location/address";
    mqttMob($topic2, $vol2, 0, 0);
 }
//---------------------- Добавляем трансляцию в registerEvent (если нужно)
 if ($this->getProperty('registerEvent_status'))
 {
    $array = array('provider'=>$json['provider'],'latitude'=>$json['latitude'],'longitude'=>$json['longitude'],'speed'=>$json['speed'],'date'=>$json['time'],'time'=>$json['time'],'desc'=>$desc);
     registerEvent($name.'/info/location', $array);
 }
