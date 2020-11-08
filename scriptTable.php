<?php
include "Curl.php";
    $curl = new Curl($_POST['user'], $_POST['api'], $_POST['instance']);
    $json = $curl->getJson($_POST['request']);
    $obj = json_decode($json["json"], true);
    switch ($json["httpCode"]) {
        case 200:
            echo $curl->getTable($obj);
            break;
        case 400:
            echo "Neplatný požadavek";
            break;
        case 401:
            echo "Špatný uživatel nebo api klíč";
            break;
        case 404:
            echo "Špatná instance";
            break;
        default:
            echo "Response status code " . $json["httpCode"];
    }

