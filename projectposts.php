<?php
require_once('finderhelper.php');

class ProjectPosts{
	public function __construct()
	{
		add_action('init',array($this, 'register_post_type'));
		add_filter( 'post_updated_messages', array($this, 'post_updated_message') );
		add_action( 'add_meta_boxes_projects', array($this, 'register_associated_skills_meta'));		
		add_action( 'save_post', array($this, 'run_project_skills_save'), 10, 2  ); 
		add_action( 'init', array($this, 'register_projectss_sidebar') );
		
	}

	function register_projectss_sidebar(){
		register_sidebar(array(
			'name' => __( 'Project Post Sidebar' ),
			'id' => 'project-post-sidebar',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));
	}

	

	public function register_post_type(){
		$labels = array(
			'name'               => _x( 'Projects', 'post type general name' ),
			'singular_name'      => _x( 'Project', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add New Project' ),
			'edit_item'          => __( 'Edit Project' ),
			'new_item'           => __( 'New Project' ),
			'all_items'          => __( 'All Projects' ),
			'view_item'          => __( 'View Project' ),
			'search_items'       => __( 'Search Projects' ),
			'not_found'          => __( 'No projects found' ),
			'not_found_in_trash' => __( 'No projects found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Projects'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Any of the projects that have been input into the system',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
		);
		register_post_type( 'projects', $args );
	}

	public function post_updated_message($messages){
		global $post, $post_ID;
		$messages['projects'] = array(
			0 => '', 
			1 => sprintf( __('Project updated. <a href="%s">View Project</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Project updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Project published. <a href="%s">View project</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Project saved.'),
			8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		return $messages;
	}

	public function register_associated_skills_meta(){
		add_meta_box( 
	        'project_meta_box',
	        'Projects Skills and Members',
	        array($this, 'project_skills'),
	        'projects',
	        'normal',
	        'high'
	    );
	}
	public function project_skills($post){
		wp_nonce_field( basename( __FILE__ ), 'projects_metabox_nonce' );
		$skills = WordPressFinder::getSkills();
		$members = WordPressFinder::getMembers();
		$skillsMeta=get_post_meta($post->ID, "skills", true);
		$membersMeta=get_post_meta($post->ID, "members", true);
		echo '<h4>Select The Skills Which you would like to associate with this Project</h4>';
		//echo var_dump($skillsMeta);
		if($skills){
			foreach($skills as $skill){
				$ischecked = false;
				foreach($skillsMeta as $idss){
					//echo (int) $idss;
					if((int) $skill['id']==(int) $idss){
						$ischecked = true;
						//echo 'true';
					}
				}
				?>
				<input type="checkbox" name="skills[]" value="<?php echo $skill['id'];?>" <?php checked($ischecked); ?> /> <?php echo $skill['title']; ?>
				<?php
			}
		}else{
			echo 'You need to create some skills pages!';
		}
		
		echo '<h4>Select The Members Which you would like to associate with this Project</h4>';
		if($members){
			foreach($members as $member){
				$ischeckedman = false;
				foreach($membersMeta as $memberthings){
					//echo (int) $memberthings;
					if((int) $member['id']==(int) $memberthings){
						$ischeckedman = true;
					}
				}
				?>
				<input type="checkbox" name="members[]" value="<?php echo $member['id'];?>" <?php checked($ischeckedman); ?> /> <?php echo $member['title']; ?>
				<?php
			}
		}else{
			echo 'You need to create some members pages!';
		}
	}

	public function run_project_skills_save($post_id, $post){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if ( !isset( $_POST['projects_metabox_nonce'] ) || !wp_verify_nonce( $_POST['projects_metabox_nonce'], basename( __FILE__ ) ) )
		return $post_id; 
	     
	    // if our current user can't edit this post, bail  
	    if( !current_user_can( 'edit_post' ) ) return;
	    if($post->post_type == 'projects'){
	    	if ( isset( $_POST['skills'] ) && $_POST['skills'] != '' ) {
	            update_post_meta( $post_id, 'skills', $_POST['skills'] );
	        }
	        if ( isset( $_POST['members'] ) && $_POST['members'] != '' ) {
	            update_post_meta( $post_id, 'members', $_POST['members'] );
	        }
	    }
	    return $post_id;
	}

}

$projectPosts = new ProjectPosts;