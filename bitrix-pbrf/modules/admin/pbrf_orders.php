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

$token = CSetting::getOption("token");
if($token == ""){
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	echo CAdminMessage::ShowMessage(array(
		"DETAILS" => GetMessage('PBRF_ERROR_TOKEN'),
	));
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
	die();
}

$APPLICATION->SetTitle(GetMessage("PBRF_TITLE_PAGE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

//получаем список заказов
if(!IsModuleInstalled("sale")){
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
	echo CAdminMessage::ShowMessage(array(
		"DETAILS" => GetMessage('PBRF_ERROR_SALE'),
	));
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
	die();
}else{
	$orders = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"));
?>
	<table class="adm-list-table">
		<thead>
			<tr class="adm-list-table-header">
				<td class="adm-list-table-cell" width="20%"><div class="adm-list-table-cell-inner"><?= GetMessage('PBRF_TABLE_NUMBER'); ?></div></td>
				<td class="adm-list-table-cell"><div class="adm-list-table-cell-inner"><?= GetMessage('PBRF_TABLE_DATE_CREATE'); ?></div></td>
				<td class="adm-list-table-cell"><div class="adm-list-table-cell-inner"><?= GetMessage('PBRF_TABLE_STATUS'); ?></div></td>
				<td class="adm-list-table-cell" width="15%"><div class="adm-list-table-cell-inner"><?= GetMessage('PBRF_TABLE_SUM'); ?></div></td>
			</tr>
		</thead>
		<tbody>
<?php while(is_array($order = $orders->Fetch())) :  ?>	
		<?php $status = CAllSaleStatus::GetLangByID($order["STATUS_ID"], LANGUAGE_ID); ?>
			<tr class="adm-list-table-row">
				<td class="adm-list-table-cell"><a style="display:block" href="pbrf_orders.php?lang=<?= LANGUAGE_ID ?><?= $_GET["return_url"] ? "&amp;return_url=".urlencode($_GET["return_url"]) : "" ?>&amp;order=<?= $order["ID"]; ?>"><?= GetMessage("PBRF_TITLE_NUMBER") . $order["ID"]; ?></a></td>
				<td class="adm-list-table-cell"><?= $order["DATE_STATUS"]; ?></td>
				<td class="adm-list-table-cell"><?= $status["NAME"]; ?></td>
				<td class="adm-list-table-cell"><?= $order["PRICE"] . " " . $order["CURRENCY"]; ?></td>
			</tr>
<?php endwhile; ?>
		</tbody>
	</table>
<?php
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>