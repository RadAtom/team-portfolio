<?php
require_once('helper-plugin-tags-html.php'); 
require_once('helper-plugin-tags-logic.php'); 
/*
This file is responsible for handling all of the following:
1. wordpress hooks for plugin tags
2. initizlizer functions for plugin tage
3. static functions to be called to display the plugin tags
4. a class to handle all of the logic of the tags
5. a class to handle the gnereation of the tags
*/
class TeamPortfolioTags {
    var $pluginPath;
    var $pluginUrl;

    private static $instance = NULL;

    private function __construct()
    {
        // Set Plugin Path
        $this->pluginPath = dirname(__FILE__);
    
        // Set Plugin URL
        $this->pluginUrl = WP_PLUGIN_URL . '/team-portfolio';

        //add in all the shortcode hooks mmmaaannnnggg!
        add_shortcode('Dribbble', array($this, 'shortcode'));  

        // Add shortcode support for widgets
        add_filter('widget_text', 'do_shortcode');
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new TeamPortfolioTags();
        }
        return self::$instance;
    }

    /*
    function for overview of all the portfolios
    */
    public function portfolios_overview($atts, $content = null ){
    }

    /*
    function for overview of a specific portfolio
    */
    public function portfolio_overview($atts, $content = null ){
        extract( shortcode_atts( array(
            'portfolioid' => 0
        ), $atts ) );
    }

    /*
    function for a specific portfolio
    */
    public function portfolio($atts, $content = null ){
        extract( shortcode_atts( array(
            'portfolioid' => 0
        ), $atts ) );
    }

    /*
    function for overview of all the portfolios
    */
    public function members_overview($atts, $content = null ){
        

    /*
    function for overview of a specific portfolio
    */
    public function member_overview($atts, $content = null ){
        extract( shortcode_atts( array(
            'memberid' => 0
        ), $atts ) );
    }

    /*
    function for a specific portfolio
    */
    public function member($atts, $content = null ){
        extract( shortcode_atts( array(
            'memberid' => 0
        ), $atts ) );
    }

    /*
    function for overview of all the portfolios
    */
    public function skills_overview($atts, $content = null ){
    }

    /*
    function for overview of a specific portfolio
    */
    public function skill_overview($atts, $content = null ){
        extract( shortcode_atts( array(
            'skillid' => 0
        ), $atts ) );
    }

    /*
    function for a specific portfolio
    */
    public function skill($atts, $content = null ){
        extract( shortcode_atts( array(
            'skillid' => 0
        ), $atts ) );
    }
}



function team_portfolio_plugin_tags_initialize(){

}

function team_portfolio_plugin_tags_wordpress_hooks(){

}

//if you want to get the functions that are involved for theme function calls
//take a look at the helper-theme-plugin-tags.php

?>