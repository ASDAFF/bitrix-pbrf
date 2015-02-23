<?php
class CSetting{
	private $table = "b_pbrf_options";

	public function setOption($key, $value){
		global $DB;
		$rs = $DB->Query("SELECT ID, PARAM_KEY, PARAM_VALUE FROM b_pbrf_options WHERE PARAM_KEY = '" . $key . "'");
		$id = "";
		while (is_array($ar = $rs->Fetch())){
			$id = $ar["ID"];
		}

		if($id != "") $DB->Update("b_pbrf_options", array("PARAM_KEY" => "'" . $key . "'", "PARAM_VALUE" => "'" . $value . "'"), "WHERE ID = " . $id);
	}

	public function getOption($key){
		global $DB;
		$rs = $DB->Query("SELECT PARAM_KEY, PARAM_VALUE FROM b_pbrf_options WHERE PARAM_KEY = '" . $key . "'");

		$result = "";
		while (is_array($ar = $rs->Fetch())){
			$result = $ar["PARAM_VALUE"];
		}

		return $result;
	}
}
?>