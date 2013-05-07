<?php
/*
This file is responsible for handling all of the following:
1. wordpress hooks for admin pages
2. initizlizer functions for admin pages
3. static functions to be called to display the admin pages
4. a class to handle all of the logic of the admin pages
5. a class to handle the gnereation of the admin pages
*/
class TeamPortfolioAdminLogic {
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

class TeamPortfolioAdminPages {
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


function team_portfolio_adamin_pages_initialize(){

}

function team_portfolio_adamin_pages_wordpress_hooks(){

}
?>