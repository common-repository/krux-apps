<?php
/*
Plugin Name: Krux Apps
Plugin URI: http://wordpress.org/extend/plugins/krux-apps/
Description: The Krux Apps plugin will help you seamlessly integrate social tools on your site, and will help you gain valuable insight on your social data.
Version: 1.1.4
Author: Krux
Author URI: http://www.krux.com
*/

$kruxPluginBasePath = plugins_url(basename( dirname(__FILE__)));
define( "KRUX_PLUGIN_VIEWS", dirname( __FILE__ ) . "/views/" );
define( "KRUX_IMAGES", $kruxPluginBasePath . "/images/" );
define( "KRUX_STYLES", $kruxPluginBasePath . "/styles/" );
define( "KRUX_JS", $kruxPluginBasePath . "/js/" );
include( dirname( __FILE__ ) . "/load_service.php" );
include( dirname( __FILE__ ) . "/init_db_service.php" );
include( dirname( __FILE__ ) . "/api.php" );
include( dirname( __FILE__ ) . "/tag_service.php" );
include( dirname( __FILE__ ) . "/unit_test_service.php" );
include( dirname( __FILE__ ) . "/social_service.php" );


class WPKruxApps {
	function adminPage ( ) {
		include(KRUX_PLUGIN_VIEWS . "admin_page.php");
	}

	function addMenu ( ) {
		global $kx_menu_page;		
		$page_title = "Krux Apps";
		$menu_title = "Krux Apps";
		$capability = "administrator";
		$menu_slug = "krux_apps";
		$function = array($this, "adminPage");
		$icon_url = KRUX_IMAGES . "krux_icon.png";
		$kx_menu_page = add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url ); 		
		$this->tagService->putTagOnPage('socialtag', 'admin');	
	}

	// add css style to admin page
	function adminStyle ($hook) {
		global $kx_menu_page;
		$this->loadService->loadStyle('krux_apps', $hook, $kx_menu_page);
	}

	// add js to admin page
	function adminScript ($hook) {
		global $kx_menu_page;
		$scripts = array("underscore", "backbone", "kwp", "routes", "widget_configuration");
		$this->loadService->loadScripts($scripts, $hook, $kx_menu_page);
	}

	// create admin menu nav item and corresponding page; add js and styles
	function renderAdminPage ( ) {
		add_action("admin_menu", array($this, "addMenu"));		
		add_action("admin_enqueue_scripts", array($this, "adminStyle"));
		add_action("admin_enqueue_scripts", array($this, "adminScript"));		
	}

	function renderConfidRequest ( ) {
		if( isset($_POST["confid"]) ){
			add_option("kx_confid", $_POST["confid"]);
		}
	}

	function renderPubidRequest ( ) {
		if( isset($_POST["pubid"]) ){
			add_option("kx_pubid", $_POST["pubid"]);
		}
	}

	public function __construct ( ) {		
		$this->loadService = new WPKruxLoadService();
		$this->tagService = new WPKruxTagService();
		$this->initDbService = new WPKruxInitDbService();
		$this->unitTestService = new WPKruxUnitTestService();
		$this->renderAdminPage();
		$this->renderConfidRequest();
		$this->renderPubidRequest();
		$this->socialService = new WPKruxSocialService();
	}
}

$wpKruxApps = new WPKruxApps();
?>