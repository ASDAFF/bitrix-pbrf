<?php
class CF113F117{

	public function getPDF($data, $templates, $declared_value, $cod_amount){

		//токен пользователя
		$token = CSetting::getOption("token");
		$login = CSetting::getOption("login");
		$api_pbrf = new CAPIPBRF($token);

		$from = explode(" ", iconv("windows-1251", "utf-8", $templates["from_surname"]));
		$from_surname = $from_patronymic = "";
		if(isset($from[0])) $from_surname = $from[0];
		if(isset($from[1])) $from_surname .= " " . $from[1];
		if(isset($from[2])) $from_patronymic = $from[2];

		$whom = explode(" ", iconv("windows-1251", "utf-8", $data["fio"]));
		$whom_surname = $whom_patronymic = "";
		if(isset($whom[0])) $whom_surname = $whom[0];
		if(isset($whom[1])) $whom_surname .= " " . $whom[1];
		if(isset($whom[2])) $whom_patronymic = $whom[2];

		$data = array(
			"from_surname" => $from_surname,
			"from_patronymic" => $from_patronymic,
			"from_city" => iconv("windows-1251", "utf-8", $templates["from_city"]),
			"from_street" => iconv("windows-1251", "utf-8", $templates["from_street"]),
			"from_zip" => iconv("windows-1251", "utf-8", $templates["from_zip"]),
			"whom_surname" => $whom_surname,
			"whom_patronymic" =>  $whom_patronymic,
			"whom_street" => iconv("windows-1251", "utf-8", $data["address"]),
			"whom_city" => iconv("windows-1251", "utf-8", $data["country"]),
			"whom_zip" => iconv("windows-1251", "utf-8", $data["zip"]),
			"document" => iconv("windows-1251", "utf-8", $templates["document"]),
			"document_serial" => iconv("windows-1251", "utf-8", $templates["document_serial"]),
			"document_number" => iconv("windows-1251", "utf-8", $templates["document_number"]),
			"document_day" => iconv("windows-1251", "utf-8", $templates["document_day"]),
			"document_year" => iconv("windows-1251", "utf-8", $templates["document_year"]),
			"document_issued_by" => iconv("windows-1251", "utf-8", $templates["document_issued_by"]),
			"declared_value_num" => iconv("windows-1251", "utf-8", $declared_value),
			"COD_amount_num" => iconv("windows-1251", "utf-8", $cod_amount),
		);

		$pdf = $api_pbrf->getBlank("pdf", "F113F117", $data, $login);
		
		return $pdf;
	}
}