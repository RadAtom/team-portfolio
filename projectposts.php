<?php
require_once('finderhelper.php');

class ProjectPosts{
	public function __construct()
	{
		add_action('init',array($this, 'register_post_type'));
		add_filter( 'post_updated_messages', array($this, 'post_updated_message') );
		add_action( 'add_meta_boxes', array($this, 'register_associated_skills_meta'));
		add_action( 'add_meta_boxes', array($this, 'register_associated_members_meta') );
		add_action( 'save_post', array($this, 'run_project_skills_save') ); 
		add_action( 'save_post', array($this, 'run_project_members_save') ); 
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
	        'project_skills_box',
	        'Projects Skills',
	        array($this, 'project_skills'),
	        'projects',
	        'normal',
	        'high'
	    );
	}

	public function register_associated_members_meta(){
		add_meta_box( 
	        'project_members_box',
	        'Projects Members',
	        array($this, 'project_members'),
	        'projects',
	        'normal',
	        'high'
	    );
	}

	public function project_skills(){
		wp_nonce_field( 'my_project_skill_meta_nonce', 'project_skill_meta_nonce' );
		$skills = WordPressFinder::getSkills();
		global $post;
		$previousMeta = get_post_custom( $post->ID );
		$previousIdsString = $previousMeta['project_skills_ids'];
		$previousIDs = explode(",", $previousIdsString);
		?>
		<h4>Select which Skills are associated with this project.</h4>
		<p><?php
		foreach ($skills as $skill) {
			$isChecked = false;
			if(count()){
				foreach ($previousIDs as $id) {
					if($id == $skill['id']){
						$isChecked = true;
					}
				}
			}
			?>
			<input type="checkbox" id="skill<?php echo $skill['id'];?>" name="skill<?php echo$skill['id'];?>" <?php if($isChecked){echo 'checked="checked"'}?> />
        	<label for="skill<?php echo$skill['id'];?>"> <a href="<?php echo$skill['link'];?>" target="_blank"><?php echo$skill['title'];?></a> </label>  
			</br>
			<?php
		}
		?></p><?php
	}

	public function project_members(){
		wp_nonce_field( 'my_project_member_meta_nonce', 'project_member_meta_nonce' );
		$members = WordPressFinder::getMembers();
		global $post;
		$previousMeta = get_post_custom( $post->ID );
		$previousIdsString = $previousMeta['project_members_ids'];
		$previousIDs = explode(",", $previousIdsString);
		?>
		<h4>Select which Members are associated with this project.</h4>
		<p><?php
		foreach ($members as $member) {
			$isChecked = false;
			if(count($previousIDs)){
				foreach ($previousIDs as $id) {
					if($id == $member['id']){
						$isChecked = true;
					}
				}
			}
			
			?>
			<input type="checkbox" id="member<?php echo $member['id'];?>" name="member<?php echo$member['id'];?>" <?php if($isChecked){echo 'checked="checked"'}?> />
        	<label for="member<?php echo$member['id'];?>"> <a href="<?php echo $member['link'];?>" target="_blank"><?php echo$member['title'];?></a> </label>  
			</br>
			<?php
		}
		?></p><?php
	}

	public function run_project_skills_save($post_id){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if( !isset( $_POST['project_skill_meta_nonce'] ) || !wp_verify_nonce( $_POST['project_skill_meta_nonce'], 'my_project_skill_meta_nonce' ) ) return; 
	     
	    // if our current user can't edit this post, bail  
	    if( !current_user_can( 'edit_post' ) ) return;

	    $finalSkills = array();
	    $skills = WordPressFinder::getSkills();
	    $hadAkey = false;
	    foreach ($skills as $skill) {
	    	$key = "skill{$skill['id']}";
	    	if( isset($_POST[$key]) ){
	    		if($_POST[$key]){
	    			$hadAkey = true;
	    			$finalSkills[] = $skill['id'];
	    		}
	    	}
	    }
	    $properReturn = implode(",", $finalSkills);
	    if($hadAkey){
	    	update_post_meta( $post_id, 'project_members_ids', $properReturn ); 
	    }
	}

	public function run_project_members_save($post_id){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if( !isset( $_POST['project_member_meta_nonce'] ) || !wp_verify_nonce( $_POST['project_member_meta_nonce'], 'my_project_member_meta_nonce' ) ) return; 
	     
	    // if our current user can't edit this post, bail  
	    if( !current_user_can( 'edit_post' ) ) return;

	    $finalMembers = array();
	    $members = WordPressFinder::getMembers();
	    $hadAkey = false;
	    foreach ($members as $member) {
	    	$key = "member{$member['id']}";
	    	if( isset($_POST[$key]) ){
	    		if($_POST[$key]){
	    			$hadAkey = true;
	    			$finalMembers[] = $member['id'];
	    		}
	    	}
	    }
	    $properReturn = implode(",", $finalMembers);
	    if($hadAkey){
	    	update_post_meta( $post_id, 'project_members_ids', $properReturn ); 
	    }
	}
}

$projectPosts = new ProjectPosts;