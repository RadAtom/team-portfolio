<?php

class TeamPortfolioWidget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'team-portfolio-overview-widget', // Base ID
			__('Team Portfolio Orverview', 'text_domain'), // Name
			array( 'description' => __( 'Team Portfolio Orverview, displays the related projects, skills, and members.', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
	}

 	public function form( $instance ) {
		// outputs the options form on admin
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

function register_foo_widget() {
    register_widget( 'TeamPortfolioWidget' );
}
add_action( 'widgets_init', 'register_foo_widget' );