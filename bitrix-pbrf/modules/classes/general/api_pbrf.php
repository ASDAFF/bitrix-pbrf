<?php

Class CAPIPBRF{

	public $domain = "http://pbrf.ru/";
	protected $access;

	public function __construct($access){
		$this->setAccess($access);
	}

	public function setAccess($access){
		$this->access = $access;
	}

	public function getBlank($type = "pdf", $blank = "", $data = array(), $login = ""){
		//функция к которой делаем запрос
		$url = $this->domain . $type . "." . $blank;

		//print_r($data);

		//Подготовка данных для передачи
		$post = array(
			"access_token" => $this->access,
			"data" => json_encode($data),
			"login" => $login
		); 

		//*//Инициализируем библиотеку
		$ch = curl_init();
		//Устанавливаем адрес куда будем отправлять запрос
		curl_setopt($ch, CURLOPT_URL, $url);
		//Указываем, что полученные данные не выводить сразу на экран
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		//Устанавливаем метод запроса POST
		curl_setopt($ch, CURLOPT_POST, true);
		//Передаем подготовленные данные
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		//Передаем полученный ответ переменной
		$res = curl_exec($ch);
		curl_close($ch);
		//print_r($res);print("test");

		//проверка на ошибки и вывод данных
		return $this->getResult($res);//*/
	}

	public function getResult($res){
		$temp = json_decode($res);
		if(isset($temp->error)) return $temp;

		return $res;
	}
}