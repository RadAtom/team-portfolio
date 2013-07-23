<?php

class PortfolioTags{
	public function __construct(){

	}

	public function portfolio_overview($atts){
		/*
		STILL TO DO:
		get the chosen projects populated
		get the chosen skills populated
		get the chosen members populated
		get a quick blurb about the portfolio
		*/


		$html[] = '<div class="row" id="portfolio_overview">';

		//base portfolio overview
		$html[] = '<div class="small-12 columns">';
		$html[] = '<h3>Our Portfolio</h3>';
		$html[] = '</div>';


		//projects stuff
		$projects = array();
		$projectGridSize = count($projects)
		if($projectGridSize){
			$html[] = '<div class="small-12 columns">';
			$html[] = '<h4>Our Projects</h4>';
			//list out the chosen projects
		
			$html[] = '<ul class="large-block-grid'. $projectGridSize .'">';
			foreach ($projects as $project) {
				$html[] = '<li>';
				//image of the project
				//name of the project
				//url of the project
				//first words of project?
				$html[] = '</li>';
			}
			$html[] = '</ul>';
			$html[] = '</div>';
		}
		

		$members = array();
		$memberGridSize = count($members);
		if($memberGridSize){
			//skills then members
			$html[] = '<div class="large-6 columns">';
			$html[] = '<h4>Our Members</h4>';
			//list out the chosen members
			$html[] = '<ul class="large-block-grid'. $projectGridSize .'">';
			foreach ($members as $member) {
				$html[] = '<li>';
				//image of the member
				//name of the member
				//url of the member
				$html[] = '</li>';
			}
			$html[] = '</div>';
		}
		
		$skills = array();
		$skillsGridSize = count($skills);
		if($skillsGridSize){
			$html[] = '<div class="large-6 columns">';
			$html[] = '<h4>Our Skills</h4>';
			//list out the chosen skills
			
			foreach ($skills as $skill) {
				$html[] = '<li>';
				//image of the skill
				//name of the skill
				//url of the skill
				$html[] = '</li>';
			}
			$html[] = '</div>';
		}
		

		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}

	public function skills_overview($atts){
		/*
		STILL TO DO
		
		*/
		$html[] = '<div class="row" id="skills_overview">';
		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}

	public function projects_overview($atts){
		/*
		STILL TO DO
		
		*/
		$html[] = '<div class="row" id="projects_overview">';
		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}

	public function members_overview($atts){
		/*
		STILL TO DO
		
		*/
		$html[] = '<div class="row" id="members_overview">';
		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}
}