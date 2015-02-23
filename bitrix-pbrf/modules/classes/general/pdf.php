<?php
class CPBRFPdf{
	const TABLE = "b_pbrf_pdf";

	public function getOrderPdf($order_id, $blank_id){
		global $DB;
		$rs = $DB->Query("SELECT * FROM " . self::TABLE . " WHERE BLANK_ID = " . $blank_id . " AND ORDER_ID = " . $order_id);
		$result = array();
		while (is_array($ar = $rs->Fetch())){
			$result[] = $ar;
		}

		if(empty($result)){
			return false;
		}else{
			return $result[0]["URL"];
		}
	}

	public function setUrlPdf($order_id, $blank_id, $url){
		global $DB;
		$DB->Query("DELETE FROM " . self::TABLE . " WHERE BLANK_ID = " . $blank_id . " AND ORDER_ID = " . $order_id);
		$DB->ADD(
			self::TABLE, 
			array(
				"URL" => $url,
				"ORDER_ID" => $order_id,
				"BLANK_ID" => $blank_id
		));

	}
}