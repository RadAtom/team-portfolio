<?php
require_once('portfoliohtmlgenerator.php');

class TeamPortfolioOverviewWidget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'team-portfolio-overview-widget', // Base ID
			'Team Portfolio Orverview', // Name
			array( 'description' => 'Team Portfolio Orverview, displays the related projects, skills, and members.', ) // Args
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		echo PortfolioHTMLGenerator::overviewString($title);
		echo $args['after_widget'];
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


class TeamPortfolioSkillsWidget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'team-portfolio-skills-widget', // Base ID
			'Team Portfolio Skills Orverview', // Name
			array( 'description' => 'Team Portfolio skills Orverview, displays the skills which are currently in wordpress.', ) // Args
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		echo PortfolioHTMLGenerator::skillsOverviewString($title);
		echo $args['after_widget'];
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

class TeamPortfolioMembersWidget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'team-portfolio-members-widget', // Base ID
			'Team Portfolio Member Orverview', // Name
			array( 'description' => 'Team Portfolio Members Orverview, displays the members which are currently in wordpress.', ) // Args
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$members = WordPressFinder::getMembers();
		$memberGridSize = count($members);
		if($memberGridSize > 3){
			$memberGridSize = 3;
		}

		echo $args['before_widget'];
		echo '<div class="small-12 columns" id="members-overview">';

		if ( ! empty( $title ) ){
			echo $args['before_title'] . $title . $args['after_title'];
		}else{
			echo '<h3>Our Members</h3>';
		}
		if($memberGridSize){
			echo '<ul class="small-block-grid-2 large-block-grid-'. $memberGridSize .'">';
			foreach ($members as $member) {
				$html[] = '<li>';
				$html[] = '<a href="'.$member['link'].'"><h4 >'.$member['title'].'</h4><img src="'.$member['image_url'].'" alt="'.$member['image_alt'].'"></a>';
				$html[] = '</li>';
			}
			echo '</ul>';
			echo '</div>';
		}
		echo '</div>';
		echo $args['after_widget'];
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


class TeamPortfolioProjectsWidget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'team-portfolio-projects-widget', // Base ID
			'Team Portfolio Projects Orverview', // Name
			array( 'description' => 'Team Portfolio Projects Orverview, displays the projects which are currently in wordpress.', ) // Args
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$projects = WordPressFinder::getProjects();
		$projectGridSize = count($projects);
		if($projectGridSize > 3){
			$projectGridSize = 3;
		}

		echo $args['before_widget'];
		echo '<div class="small-12 columns" id="projects-overview">';

		if ( ! empty( $title ) ){
			echo PortfolioHTMLGenerator::projectsOverviewString( $args['before_title'] . $title . $args['after_title'] );
		}else{
			echo PortfolioHTMLGenerator::projectsOverviewString('<h3>Our Projects</h3>');
		}
		echo $args['after_widget'];
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

function register_all_widgets() {
    register_widget( 'TeamPortfolioOverviewWidget' );
    register_widget( 'TeamPortfolioSkillsWidget' );
    register_widget( 'TeamPortfolioMembersWidget' );
    register_widget( 'TeamPortfolioProjectsWidget' );
}
add_action( 'widgets_init', 'register_all_widgets' );