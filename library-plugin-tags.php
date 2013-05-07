<?php
/*
This file is responsible for handling all of the following:
1. wordpress hooks for plugin tags
2. initizlizer functions for plugin tage
3. static functions to be called to display the plugin tags
4. a class to handle all of the logic of the tags
5. a class to handle the gnereation of the tags
*/
class TeamPortfolioTagsLogic {
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

class TeamPortfolioTagsGeneration {
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

function team_portfolio_plugin_tags_initialize(){

}

function team_portfolio_plugin_tags_wordpress_hooks(){

}
?>