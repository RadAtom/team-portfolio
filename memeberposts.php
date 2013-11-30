<?php
require_once('finderhelper.php');

class MemberPosts{
	public function __construct()
	{
		add_action('init',array($this, 'register_post_type'));
		add_filter( 'post_updated_messages', array($this, 'post_updated_message') );
		add_action( 'add_meta_boxes_members', array($this, 'register_associated_skills_meta'));
		add_action( 'save_post', array($this, 'run_member_skills_save'), 10, 2  ); 
		add_action( 'init', array($this, 'register_members_sidebar') );
		//add_filter( 'template_include', array($this,'portfolio_page_template'), 2 );
	}

	function register_members_sidebar(){
		register_sidebar(array(
			'name' => __( 'Member Post Sidebar' ),
			'id' => 'member-post-sidebar',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));
	}

	public function register_post_type(){
		$labels = array(
			'name'               => _x( 'Members', 'post type general name' ),
			'singular_name'      => _x( 'Member', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'members' ),
			'add_new_item'       => __( 'Add New Member' ),
			'edit_item'          => __( 'Edit Member' ),
			'new_item'           => __( 'New Member' ),
			'all_items'          => __( 'All Members' ),
			'view_item'          => __( 'View Members' ),
			'search_items'       => __( 'Search Members' ),
			'not_found'          => __( 'No Members found' ),
			'not_found_in_trash' => __( 'No Members found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Members'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Any of the Members that have been input into the system',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
		);
		register_post_type( 'members', $args );
	}

	public function post_updated_message($messages){
		global $post, $post_ID;
		$messages['members'] = array(
			0 => '', 
			1 => sprintf( __('Member updated. <a href="%s">View Member</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Member updated.'),
			5 => isset($_GET['revision']) ? sprintf( __('Member restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Member published. <a href="%s">View member</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Member saved.'),
			8 => sprintf( __('Member submitted. <a target="_blank" href="%s">Preview member</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview member</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Member draft updated. <a target="_blank" href="%s">Preview member</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
		return $messages;
	}

	public function register_associated_skills_meta(){
		add_meta_box( 
	        'member_skills_box',
	        'Members Skills',
	        array($this, 'member_skills'),
	        'members',
	        'normal',
	        'high'
	    );
	}


	public function member_skills($post){
		wp_nonce_field( basename( __FILE__ ), 'memberss_metabox_nonce' );
		$projects = WordPressFinder::getProjects();
		$skills = WordPressFinder::getSkills();
		$projectsMeta=get_post_meta($post->ID, "projects", true);
		$skillsMeta=get_post_meta($post->ID, "skills", true);
		echo '<h4>Select The projects Which you would like to associate with this Member</h4>';
		//echo var_dump($projectsMeta);
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
		
		echo '<h4>Select The skills Which you would like to associate with this Member</h4>';
		if($skills){
			foreach($skills as $skill){
				$ischeckedman = false;
				foreach($skillsMeta as $skillthings){
					//echo (int) $skillthings;
					if((int) $skill['id']==(int) $skillthings){
						$ischeckedman = true;
					}
				}
				?>
				<input type="checkbox" name="skills[]" value="<?php echo $skill['id'];?>" <?php checked($ischeckedman); ?> /> <?php echo $skill['title']; ?>
				<?php
			}
		}else{
			echo 'You need to create some skills pages!';
		}
	}

	public function run_member_skills_save($post_id, $post){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if ( !isset( $_POST['memberss_metabox_nonce'] ) || !wp_verify_nonce( $_POST['memberss_metabox_nonce'], basename( __FILE__ ) ) )
		return $post_id; 
	     
	    // if our current user can't edit this post, bail  
	    if( !current_user_can( 'edit_post' ) ) return;
	    if($post->post_type == 'members'){
	    	if ( isset( $_POST['projects'] ) && $_POST['projects'] != '' ) {
	            update_post_meta( $post_id, 'projects', $_POST['projects'] );
	        }
	        if ( isset( $_POST['skills'] ) && $_POST['skills'] != '' ) {
	            update_post_meta( $post_id, 'skills', $_POST['skills'] );
	        }
	    }
	    return $post_id;
	}
}

$semberPosts = new MemberPosts;