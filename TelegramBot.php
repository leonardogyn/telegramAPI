<?php

class TelegramBot {

    protected $host;
    protected $port;
    protected $apiUrl;
    protected $inited = FALSE;
    public $botId;
    public $botUsername;
    protected $botToken;
    protected $netDelay = 1;
    protected $netTimeout = 10;
    protected $netConnectTimeout = 5;

    public function __construct($token) {
        $options = array(
            'host' => 'api.telegram.org',
            'port' => 443,
        );

        $this->host = $host = $options['host'];
        $this->port = $port = $options['port'];
        $this->botToken = $token;

        $proto_part = ($port == 443 ? 'https' : 'http');
        $port_part = ($port == 443 || $port == 80) ? '' : ':' . $port;

        $this->apiUrl = "{$proto_part}://{$host}{$port_part}/bot{$token}/";

        if ($this->inited) {
            return TRUE;
        }

        $this->handle = curl_init();

        /* Caso utilize proxy na rede
          curl_setopt($this->handle, CURLOPT_URL, 'http://localhost/');
          curl_setopt($this->handle, CURLOPT_PROXY,'http://proxy.meusite.com.br:2003');
          curl_exec($this->handle); */

        $response = $this->request('getMe');
        if (!$response['ok']) {
            $bot = $response['result'];
            $this->botId = $bot['id'];
            $this->botUsername = $bot['username'];

            $this->inited = true;
        }
    }

    public function onUpdateReceived($message) {
        //Processando mensagens
        if (empty($message)) {
            echo utf8_decode("Mensagem automática quando o acesso for via navegador.<br />O telegram irá responder por aqui, passando o parâmetro: mensagem");
            die;
        }
        $message = $message['message'];
        $message_id = $message['message_id'];
        $chat_id = $message['chat']['id'];
        if (isset($message['text'])) {
            // Recebendo o texto da mensagem
            $text = str_replace("/", "", trim(strtolower($message['text'])));

            $msgBoasVindas = "Pressione um dos botões abaixo para realizar operações com a lâmpada:";
			
			if($text=="ligar") {
				$text = 1;
			} else if($text=="desligar") {
				$text = 0;
			} else {
				$text = 2;
			}

            switch ($text) {

				case 0:
					$this->request("sendMessage", array('chat_id' => $chat_id, "text" => 'Luz desligada', 'reply_markup' => array(
									'keyboard' => array(array("Ligar", "Desligar")),
									'one_time_keyboard' => true,
									'resize_keyboard' => true)));
					break;

				case 1:
					$this->request("sendMessage", array('chat_id' => $chat_id, "text" => 'Luz ligada', 'reply_markup' => array(
									'keyboard' => array(array("Ligar", "Desligar")),
									'one_time_keyboard' => true,
									'resize_keyboard' => true)));
					break;

                case 2:

                    $this->request("sendMessage", array('chat_id' => $chat_id, "text" => 'Escolha um dos botões abaixo:', 'reply_markup' => array(
                            'keyboard' => array(array("Ligar", "Desligar")),
                            'one_time_keyboard' => true,
                            'resize_keyboard' => true)));
            }
        } else {
            $this->request("sendMessage", array('chat_id' => $chat_id, "text" => 'Ops... Não entendi!'));
        }
    }

    public function request($method, $params = array()) {

        /* Caso utilize proxy na rede
          curl_setopt($this->handle, CURLOPT_URL, 'http://localhost/');
          curl_setopt($this->handle, CURLOPT_PROXY,'http://proxy.meusite.com.br:2003');
          curl_exec($this->handle); */

        $options = array(
            'http_method' => 'GET',
            'timeout' => $this->netTimeout,
        );

        $url = $this->apiUrl . $method;

        $params_arr = array();
        foreach ($params as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
            $params_arr[] = urlencode($key) . '=' . urlencode($val);
        }
        $query_string = implode('&', $params_arr);

        $url .= ($query_string ? '?' . $query_string : '');
        curl_setopt($this->handle, CURLOPT_HTTPGET, true);

        $connect_timeout = $this->netConnectTimeout;
        $timeout = $options['timeout'] ? : $this->netTimeout;

        curl_setopt($this->handle, CURLOPT_URL, $url);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
        curl_setopt($this->handle, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, false);

        $response_str = curl_exec($this->handle);

        $errno = curl_errno($this->handle);
        $http_code = intval(curl_getinfo($this->handle, CURLINFO_HTTP_CODE));

        if ($http_code == 401) {
            throw new Exception('Invalid access token provided');
        } else if ($http_code >= 500 || $errno) {
            sleep($this->netDelay);
            if ($this->netDelay < 30) {
                $this->netDelay *= 2;
            }
        }

        $response = json_decode($response_str, true);

        return $response;
    }

    private function registrarLog($updates, $tipo) {
        if (file_exists('log/log' . $tipo . ' - ' . date('Y_m_d') . '.txt')) {
            $arquivo = fopen('log/log' . $tipo . ' - ' . date('Y_m_d') . '.txt', 'a+');
        } else {
            $arquivo = fopen('log/log' . $tipo . ' - ' . date('Y_m_d') . '.txt', 'w');
        }
        if ($arquivo) {
            $mensagem = date('H:i:s') . ' - ' . json_encode($updates);
            fwrite($arquivo, $mensagem);
        }
        fclose($arquivo);
    }

}
