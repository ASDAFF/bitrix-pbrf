<?

Class pbrf extends CModule{

	var $MODULE_ID = "pbrf";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function pbrf(){
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		else
		{
			$this->MODULE_VERSION = PBRF_VERSION;
			$this->MODULE_VERSION_DATE = PBRF_VERSION_DATE;
		}

		$this->MODULE_NAME = "Почтовый Бланк РФ";
		$this->MODULE_DESCRIPTION = "Печать бланков Почты России с помощью pbrf.ru";
	}

	function InstallFiles($arParams = array()){
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);
		return true;
	}

	function UnInstallFiles(){
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		return true;
	}

	function InstallDB(){
		global $DB, $APPLICATION;
		$this->errors = false;
		// Database tables creation
		if (!$DB->Query("SELECT 'x' FROM b_pbrf_blanks WHERE 1=0", true)){
			$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/install/db/".strtolower($DB->type)."/install.sql");
		}

		if ($this->errors !== false){
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}else{
			$this->InstallTasks();
			RegisterModuleDependences("main", "OnAdminInformerInsertItems", "pbrf", "CTemplates", "OnAdminInformerInsertItems");
			CModule::IncludeModule("pbrf");
		}
		return true;
	}

	function UninstallDB(){
		global $DB, $APPLICATION;
		$this->errors = false;
		UnRegisterModuleDependences("main", "OnAdminInformerInsertItems", "pbrf", "CTemplates", "OnAdminInformerInsertItems");
		$this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pbrf/install/db/".strtolower($DB->type)."/uninstall.sql");
		UnRegisterModule("pbrf");
		if ($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		return true;
	}

	function DoInstall(){
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallFiles();
		$this->InstallDB();
		RegisterModule("pbrf");
		$APPLICATION->IncludeAdminFile("Установка модуля pbrf", $DOCUMENT_ROOT."/bitrix/modules/pbrf/install/step.php");
	}

	function DoUninstall(){
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallFiles();
		$this->UninstallDB();
		UnRegisterModule("pbrf");
		$APPLICATION->IncludeAdminFile("Деинсталляция модуля pbrf", $DOCUMENT_ROOT."/bitrix/modules/pbrf/install/unstep.php");
	}
}
?>