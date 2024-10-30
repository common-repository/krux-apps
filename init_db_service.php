<?php
	
class WPKruxInitDbService{

	function createConfigTable ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_config";
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  status boolean NOT NULL,
		  pages_prototype_id mediumint(9) NOT NULL,
		  posts_prototype_id mediumint(9) NOT NULL,
		  UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql);		
	}

	function createWidgetPrototypeTable ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  status boolean NOT NULL,
		  format tinytext NOT NULL,
		  placement tinytext NOT NULL,
		  UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql);			
	}

	function createSharingOptionsTable ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_sharing_opts";
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			sharing_opts text NULL,
			UNIQUE KEY id (id)
		);";
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql);
	}

	function initWidgetPrototypes ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$prototypes = $wpdb->get_results("SELECT * FROM $table_name");
		if(count($prototypes) != 2){
			$wpdb->query("DELETE FROM $table_name");
			$status = false;
			$format = 'big_button';
			$placement = 'top';
			$wpdb->insert( 
				$table_name, 
				array( 'status' => $status, 'format' => $format, 'placement' => $placement ) 
			);
			$wpdb->insert( 
				$table_name, 
				array( 'status' => $status, 'format' => $format, 'placement' => $placement ) 
			);						
		}
	}

	function getWidgetPrototypes ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$prototypes = $wpdb->get_results("SELECT * FROM $table_name");
		return $prototypes;		
	}

	function initWidgetConfig ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_config";
		$configs = $wpdb->get_results("SELECT * FROM $table_name");
		if(count($configs) > 1){
			$wpdb->query("DELETE FROM $table_name");
		}
		if(count($configs) == 0){
			$prototypes = $this->getWidgetPrototypes();
			$pagesId = $prototypes[0]->id;
			$postsId = $prototypes[1]->id;
			$wpdb->insert(
				$table_name,
				array("status" => false, "pages_prototype_id" => $pagesId, "posts_prototype_id" => $postsId)
			);
		}
	}

	function initSharingOptions ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_sharing_opts";
		$sharing_opts = $wpdb->get_results("SELECT * FROM $table_name");
		if(count($sharing_opts) == 0){
			$wpdb->insert(
				$table_name,
				array("sharing_opts" => "facebook, twitter, google")
			);
		}
	}

	public function __construct ( ) {
		$this->createConfigTable();
		$this->createWidgetPrototypeTable();
		$this->createSharingOptionsTable();
		$this->initWidgetPrototypes();
		$this->initWidgetConfig();
		$this->initSharingOptions();
	}

}

?>