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
					require_once "view/emi_upload.php";
				break;
			}
		}
		else {
			require_once "view/emi_upload.php";
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
		$file_path="";
		$dropfile=$_POST["dropfile"];
		if (empty($dropfile["path"])){
			$file_path = $_FILES['emi_file']['tmp_name'];
			$file_type=$_FILES['emi_file']['type'];
		}

		else if (empty($_FILES['emi_file']['tmp_name'])){
			$file_path = $dropfile["path"];
			$file_type=$dropfile["type"];
		}
		
		if(empty($file_path)){ 
			_e("Empty File");
			return false;
		}

		switch ($file_type)
		{
			case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" :
				$this->import_xlsx($file_path);
				return true;
			break;
			case "text/csv" :
				$this->import_csv($file_path);
				return true;
			break;
			default:
				_e("Extension type not supported", "emi");
				return false;
			break;
		}
		return false;
	}

	private function import_xlsx($file_path)
	{
		require_once(dirname(__FILE__)."/../simplexlsx.class.php");
		$xlsx = new SimpleXLSX($file_path);
		$location = $this->Manager->getLocationArray($xlsx, isset($_POST['geocoding']) ? $_POST['geocoding'] : null);
		$events = $this->Manager->getEventArray($xlsx);
		require_once("view/emi_preview.php");
	}

	private function import_csv($file_path)
	{
		// Set PHP's timezone to the blog's TZ, parse the CSV file that way.
		date_default_timezone_set(get_option('timezone_string'));
		$parsed = $this->Manager->parseCsv($file_path);
		$location = $parsed['location'];
		$events = $parsed['events'];
		// If the current INI setting is too low (such as its default of 1000),
		// it's likely that a large CSV import will get truncated when POST'ed.
		// This is because, for each parsed row, the plugin makes 21 POST vars.
		// See "view/emi_preview_hidden_form.php" for the form's values on this.
		// We need to warn the user about this, so we first need to detect the
		// value of the setting, then count the number of events (rows) that we
		// parsed and issue a warning if we determine that the CSV file will be
		// truncated in the user's environment.
		$max = (int) ini_get('max_input_vars');
		$vals_per_row = 21;
		$num = count($events); // Each event becomes a row.
		// Less than or equals to because we need to account for $_POST['emi-method']
		// and this is also why we do math with plus 1 and minus 1 in the warning message.
		if (($max / $vals_per_row) <= $num) {
			$warning_msg  = "<strong>The file you are importing contains more data than we can safely process in your environment.</strong>\n";
			$warning_msg .= "This is because your server is configured to accept only a limited number of variables";
			$warning_msg .= " ($max, as defined in your <a href=\"http://www.php.net/manual/en/info.configuration.php#ini.max-input-vars\">PHP's <code>max_input_vars</code> configuration directive</a>).\n";
			$warning_msg .= "However, for the amount of data you're submitting, this value needs to be a minimum of ";
			$warning_msg .= $num * $vals_per_row + 1 . ' for all the data to fit. If you cannot <a href="http://www.php.net/manual/en/configuration.changes.modes.php">change this value yourself</a>,';
			$warning_msg .= ' you can alternatively import files with a maximum of ';
			$warning_msg .= floor($max / $vals_per_row) - 1 . ' rows in them, one at a time.';
			print "<div class=\"error\"><p>$warning_msg</p></div>";
		}
		require_once("view/emi_preview.php");
	}

	private function import_save(){
		if (!isset($_POST['emi-method'])) {
			print '<div class="error"><p>There was a problem saving your content. Please go back and try again.</p></div>';
			return false;
		}
		$Save_Manager = new EMI_Save_Manager();
		ob_start();
			$saving= $Save_Manager->save_events($_POST["emi"],$_POST["emi-method"],true);
		ob_clean();
		require_once("view/emi_save.php");
	}
}