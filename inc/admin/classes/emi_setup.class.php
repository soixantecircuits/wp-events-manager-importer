<?php class EMI_Setup extends EMI{

	function __construct() {
		parent::__construct();
		$this->checkEventManager();
	}

	function checkEventManager(){
		$events_manager_actived=plugin_active('events-manager/events-manager.php');
		(bool)($events_manager_actived);
		if ($events_manager_actived){
			$notice = null;
		}
		else {
			$notice =__("Event Manager Importer : Event Manager is not enabled. Please enable it before our plugin.","emi");
		}
		parent::set_notice($notice);
	}
}?>
