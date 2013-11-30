<?php
require_once('finderhelper.php');

class SkillPosts{
	public function __construct()
	{
		add_action('init',array($this, 'register_post_type'));
		add_filter( 'post_updated_messages', array($this, 'post_updated_message') );
		add_action( 'add_meta_boxes_skills', array($this, 'register_associated_projects_meta'));
		add_action( 'save_post', array($this, 'run_skill_projects_save'), 10, 2   ); 
		//add_filter( "single_template", array($this,'get_custom_post_type_template') ) ;
		add_action( 'init', array($this, 'register_skills_sidebar') );
		//add_filter( 'template_include', array($this,'portfolio_page_template'), 1 );
	}

	function register_skills_sidebar(){
		register_sidebar(array(
			'name' => __( 'Skills Post Sidebar' ),
			'id' => 'skill-post-sidebar',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));
	}

	public function register_post_type(){
		$labels = array(
			'name'               => _x( 'Skills', 'post type general name' ),
			'singular_name'      => _x( 'Skill', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add New Skill' ),
			'edit_item'          => __( 'Edit Skill' ),
			'new_item'           => __( 'New Skill' ),
			'all_items'          => __( 'All Skills' ),
			'view_item'          => __( 'View Skill' ),
			'search_items'       => __( 'Search Skills' ),
			'not_found'          => __( 'No Skills found' ),
			'not_found_in_trash' => __( 'No Skills found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Skills'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Any of the Skills that have been input into the system',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
		);
		register_post_type( 'skills', $args );
	}

	public function post_updated_message($messages){
		global $post, $post_ID;
		$messages['skills'] = array(
			0 => '', 
			1 => sprintf( __('Skill updated. <a href="%s">View Skill</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Skill updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Skill restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Skill published. <a href="%s">View skill</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Skill saved.'),
			8 => sprintf( __('Skill submitted. <a target="_blank" href="%s">Preview skill</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Skill scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview skill</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Skill draft updated. <a target="_blank" href="%s">Preview skill</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		return $messages;
	}

	public function register_associated_projects_meta(){
		add_meta_box( 
	        'skill_projects_box',
	        'Skills Projects',
	        array($this, 'skill_projects'),
	        'skills',
	        'normal',
	        'high'
	    );
	}

	public function skill_projects($post){
		wp_nonce_field( basename( __FILE__ ), 'skills_metabox_nonce' );
		$projects = WordPressFinder::getProjects();
		$members = WordPressFinder::getMembers();
		$projectsMeta=get_post_meta($post->ID, "projects", true);
		$membersMeta=get_post_meta($post->ID, "members", true);
		echo '<h4>Select The projects Which you would like to associate with this Project</h4>';
		if($projects){
			foreach($projects as $project){
				$ischecked = false;
				foreach($projectsMeta as $idss){
					//echo (int) $idss;
					if((int) $project['id']==(int) $idss){
						$ischecked = true;
						//echo 'true';
					}
				}
				?>
				<input type="checkbox" name="projects[]" value="<?php echo $project['id'];?>" <?php checked($ischecked); ?> /> <?php echo $project['title']; ?>
				<?php
			}
		}else{
			echo 'You need to create some projects pages!';
		}
		
		echo '<h4>Select The Members Which you would like to associate with this Project</h4>';
		if($members){
			foreach($members as $member){
				$ischeckedman = false;
				foreach($membersMeta as $memberthings){
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

	public function run_skill_projects_save($post_id, $post){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if ( !isset( $_POST['skills_metabox_nonce'] ) || !wp_verify_nonce( $_POST['skills_metabox_nonce'], basename( __FILE__ ) ) )
		return $post_id; 
	     
	    // if our current user can't edit this post, bail  
	    if( !current_user_can( 'edit_post' ) ) return;
	    if($post->post_type == 'skills'){
	    	update_post_meta( $post_id, 'members', 'test' );
	    	if ( isset( $_POST['projects'] ) && $_POST['projects'] != '' ) {
	            update_post_meta( $post_id, 'projects', $_POST['projects'] );
	        }
	        if ( isset( $_POST['members'] ) && $_POST['members'] != '' ) {
	            update_post_meta( $post_id, 'members', $_POST['members']);
	        }
	    }
	    return $post_id;
	}
}

$skillPosts = new SkillPosts;