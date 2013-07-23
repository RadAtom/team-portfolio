<?php

class PortfolioBackend{
	public function __construct(){
		add_menu_page('Team Portfolio settings', 'Team Portfolio Settings', 'manage_options',   
        'team_portfolio_settings', array($this, 'output_description_settings'));

        add_submenu_page('team_portfolio_settings', 'Portfolio Overview Settings', 'Portfolio Overview', 'manage_options', 'portfolio-overview', array($this, 'output_portfolio_overview_settings'));

        add_submenu_page('team_portfolio_settings', 'Projects Overview Settings', 'Projects Overview', 'manage_options', 'projects-overview', array($this, 'output_project_overview_settings'));

        add_submenu_page('team_portfolio_settings', 'Skills Overview Settings', 'Skills Overview', 'manage_options', 'skills-overview', array($this, 'output_skills_overview_settings'));

        add_submenu_page('team_portfolio_settings', 'Members Overview Settings', 'Members Overview', 'manage_options', 'member-overview', array($this, 'output_member_overview_settings'));
	}

	public function output_description_settings(){
		//need quick description of portfolio
		//need quick description of skills
		//need quick description of members
		//need quick description of projects
		if (!current_user_can('manage_options')) {  
			wp_die('You do not have sufficient permissions to access this page.');  
		}
	}

	public function output_portfolio_overview_settings(){
		//need to get the members, skills, and projects for overview
		if (!current_user_can('manage_options')) {  
			wp_die('You do not have sufficient permissions to access this page.');  
		}
	}

	public function output_project_overview_settings(){
		//need to get the projects for overview
		if (!current_user_can('manage_options')) {  
			wp_die('You do not have sufficient permissions to access this page.');  
		}
	}

	public function output_skills_overview_settings(){
		//need 
		if (!current_user_can('manage_options')) {  
			wp_die('You do not have sufficient permissions to access this page.');  
		}
	}

	public function output_member_overview_settings(){
		if (!current_user_can('manage_options')) {  
			wp_die('You do not have sufficient permissions to access this page.');  
		}
	}
}

$portfolioBackend = new PortfolioBackend;