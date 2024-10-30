<?php

class WPKruxUnitTestService {

	function loadTestScripts ($hook) {
		global $kx_menu_page;
		$scripts = array("qunit", "unit-tests");
		$this->loadService->loadScripts($scripts, $hook, $kx_menu_page);	
	}

	function loadTestCss ($hook) {		
		global $kx_menu_page;	
		$this->loadService->loadStyle('qunit', $hook, $kx_menu_page);
	}

	function includeQUnit ( ) {		
		if (isset($_GET['qunit'])) {
			add_action("admin_enqueue_scripts", array($this, "loadTestScripts"));
			add_action("admin_enqueue_scripts", array($this, "loadTestCss"));
		} 
	}

	public function __construct ( ) {	
		$this->loadService = new WPKruxLoadService();
		$this->includeQUnit();
	}	

}

?>