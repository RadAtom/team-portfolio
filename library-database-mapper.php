<?php
require_once('database-team-portfolio-member.php'); 
require_once('database-team-portfolio-members-projects.php'); 
require_once('database-team-portfolio-members-skills.php');
require_once('database-team-portfolio-members-images.php');
require_once('database-team-portfolio-project.php');
require_once('database-team-portfolio-projects-photos.php');
require_once('database-team-portfolio-projects-skills.php');
require_once('database-team-portfolio-projects-images.php');
require_once('database-team-portfolio-skill.php');
require_once('database-team-portfolio-skills-images.php');
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

    /*functions for member related stuff*/
    public function getAllMembers(){
        
    }

    public function getMember($memberID){
        
    }

    public function getMemberSkills($memberID){

    }

    public function getMemberProjects($memberID){
        
    }

    public function getMemberImages($memberID){
        
    }

    /*functions for skills related stuff*/
    public function getAllSkills(){

    }

    public function getSkill($skillID){

    }

    public function getSkillProjects($skillID){

    }

    public function getSkillMembers($skillID){

    }

    public function getSkillImages($skillID){

    }

    /*functions for project related stuff*/
    public function getAllProjects(){

    }

    public function getProject($projectID){

    }

    public function getProjectSkills($projectID){

    }

    public function getProjectMembers($projectID){
        
    }

    public function getProjectImages($projectID){
        
    }
}


function team_portfolio_database_mapper_initialize(){

}

function team_portfolio_database_mapper_wordpress_hooks(){
	//this function is going to make sure to call any of the functions in the database that needs to handle updating and transfering
}
?>