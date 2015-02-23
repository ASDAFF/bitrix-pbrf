<?php
class CF113{

	public function getPDF($data, $templates, $sum_numeric){
		//токен пользователя
		$token = CSetting::getOption("token");
		$login = CSetting::getOption("login");
		$api_pbrf = new CAPIPBRF($token);

		$from = explode(" ", iconv("windows-1251", "utf-8", $data["fio"]));
		$from_surname = $from_name = "";
		if(isset($from[0])) $from_surname = $from[0];
		if(isset($from[1])) $from_name = $from[1];
		if(isset($from[2])) $from_name .= " " . $from[2];

		if($templates["to_region"] != "") $to_region = $templates["to_region"] . ", ";

		$from_adress = explode(", ", iconv("windows-1251", "utf-8", $data["address"]));
		$from_country = explode(", ", iconv("windows-1251", "utf-8", $data["country"]));

		$from_region = $from_street = $from_city = $from_build = "";
		if(isset($from_country[1])) $from_region = $from_country[1];
		if(isset($from_country[0])) $from_city = $from_country[0];

		if(isset($from_adress[0])) $from_street = $from_adress[0];
		if(isset($from_adress[1])) $from_build = $from_adress[1];
		if(isset($from_adress[2])) $from_build .= ", " . $from_adress[2];
		if(isset($from_adress[3])) $from_build .= ", " . $from_adress[3];

		$data = array(
			"from_surname" => $from_surname,
			"from_name" => $from_name,
			"from_city" => $from_city,
			"from_region" => $from_region,
			"from_street" => $from_street,
			"from_build" => $from_build,
			"from_zip" => iconv("windows-1251", "utf-8", $data["zip"]),
			"whom_name" => iconv("windows-1251", "utf-8", $templates["to_surname"]),
			"whom_city" => iconv("windows-1251", "utf-8", $to_region . $templates["to_city"]),
			"whom_street" => iconv("windows-1251", "utf-8", $templates["to_street"] . ", " . $templates["to_build"]),
			"whom_zip" => iconv("windows-1251", "utf-8", $templates["zip"]),
			"inn" => iconv("windows-1251", "utf-8", $templates["inn"]),
			"kor_account" => iconv("windows-1251", "utf-8", $templates["kor_account"]),
			"current_account" => iconv("windows-1251", "utf-8", $templates["current_account"]),
			"bik" => iconv("windows-1251", "utf-8", $templates["bik"]),
			"bank_name" => iconv("windows-1251", "utf-8", $templates["bank_name"]),
			"sum_num" => iconv("windows-1251", "utf-8", $sum_numeric)
		);

		$pdf = $api_pbrf->getBlank("pdf", "F113", $data, $login);

		return $pdf;
	}
}