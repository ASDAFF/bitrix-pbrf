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

$APPLICATION->SetTitle(GetMessage("PBRF_TITLE_PAGE") . $_GET["order"]);

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
	$id_order = $_GET["order"];
	$aTabs = array(
		array(
			"DIV" => "order",
			"TAB" => GetMessage("PBRF_ORDER_TAB"),
			"ICON" => "main_user_edit",
			"TITLE" => GetMessage("PBRF_ORDER_TAB_TITLE") . $id_order
		),
		array(
			"DIV" => "blank",
			"TAB" => GetMessage("PBRF_ORDER_TAB2"),
			"ICON" => "main_user_edit",
			"TITLE" => GetMessage("PBRF_ORDER_TAB2_TITLE")
		)
	);
	$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);
?>
	<form method="POST" action="pbrf_orders.php?lang=<?= LANGUAGE_ID ?><?= $_GET["return_url"] ? "&amp;return_url=".urlencode($_GET["return_url"]) : "" ?>&amp;order=<?= $_GET["order"]; ?>" enctype="multipart/form-data" name="editform">
<?php
	$tabControl->Begin();
	$tabControl->BeginNextTab();
	//получаем данные по заказу
	$order = CSaleOrder::GetByID($id_order);
	//получаем данные по пользователю
	$user = CUser::GetByID($order["USER_ID"]);

	$props = CSaleOrderPropsValue::GetOrderProps($id_order);

	//получаем данные по заказу
	$fio = $zip = $country = $address = "";
	while(is_array($pr = $props->Fetch())){
		//отбираем данные по ФИО, индексу и адресу
		if($pr["CODE"] == "FIO") $fio = $pr["VALUE"];
		if($pr["CODE"] == "ZIP") $zip = $pr["VALUE"];
		if($pr["CODE"] == "LOCATION") $country = $pr["VALUE"];
		if($pr["CODE"] == "ADDRESS") $address = $pr["VALUE"];
	}

	//формируем местополежение
	if($country != ""){
		$location = CSaleLocation::GetByID($country, LANGUAGE_ID);
		$country = "";
		if($location["CITY_NAME_LANG"] != "") $country .= $location["CITY_NAME_LANG"] . ", ";
		if($location["REGION_NAME_LANG"] != "") $country .= $location["REGION_NAME_LANG"] . ", ";
		if($location["COUNTRY_NAME_LANG"] != "") $country .= $location["COUNTRY_NAME_LANG"];
	}
	if(isset($_GET["blank"])){
		$blank = CBlanks::getBlankID($_GET["blank"]);
		if($blank["slug"] == "f116" || $blank["slug"] == "f113f117"){
			$templates = CPBRFTemplates::getTemplates($blank["slug"]);
			$data = array("fio" => $fio, "country" => $country, "address" => $address, "zip" => $zip);
			if($blank["slug"] == "f116") $api_result = CF116::getPDF($data, $templates, $order["PRICE"], $order["PRICE"]);
			if($blank["slug"] == "f113f117") $api_result = CF113F117::getPDF($data, $templates, $order["PRICE"], $order["PRICE"]);
			if(isset($api_result->error)){
				echo CAdminMessage::ShowMessage(array(
					"DETAILS" => GetMessage('PBRF_ERROR_API') . $api_result->message,
				));
			}else{
				if($api_result == null) {
					echo CAdminMessage::ShowMessage(array(
						"DETAILS" => GetMessage('PBRF_ERROR_UNKNOWN'),
					));
				}else{
					CPBRFPdf::setUrlPdf($_GET["order"], $_GET["blank"], $api_result);
				}
			}
		}
		if($blank["slug"] == "f112" || $blank["slug"] == "f113"){
			$templates = CPBRFTemplates::getTemplates($blank["slug"]);
			$data = array("fio" => $fio, "country" => $country, "address" => $address, "zip" => $zip);
			if($blank["slug"] == "f112") $api_result = CF112::getPDF($data, $templates, $order["PRICE"]);
			if($blank["slug"] == "f113") $api_result = CF113::getPDF($data, $templates, $order["PRICE"]);
			if(isset($api_result->error)){
				echo CAdminMessage::ShowMessage(array(
					"DETAILS" => GetMessage('PBRF_ERROR_API') . $api_result->message,
				));
			}else{
				if($api_result == null) {
					echo CAdminMessage::ShowMessage(array(
						"DETAILS" => GetMessage('PBRF_ERROR_UNKNOWN'),
					));
				}else{
					CPBRFPdf::setUrlPdf($_GET["order"], $_GET["blank"], $api_result);
				}
			}
		}

	}
	if($address != ""){
		$address = $address . ", " . $country;
	}else{
		$address = $country;
	}
?>
	<tr><td colspan="2"><h3><?= GetMessage('PBRF_RECIPIENT'); ?></h3></td></tr>
	<tr>
		<td width="40%">
			<label for="fio"><?= GetMessage("PBRF_FIO"); ?>:</label>
		</td>
		<td width="60%">
			<input id="fio" type="text" name="fio" value="<?= $fio; ?>" size="40">
		</td>
	</tr>
	<tr>
		<td width="40%">
			<label for="address"><?= GetMessage("PBRF_ADDRESS"); ?>:</label>
		</td>
		<td width="60%">
			<input id="address" type="text" name="address" value="<?= $address; ?>" size="100">
		</td>
	</tr>
	<tr>
		<td width="40%">
			<label for="zip"><?= GetMessage("PBRF_ZIP"); ?>:</label>
		</td>
		<td width="60%">
			<input id="zip" type="text" name="zip" value="<?= $zip; ?>" size="15">
		</td>
	</tr>
<?php 
	$tabControl->BeginNextTab();
	$blanks = CBlanks::getAllBlanks();
?>
	<table class="adm-list-table">
		<thead>
			<tr class="adm-list-table-header">
				<td class="adm-list-table-cell">
					<div class="adm-list-table-cell-inner"><?= GetMessage("PBRF_NAME_BLANK"); ?></div>
				</td>
				<td class="adm-list-table-cell">
					<div class="adm-list-table-cell-inner"><?= GetMessage("PBRF_URL_BLANK"); ?></div>
				</td>
				<td class="adm-list-table-cell">
					<div class="adm-list-table-cell-inner"><?= GetMessage("PBRF_ACTION"); ?></div>
				</td>
			</tr>
		</thead>
		<tbody>
<?php
	foreach($blanks as $blank) :
?>
			<tr class="adm-list-table-row">
				<td width="20%" class="adm-list-table-cell"><?= $blank["NAME"]; ?></td>
				<td width="60%" class="adm-list-table-cell">
					<?php if(CPBRFPdf::getOrderPdf($_GET["order"], $blank["ID"])) : ?>
						<a href="<?= CPBRFPdf::getOrderPdf($_GET["order"], $blank["ID"]); ?>" target="_blank"><?= CPBRFPdf::getOrderPdf($_GET["order"], $blank["ID"]); ?></a>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
				<td width="20%" class="adm-list-table-cell">
					<a href="pbrf_orders.php?lang=<?= LANGUAGE_ID ?><?= $_GET["return_url"] ? "&amp;return_url=".urlencode($_GET["return_url"]) : "" ?>&amp;order=<?= $_GET["order"]; ?>&amp;blank=<?= $blank["ID"]; ?>"><?= GetMessage('PBRF_EDIT'); ?></a>
				</td>
			</tr>
<?php
	endforeach;
?>	
		</tbody>
	</table>
<?php
	$tabControl->End(); 
?>
</form>
<?php
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>