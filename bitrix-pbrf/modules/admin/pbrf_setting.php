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
$aTabs = array(
	array(
		"DIV" => "setting",
		"TAB" => GetMessage("PBRF_SETTING_TAB"),
		"ICON" => "main_user_edit",
		"TITLE" => GetMessage("PBRF_SETTING_TAB_TITLE"),
	)
);
$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);

if($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["save"]) || isset($_POST["apply"])) && check_bitrix_sessid()){
	if($_POST["pbrf_login"] != ""){
		CSetting::setOption("login", $_POST["pbrf_login"]);
		$pbrf_login = $_POST["pbrf_login"];
	}
	if($_POST["pbrf_token"] != ""){
		CSetting::setOption("token", $_POST["pbrf_token"]);
		$pbrf_token = $_POST["pbrf_token"];
	}
}else{
	$pbrf_login = CSetting::getOption("login");
	$pbrf_token = CSetting::getOption("token");
}


?>

<form method="POST" action="pbrf_setting.php?lang=<?= LANGUAGE_ID ?><?= $_GET["return_url"] ? "&amp;return_url=".urlencode($_GET["return_url"]) : "" ?>" enctype="multipart/form-data" name="editform">

<?php
$tabControl->Begin();
$tabControl->BeginNextTab();
?>

	<tr>
		<td width="40%">
			<label for="pbrf_login"><?= GetMessage("PBRF_LOGIN_TITLE"); ?>:</label>
		</td>
		<td width="60%">
			<input id="pbrf_login" type="text" name="pbrf_login" value="<?= $pbrf_login; ?>">
		</td>
	</tr>
	<tr>
		<td width="40%">
			<label for="pbrf_token"><?= GetMessage("PBRF_TOKEN_TITLE"); ?>:</label>
		</td>
		<td width="60%">
			<input id="pbrf_token" type="text" name="pbrf_token" size="40" value="<?= $pbrf_token; ?>">
		</td>
	</tr>

<?php
$tabControl->Buttons(array(
	"back_url" => $_GET["return_url"] ? $_GET["return_url"] : "pbrf_setting.php?lang=".LANGUAGE_ID,
));

?>

<?= bitrix_sessid_post(); ?>
<input type="hidden" name="debug" value="<?= htmlspecialcharsbx($_REQUEST["debug"]) ?>">
<input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
<?php $tabControl->End(); ?>
</form>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>