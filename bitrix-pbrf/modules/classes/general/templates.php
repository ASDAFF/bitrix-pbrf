<?php
class CPBRFTemplates{
	const TABLE = "b_pbrf_templates";

	public function setTemplates($slug, $data){
		global $DB;

		//переписываем значения из cp1251 в utf8
		$content =array();
		foreach ($data as $key => $val) {
			if(!in_array($key, array("save", "apply", "lang", "debug", "tabControl_active_tab")) ){
				$content[$key] = iconv("windows-1251", "utf-8", $val);
			}
		}

		$rs = $DB->Query("SELECT * FROM " . CBlanks::TABLE . " WHERE SLUG = '" . $slug . "'");
		$blank_id = 0;
		while(is_array($ar = $rs->Fetch())){
			$blank_id = $ar["ID"];
		}
		if($blank_id != 0){
			$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE BLANK_ID = " . $blank_id);
			$templates_id = null;
			while(is_array($ar = $rs->Fetch())){
				$templates_id = $ar["ID"];
			}

			if($templates_id != null){
				$DB->Query("DELETE FROM " . self::TABLE . " WHERE ID = " . $templates_id);
			}

			$DB->ADD(self::TABLE, array("BLANK_ID" => $blank_id, "CONTENT" => json_encode($content)));
		}
	}

	public function getTemplates($slug){
		global $DB;

		$content = array();
		$rs = $DB->Query("SELECT * FROM " . CBlanks::TABLE . " WHERE SLUG = '" . $slug . "'");
		$blank_id = 0;
		while(is_array($ar = $rs->Fetch())){
			$blank_id = $ar["ID"];
		}
		if($blank_id != 0){
			$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE BLANK_ID = " . $blank_id);
			while(is_array($ar = $rs->Fetch())){
				$temp = json_decode($ar["CONTENT"]);
			}
		}

		foreach($temp as $key => $val){
			$content[$key] = iconv("utf-8", "windows-1251", $val);
		}

		return $content;
	}


	public function OnAdminInformerInsertItems(){
		$CDNAIParams = array(
			"TITLE" => GetMessage("Шаблоны для печати"),
			"COLOR" => "green",
			"HTML" => "Hello",
			"FOOTER" => "<a href='/test/index'>Testing footer</a>",
			"ALERT" => true
		);

		CAdminInformer::AddItem($CDNAIParams);
	}
}
?>