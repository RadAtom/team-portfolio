<?php
require_once('finderhelper.php');
require_once('portfoliohtmlgenerator.php');

class PortfolioTags{
	public function __construct(){
		add_shortcode( 'team-portfolio', array($this,'portfolio_overview') );
		add_shortcode( 'team-portfolio-members', array($this,'members_overview') );
		add_shortcode( 'team-portfolio-projects', array($this,'projects_overview') );
		add_shortcode( 'team-portfolio-skills', array($this,'skills_overview') );
		add_shortcode( 'team-portfolio-project-overview', array($this,'project_overview') );
		add_shortcode( 'team-portfolio-skill-overview', array($this,'skill_overview') );
		add_shortcode( 'team-portfolio-member-overview', array($this,'member_overview') );
	}

	public function portfolio_overview($atts){
		return PortfolioHTMLGenerator::overviewString();
	}

	public function skills_overview($atts){
		return PortfolioHTMLGenerator::skillsOverviewString();
	}

	public function projects_overview($atts){
		return PortfolioHTMLGenerator::projectsOverviewString();
	}

	public function members_overview($atts){
		return PortfolioHTMLGenerator::membersOverviewString();
	}

	public function member_overview($atts){
		extract( shortcode_atts( array(
			'id' => 0,
			'membername' => "",
		), $atts, 'team-portfolio-member-overview' ) );
		$html =  array();
		$html[] = '<div class="small-12 columns" id="team-portfolio-related-overviews">';
		if($id){
			$skillsid = get_post_meta( $id, 'member_skills_box');
			$projectsid = get_post_meta( $id, 'member_projects_box');
			$skills = WordPressFinder::getSkills($skillsid);
			$projects = WordPressFinder::getProjects($projectsid);
			$html[] = '<div class="small-12 columns" id="team-portfolio-related-overviews">';
			$html[] = '<div class="small-12 large-6 columns" id="skills-overview">';
			$html[] = '<h3>'.$membername.'s related skills</h3>';
			if($skills){
				$html[] = '<ul class="small-block-grid-2 large-block-grid-4" id="skills-block-grid">';
					foreach($skills as $skill){
						$html[] = '<li><a href="'.$skill['link'].'"><h4 >'.$skill['title'].'</h4><img src="'.$skill['image_url'].'" alt="'.$skill['image_alt'].'"></a></li>';
					}
				$html[] = '</ul>';
			}else{
				$html[] = '<p>Currently there are no skills here... That can only mean one thing, exciting skills will be added soon! Make sure to check back often!</p>';
			}
				
			$html[] = '</div>';
			$html[] = '<div class="small-12 large-6 columns" id="projects-overview">';
			$html[] = '<h3>'.$membername."'s related projects</h3>";
			if($projects){
				$html[] = '<ul class="small-block-grid-2 large-block-grid-4" id="projects-block-grid">';
					foreach($projects as $project){
						$html[] = '<li><a href="'.$project['link'] .'"><h4 >'.$project['title'].'</h4><img src="'.$project['image_url'].'" alt="'.$project['image_alt'].'"></a></li>';
					}
				$html[] = '</ul>';
			}else{
				$html[] = '<p>Currently there are no projects here... That can only mean one thing, exciting projects will be added soon! Make sure to check back often!</p>';
			}
			$html[] = '</div>';
			$html[] = '</div>';
		}
		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}

