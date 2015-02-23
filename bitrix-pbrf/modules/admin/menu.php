<?
IncludeModuleLangFile(__FILE__);
/** @global CUser $USER */
if ($USER->IsAdmin()){
	$menu = array(
		"parent_menu" => "global_menu_settings",
		"section" => "pbrf",
		"sort" => 1645,
		"text" => GetMessage("PBRF_MODULE_NAME"),
		"items_id" => "menu_pbrf",
		"items" => array(),
	);
	
	$menu["items"][] = array(
		"text" => GetMessage("PBRF_MODULE_ORDERS"),
		"url" => "pbrf_orders.php?lang=".LANGUAGE_ID,
	);
	$menu["items"][] = array(
		"text" => GetMessage("PBRF_MODULE_TEMPLATES"),
		"url" => "pbrf_templates.php?lang=".LANGUAGE_ID,
	);
	$menu["items"][] = array(
		"text" => GetMessage("PBRF_MODULE_SETTING"),
		"url" => "pbrf_setting.php?lang=".LANGUAGE_ID,
	);
	return $menu;
}else{
	return false;
}
?>