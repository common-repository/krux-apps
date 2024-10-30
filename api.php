<?php

class WPKruxApi{

	function socialWidgetJson ( ) {
		if( isset($_GET["social_json"]) ){		
			global $wpdb;
			$config_table = $wpdb->prefix . "kx_widget_config";
			$prototype_table = $wpdb->prefix . "kx_widget_prototype";
			$sharing_opts_table = $wpdb->prefix . "kx_widget_sharing_opts";
			$configs = $wpdb->get_results("SELECT * FROM $config_table");
			$prototypes = $wpdb->get_results("SELECT * FROM $prototype_table");
			$sharingOptions = $wpdb->get_results("SELECT * FROM $sharing_opts_table");;
			$socialjson = $configs[0];
			$socialjson->pages = $prototypes[0];
			$socialjson->posts = $prototypes[1];
			$socialjson->sharing_opts = $sharingOptions;
			echo json_encode($socialjson);
		}
	}

	function updateConfigStatus ( ) {
		if( isset($_POST["config_status"]) ){
			global $wpdb;
			$newStatus = $_POST["config_status"];
			$newStatus = (int)$newStatus;
			$config_table = $wpdb->prefix . "kx_widget_config";
			$configs = $wpdb->get_results("SELECT * FROM $config_table");
			$configId = $configs[0]->id;
			$wpdb->query("UPDATE $config_table SET status=$newStatus WHERE id=$configId");
		}
	}

	function updateLocation ( ) {
		if( isset($_POST["location"]) ){
			global $wpdb;			
			$prototype_table = $wpdb->prefix . "kx_widget_prototype";
			$widget = $_POST["location"];
			$widgetId = $widget['id'];
			$status = $widget['status'];
			$status = (int)$status;
			if($status == 1){
				$status = 0;
			}else{
				$status = 1;
			}
			$wpdb->query("UPDATE $prototype_table SET status=$status WHERE id=$widgetId");
		}		
	}

	function updateFormat ( ) {
		if( isset($_POST["newFormat"]) ){
			global $wpdb;
			$newFormat = $_POST["newFormat"];
			$widget = $_POST["widgetData"];
			$widgetId = $widget['id'];
			$prototype_table = $wpdb->prefix . "kx_widget_prototype";			
			$wpdb->query("UPDATE $prototype_table SET format='$newFormat' WHERE id=$widgetId");
		} 
	}

	function updatePlacement ( ) {
		if( isset($_POST["newPlacement"]) ){
			global $wpdb;
			$placement = $_POST["newPlacement"];
			$widget = $_POST["widgetData"];
			$widgetId = $widget['id'];
			$prototype_table = $wpdb->prefix . "kx_widget_prototype";			
			$wpdb->query("UPDATE $prototype_table SET placement='$placement' WHERE id=$widgetId"); 
		} 
	}

	function updateSharingOptions ( ) {
		if( isset($_POST["sharingOptions"]) ){
			global $wpdb;
			$sharingOptions = $_POST["sharingOptions"];
			$sharing_opts_table = $wpdb->prefix . "kx_widget_sharing_opts";
			$wpdb->query("UPDATE $sharing_opts_table SET sharing_opts='$sharingOptions'");
		}
	}

	function isEnabled ( ) {
		global $wpdb;
		$config_table = $wpdb->prefix . "kx_widget_config";
		$results = $wpdb->get_results("SELECT * FROM $config_table");
		return $results[0]->status;
	}

	function postEnabled ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$prototypes = $wpdb->get_results("SELECT * FROM $table_name");
		return $prototypes[1]->status;		
	}

	function getPostConfig ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$prototypes = $wpdb->get_results("SELECT * FROM $table_name");
		return $prototypes[1];		
	}

	function getPageConfig ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$prototypes = $wpdb->get_results("SELECT * FROM $table_name");
		return $prototypes[0];			
	}

	function getPageFormat ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_prototype";
		$prototypes = $wpdb->get_results("SELECT * FROM $table_name");
		return $prototypes[0]->format;			
	}

	function getSharingOpts ( ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "kx_widget_sharing_opts";
		$sharingOpts = $wpdb->get_results("SELECT * FROM $table_name");
		return $sharingOpts[0]->sharing_opts;
	}


	public function __construct ( ) {
		$this->socialWidgetJson();
		$this->updateConfigStatus();
		$this->updateLocation();
		$this->updateFormat();
		$this->updatePlacement();
		$this->updateSharingOptions();
	}

}

?>