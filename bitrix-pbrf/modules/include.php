<?php
global $DB;
global $DBType;
CModule::AddAutoloadClasses("pbrf", array(
	"CPBRFTemplates" => "classes/general/templates.php",
	"CSetting" => "classes/general/setting.php",
	"CBlanks" => "classes/general/blanks.php",
	"CAPIPBRF" => "classes/general/api_pbrf.php",
	"CPBRFPdf" => "classes/general/pdf.php",
	"CF116" => "classes/general/f116.php",
	"CF112" => "classes/general/f112.php",
	"CF113" => "classes/general/f113.php",
	"CF113F117" => "classes/general/f113f117.php"
));

if(IsModuleInstalled("sale")){
	CModule::AddAutoloadClasses("sale", array(
		"CAllSaleStatus" => "general/status.php",
		"CSaleOrderPropsValue" => $DBType."/order_props_values.php",
		"CSaleLocation" => $DBType."/location.php",
	));
}
?>