<?php
	if($_GET["order"] != "" && isset($_GET["order"])){
		require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/admin/pbrf_order.php");
	}else{
		require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/admin/pbrf_orders.php");
	}
?>