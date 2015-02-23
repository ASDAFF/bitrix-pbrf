<?php
define("ADMIN_MODULE_NAME", "pbrf");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

/** @global CMain $APPLICATION */
/** @global CUser $USER */

//проверка является ли пользователь админом
if (!$USER->IsAdmin())
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
//проверяем подключение модуля
if (!CModule::IncludeModule("pbrf"))
	$strError = GetMessage("MODULE_INCLUDE_ERROR");

//если есть ошибка выводим ее и прекращаем выполнение скрипта
if ($strError != ""){
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	echo CAdminMessage::ShowMessage(array(
		"DETAILS" => $strError,
	));
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
	die();
}

$APPLICATION->SetTitle(GetMessage("PBRF_TITLE_PAGE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

if($_GET["slug"] == ""){
	$aTabs = array(
		array(
			"DIV" => "templates",
			"TAB" => GetMessage("PBRF_TEMPLATES_TAB"),
			"ICON" => "main_user_edit",
			"TITLE" => GetMessage("PBRF_TEMPLATES_TAB_TITLE"),
		)
	);
	$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);
	$tabControl->Begin();
	$tabControl->BeginNextTab();
?>
	<h3><?= GetMessage("TITLE_LIST_BLANKS"); ?></h3>
<?php
	//выводим список доступных бланков
	print(CBlanks::getListBlanks());
?>

	<input type="hidden" name="debug" value="<?= htmlspecialcharsbx($_REQUEST["debug"]) ?>">
	<input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">

<?php 
	$tabControl->End();
}else{
	$blank = CBlanks::getBlank($_GET["slug"]);
	if(!empty($blank)) :

?>
		<form method="POST" action="pbrf_templates.php?lang=<?= LANGUAGE_ID ?><?= $_GET["return_url"] ? "&amp;return_url=".urlencode($_GET["return_url"]) : "" ?><?= $_GET["slug"] ? "&amp;slug=" . urlencode($_GET["slug"]) : "";?>" enctype="multipart/form-data" name="editform">
<?php	
		$aTabs = array(
			array(
				"DIV" => $blank["slug"],
				"TAB" => $blank["name"],
				"ICON" => "main_user_edit",
				"TITLE" =>  $blank["name"],
			)
		);
		$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);
		$tabControl->Begin();
		$tabControl->BeginNextTab();

		$data = array();
		if($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["save"]) || isset($_POST["apply"]))){
			CPBRFTemplates::setTemplates($_GET["slug"], $_POST);
			$data = $_POST;
		}else{
			$data = CPBRFTemplates::getTemplates($_GET["slug"]);
		}
		$test = (iconv("windows-1251", "utf-8", "Печаль"));
		$test2 = iconv("utf-8", "windows-1251", $test);

		//подключаем шаблон нужного бланка
		$GLOBALS["blank"] = $data;
		require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/blanks/" . $_GET["slug"] . ".php");
?>
		
<?php
		$tabControl->Buttons(array(
			"back_url" => $_GET["return_url"] ? $_GET["return_url"] : "pbrf_templates.php?lang=".LANGUAGE_ID,
		));
?>

		<input type="hidden" name="debug" value="<?= htmlspecialcharsbx($_REQUEST["debug"]) ?>">
		<input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
<?php
		$tabControl->End();
?>
		</form>
<?php
	endif;
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>