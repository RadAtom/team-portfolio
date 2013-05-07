<?php
/*
This file is responsible for handling all of the following:
1. skeleton for wordpress hooks
2. skeleton for initizlizer functions
3. a class to handle any settings updating/creating for the plugin
*/
class TeamPortfolioSettings {
    var $pluginPath;
    var $pluginUrl;

    private static $instance = NULL;

    private function __construct()
    {
        // Set Plugin Path
        $this->pluginPath = dirname(__FILE__);
    
        // Set Plugin URL
        $this->pluginUrl = WP_PLUGIN_URL . '/team-portfolio';
    }

    public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new myDBH();
		}
		return self::$instance;
	}
}


function team_portfolio_plugin_settings_initialize(){
	//currently this is unused but is left for future convienence
}

function team_portfolio_plugin_settings_wordpress_hooks(){
	//currently this is unused but is left for future convienence
}
?>