	public function skill_overview($atts){
		extract( shortcode_atts( array(
			'id' => 0,
			'skillname' => "",
		), $atts, 'team-portfolio-skill-overview' ) );
		$html =  array();
		$html[] = '<div class="small-12 columns" id="team-portfolio-related-overviews">';
		if($id){
			$projectsid = get_post_meta( $id, 'skill_projects_box');
			$membersid = get_post_meta( $id, 'skill_members_box');
			$projects = WordPressFinder::getProjects($projectsid);
			$members = WordPressFinder::getMembers($membersid);
			$html[] = '<div class="small-12 columns" id="team-portfolio-related-overviews">';
			$html[] = '<div class="small-12 large-6 columns" id="members-overview">';
			$html[] = '<h3>'.$skillname.'s related members</h3>';
			if($members){
				$html[] = '<ul class="small-block-grid-2 large-block-grid-4" id="members-block-grid">';
					foreach($members as $memeber){
						$html[] = '<li><a href="'.$memeber['link'].'"><h4 >'.$memeber['title'].'</h4><img src="'.$memeber['image_url'].'" alt="'.$memeber['image_alt'].'"></a></li>';
					}
				$html[] = '</ul>';
			}else{
				$html[] = '<p>Currently there are no members here... That can only mean one thing, exciting members will be added soon! Make sure to check back often!</p>';
			}
				
			$html[] = '</div>';
			$html[] = '<div class="small-12 large-6 columns" id="projects-overview">';
			$html[] = '<h3>'.$skillname."'s related projects</h3>";
			if($projects){
				$html[] = '<ul class="small-block-grid-2 large-block-grid-4" id="projects-block-grid">';
					foreach($projects as $project){
						$html[] = '<li><a href="'.$project['link'] .'"><h4 >'.$project['title'].'</h4><img src="'.$project['image_url'].'" alt="'.$project['image_alt'].'"></a></li>';
					}
				$html[] = '</ul>';
			}else{
				$html[] = '<p>Currently there are no projects here... That can only mean one thing, exciting projects will be added soon! Make sure to check back often!</p>';
			}
			$html[] = '</div>';
		$html[] = '</div>';
		}
		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}

	public function project_overview($atts){
		extract( shortcode_atts( array(
			'id' => 0,
			'projectname' => "",
		), $atts, 'team-portfolio-project-overview' ) );
		$html =  array();
		$html[] = '<div class="small-12 columns" id="team-portfolio-related-overviews">';
		if($id){
			$skillsid = get_post_meta( $id, 'project_skills_box');
			$membersid = get_post_meta( $id, 'project_members_box');
			$skills = WordPressFinder::getSkills($skillsid);
			$members = WordPressFinder::getMembers($membersid);
			$html[] = '<div class="small-12 columns" id="team-portfolio-related-overviews">';
			$html[] = '<div class="small-12 large-6 columns" id="members-overview">';
			$html[] = '<h3>'.$projectname."'s related members</h3>";
			if($members){
				$html[] = '<ul class="small-block-grid-2 large-block-grid-4" id="members-block-grid">';
					foreach($members as $memeber){
						$html[] = '<li><a href="'.$memeber['link'].'"><h4 >'.$memeber['title'].'</h4><img src="'.$memeber['image_url'].'" alt="'.$memeber['image_alt'].'"></a></li>';
					}
				$html[] = '</ul>';
			}else{
				$html[] = '<p>Currently there are no members here... That can only mean one thing, exciting members will be added soon! Make sure to check back often!</p>';
			}
				
			$html[] = '</div>';
			$html[] = '<div class="small-12 large-6 columns" id="skills-overview">';
			$html[] = '<h3>'.$projectname."'s related skills</h3>";
			if($skills){
				$html[] = '<ul class="small-block-grid-2 large-block-grid-4" id="skills-block-grid">';
					foreach($skills as $skill){
						$html[] = '<li><a href="'.$skill['link'] .'"><h4 >'.$skill['title'].'</h4><img src="'.$skill['image_url'].'" alt="'.$skill['image_alt'].'"></a></li>';
					}
				$html[] = '</ul>';
			}else{
				$html[] = '<p>Currently there are no skills here... That can only mean one thing, exciting skills will be added soon! Make sure to check back often!</p>';
			}
			$html[] = '</div>';
			$html[] = '</div>';
		}
		$html[] = '</div>';
		// return the list html
		return implode("\n", $html);
	}

}

$tags = new PortfolioTags;