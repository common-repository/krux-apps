<?php
/*
	Module to load scripts and styles
*/
class WPKruxLoadService{

	// add css style to page
	function loadStyle ($file, $hook, $page) {
		if( $hook != $page )
			return;
		$keyStr = "krux_" . $file;
		$cssFilePath = KRUX_STYLES . $file . ".css";
		wp_register_style($keyStr, $cssFilePath);
		wp_enqueue_style($keyStr);
	}

	// add js file to page
	function loadScript ($file, $hook, $page) {
		if( $hook != $page )
			return;
		$keyStr = "krux_" . $file;
		$jsFilePath = KRUX_JS . $file . ".js";
		wp_register_script($keyStr, $jsFilePath);
		wp_enqueue_script($keyStr);		
	}

	// add js files to page
	function loadScripts ($files, $hook, $page) {
		foreach($files as $file){
			$this->loadScript($file, $hook, $page);
		}
	}

}

?>