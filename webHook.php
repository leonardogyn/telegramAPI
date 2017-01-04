<?php
require_once 'TelegramBot.php';

//bot
define('BOT_TOKEN', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('BOT_WEBHOOK', 'https://url_your_server/file_response.php');

$response = file_get_contents('php://input');

$update = json_decode($response,true);

$bot = new TelegramBot(BOT_TOKEN);

$bot->registrarLog($response,'Consulta');
$bot->onUpdateReceived(serialize($update));