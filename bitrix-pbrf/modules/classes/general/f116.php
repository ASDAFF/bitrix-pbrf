<?php
class CF116{

	public function getPDF($data, $templates, $declared_value, $cod_amount){

		//токен пользователя
		$token = CSetting::getOption("token");
		$login = CSetting::getOption("login");
		$api_pbrf = new CAPIPBRF($token);
		$data = array(
			"from_surname" => iconv("windows-1251", "utf-8", $templates["from_surname"]),
			"from_country" => iconv("windows-1251", "utf-8", $templates["from_country"]),
			"from_city" => iconv("windows-1251", "utf-8", $templates["from_city"]),
			"from_zip" => iconv("windows-1251", "utf-8", $templates["from_zip"]),
			"whom" => iconv("windows-1251", "utf-8", $data["fio"]),
			"whom_country" => iconv("windows-1251", "utf-8", $data["address"]),
			"whom_city" => iconv("windows-1251", "utf-8", $data["country"]),
			"whom_street" => "",
			"whom_zip" => iconv("windows-1251", "utf-8", $data["zip"]),
			"document" => iconv("windows-1251", "utf-8", $templates["document"]),
			"document_serial" => iconv("windows-1251", "utf-8", $templates["document_serial"]),
			"document_number" => iconv("windows-1251", "utf-8", $templates["document_number"]),
			"document_day" => iconv("windows-1251", "utf-8", $templates["document_day"]),
			"document_year" => iconv("windows-1251", "utf-8", $templates["document_year"]),
			"document_issued_by" => iconv("windows-1251", "utf-8", $templates["document_issued_by"]),
			"declared_value" => iconv("windows-1251", "utf-8", $declared_value),
			"COD_amount" => iconv("windows-1251", "utf-8", $cod_amount),
		);
		
		$pdf = $api_pbrf->getBlank("pdf", "F116", $data, $login);
		
		return $pdf;
	}
}