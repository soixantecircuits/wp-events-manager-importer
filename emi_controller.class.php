<?php
class EmiController{
	//Pages attributes
	protected $importPage;
	protected $mainMenu;
	protected $Manager;
	protected $Creator;

	//controller attributes
	protected $get_controller;
	protected $action_importviewer;
	protected $action_save;
	protected $EMI;

	function __construct(){
		$this->setValues();
		$this->Manager = new EMI_Manager();		
		add_action('admin_menu', array(&$this,'configureMenu'));
	}

	private function setValues(){
		$this->importPage="emi_import";
		$this->mainPage='edit.php?post_type=event';
		$this->get_controller="emi_action";
		$this->action_importviewer="emi_importviewer";
		$this->action_save="emi_save";
	}

	function configureMenu(){
		$import_page=add_submenu_page('edit.php?post_type=event', __('Emi Import',"emi"), __('Import',"emi"), 'activate_plugins', $this->importPage, array(&$this,"importPageController"));
		add_action('admin_print_styles-'.$import_page, 'emi_load_admin_scripts');
	}

	//CONTROLL
	function importPageController() 
	{
		if (!empty($_GET["emi_action"]))
		{
			switch($_GET["emi_action"])
			{
				case $this->action_importviewer:
					$this->import_viewer();
				break;
				case $this->action_save;
					$this->import_save();
				break;
				default :
					require_once "inc/admin/view/emi_upload.php";
				break;
			}
		}
		else {
			require_once "inc/admin/view/emi_upload.php";
		}
	}

	function createFormAction($action){
		return $this->mainPage."&page=".$this->importPage."&".$this->get_controller."=".$action;
	}

	private function redirect($location) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Status: 301 Moved Permanently");
		header("Location: ?post_type=event&page=".$location);
		header("Connection: close");
		exit;
	}

	private function import_viewer()
	{
		switch ($_FILES['file']['type'])
		{
			case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" :
				$this->import_xlsx();
			break;
			default:
				_e("Extension type not supported", "emi");
			break;
		}
	}

	private function import_xlsx()
	{
		require_once "inc/ressources/simplexlsx.class.php";
		$xlsx = new SimpleXLSX( $_FILES['file']['tmp_name'] );
		$location = $this->Manager->getLocationArray($xlsx, false);
		$events = $this->Manager->getEventArray($xlsx);
		require_once("inc/admin/view/emi_preview.php");
	}

	private function import_save(){
		ob_start();
		$Save_Manager = new EMI_Save_Manager();
		$saving= $Save_Manager->save_events($_POST["emi"],$_POST["emi-method"],true);
		ob_clean();
		require_once("inc/admin/view/emi_save.php");
	}

}

