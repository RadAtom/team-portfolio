<?php
require_once('finderhelper.php');

class SkillPosts{
	public function __construct()
	{
		add_action('init',array($this, 'register_post_type'));
		add_filter( 'post_updated_messages', array($this, 'post_updated_message') );
		add_action( 'add_meta_boxes', array($this, 'register_associated_projects_meta'));
		add_action( 'add_meta_boxes', array($this, 'register_associated_members_meta') );
		add_action( 'save_post', array($this, 'run_skill_projects_save') ); 
		add_action( 'save_post', array($this, 'run_skill_members_save') ); 
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

	public function register_associated_members_meta(){
		add_meta_box( 
	        'skill_members_box',
	        'Skills Members',
	        array($this, 'skill_members'),
	        'skills',
	        'normal',
	        'high'
	    );
	}

	public function skill_projects(){
		wp_nonce_field( 'my_skill_project_meta_nonce', 'skill_project_meta_nonce' );
		$projects = WordPressFinder::getProjects());
		global $post;
		$previousMeta = get_post_custom( $post->ID );
		$previousIdsString = $previousMeta['skill_project_ids'];
		$previousIDs = explode(",", $previousIdsString);
		?>
		<h4>Select which Projects are associated with this Skill.</h4>
		<p><?php
		foreach ($projects as $project) {
			$isChecked = false;
			if(count($previousIDs)){
				foreach ($previousIDs as $id) {
					if($id == $project['id']){
						$isChecked = true;
					}
				}
			}
			
			?>
			<input type="checkbox" id="project<?php echo $project['id'];?>" name="project<?php echo $project['id'];?>" <?php if($isChecked){echo 'checked="checked"'}?> />
        	<label for="project<?php echo $project['id'];?>"> <a href="<?php echo $project['link'];?>" target="_blank"><?php echo $project['title'];?></a> </label>  
			</br>
			<?php
		}
		?></p><?php
	}

	public function skill_members(){
		wp_nonce_field( 'my_skill_member_meta_nonce', 'skill_member_meta_nonce' );
		$members = WordPressFinder::getMembers());
		global $post;
		$previousMeta = get_post_custom( $post->ID );
		$previousIdsString = $previousMeta['skill_member_ids'];
		$previousIDs = explode(",", $previousIdsString);
		?>
		<h4>Select which Members are associated with this Skill.</h4>
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
			<input type="checkbox" id="member<?php echo $member['id'];?>" name="member<?php echo $member['id'];?>" <?php if($isChecked){echo 'checked="checked"'}?> />
        	<label for="member<?php echo $member['id'];?>"> <a href="<?php echo $member['link'];?>" target="_blank"><?php echo $member['title'];?></a> </label>  
			</br>
			<?php
		}
		?></p><?php
	}

	public function run_skill_projects_save(){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if( !isset( $_POST['skill_project_meta_nonce'] ) || !wp_verify_nonce( $_POST['skill_project_meta_nonce'], 'my_skill_project_meta_nonce' ) ) return; 
	     
	    // if our current user can't edit this post, bail  
	    if( !current_user_can( 'edit_post' ) ) return;

	    $finalSkills = array();
	    $projects = WordPressFinder::getProjects();
	    $hadAkey = false;
	    foreach ($projects as $project) {
	    	$key = "project{$project['id']}";
	    	if( isset($_POST[$key]) ){
	    		if($_POST[$key]){
	    			$hadAkey = true;
	    			$finalProjects[] = $project['id'];
	    		}
	    	}
	    }
	    $properReturn = implode(",", $finalProjects);
	    if($hadAkey){
	    	update_post_meta( $post_id, 'skill_project_ids', $properReturn ); 
	    }

	}

	public function run_skill_members_save(){
		// Bail if we're doing an auto save  
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	     
	    // if our nonce isn't there, or we can't verify it, bail 
	    if( !isset( $_POST['skill_member_meta_nonce'] ) || !wp_verify_nonce( $_POST['skill_member_meta_nonce'], 'my_skill_member_meta_nonce' ) ) return; 
	     
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
	    	update_post_meta( $post_id, 'skill_member_ids', $properReturn ); 
	    }
	}
}

$skillPosts = new SkillPosts;