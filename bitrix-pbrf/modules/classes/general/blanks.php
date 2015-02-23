<?php

class CBlanks{
	const TABLE = "b_pbrf_blanks";

	public function getListBlanks(){
		global $DB;
		$html .= "<ul>";
		$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE ACTIVE = 1");
		while (is_array($ar = $rs->Fetch())){
			$html .= "<li>";
			$html .= "<a href='pbrf_templates.php?lang=" . LANGUAGE_ID . "&amp;slug=" . $ar["SLUG"] . "'>" . $ar["NAME"] . "</a>";
			$html .= "</li>";
		}
		$html .= "</ul>";
		return $html;
	}

	public function getBlank($slug){
		global $DB;
		$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE SLUG = '" . $slug . "'");
		$blank = array();
		while(is_array($ar = $rs->Fetch())){
			$blank = array("id" => $ar["ID"], "name" => $ar["NAME"], "slug" => $ar["SLUG"]);
		}

		return $blank;
	}

	public function getAllBlanks(){
		global $DB;
		$result = array();
		$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE ACTIVE = 1");
		while (is_array($ar = $rs->Fetch())){
			$result[] = $ar;
		}

		return $result;
	}

	public function getBlankID($id){
		global $DB;
		$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE ID = " . $id);
		$blank = array();
		while(is_array($ar = $rs->Fetch())){
			$blank = array("id" => $ar["ID"], "name" => $ar["NAME"], "slug" => $ar["SLUG"]);
		}

		return $blank;
	}
}