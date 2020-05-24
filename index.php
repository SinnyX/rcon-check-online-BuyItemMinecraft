<?php

/**
 * @copyright 2020 SinnyX
 * @author SinnyX
 * @link https://www.facebook.com/PanunanTH
 */

require('rcon.php');
require('query.php');

// Setup
#ถ้าจะทำแบบ Bungeecord ต้องรับค่ามาจาก Ajax เช่น Survival
#จากนั้นก็ไปดึงข้อมูลจาก database โดยใช้ WHERE query ข้อมูลออกมาแทนข้างล่าง

$host = '127.0.0.1';
$rconport = 25575;
$queryport = 45421;
$password = '@123465';
$timeout = 3;

$player = 'SinnyX';
$command = 'gm c [player]@:say Hello World [player]@:say [player] หล่อมาก@:say Success!!';

$server = new Query($host, $queryport, $timeout);

use Thedudeguy\Rcon;

$rcon = new Rcon($host, $rconport, $password, $timeout);

if ($server->connect()) {
    $info = $server->get_info();
    if (in_array($player, $info['players'])) {
        if (strpos($command, '[player]') !== false) {
            $command = str_replace('[player]', $player, $command, $command);
        }
        if (strpos($command, '@:') !== false) {
            $multiple = explode("@:", $command);
            for ($i = 0; $i < count($multiple); $i++) {
                if ($rcon->connect()) {
                    $rcon->sendCommand($multiple[$i]);
                } else {
                    echo 'เชื่อมต่อ Rcon ไม่สำเร็จ !';
                }
            }
            if ($i == count($multiple)) {
                echo 'ส่งหลายคำสั่งสำเร็จ !!!';
            }
        } else {
            if ($rcon->connect()) {
                $rcon->sendCommand($command);
                echo 'ส่งคำสั่งเดียวสำเร็จ !!!';
            } else {
                echo 'เชื่อมต่อ Rcon ไม่สำเร็จ !';
            }
        }
    } else {
        echo 'ไม่พบผู้เล่นในเซิฟเวอร์';
    }
} else {
    echo 'เชื่อมต่อ Query ไม่สำเร็จ !';
}