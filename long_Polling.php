<?php
set_time_limit(0);
ini_set('max_execution_time', 0);

require_once 'TelegramBot.php';

define('BOT_TOKEN','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

class long_Polling
{
	protected $updatesOffset = FALSE;

	public function longpoll($bot)
	{
		$params = array(
			'limit' => 1,
			'timeout' => 5,
		);

		if ($this->updatesOffset) {
			$params['offset'] = $this->updatesOffset;
		}

		$response = $bot->request('getUpdates', $params);

		if ($response['ok'])
		{
			$updates = $response['result'];
			if (is_array($updates))
			{
				foreach ($updates as $update)
				{
					$this->updatesOffset = $update['update_id'] + 1;
					$bot->onUpdateReceived($update);
				}
			}
		}
		$this->longpoll($bot);
	}
}

$bot = new TelegramBot(BOT_TOKEN);
$longPolling = new long_Polling();
$longPolling->longpoll($bot);