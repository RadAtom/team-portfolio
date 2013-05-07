<?php
/*
This file is responsible for handling all of the following:
1. wordpress hooks for custom database
2. initizlizer functions for custom database
3. a class to handle any database interaction
*/
class TeamPortfolioDatabase {
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


function team_portfolio_database_mapper_initialize(){

}

function team_portfolio_database_mapper_wordpress_hooks(){
	//this function is going to make sure to call any of the functions in the database that needs to handle updating and transfering
}
?>