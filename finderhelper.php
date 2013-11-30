<?php

class WordPressFinder{
	public function __construct(){

	}

	public static function getMembers($ids = null){
		global $post;
		$temp_post=$post;
		$returnArray = array();
		$args = array( 'post_type' => 'members','posts_per_page' => 100  );
		if(!is_null($ids)){
			$args['include'] = $ids;
		}
		$myposts = get_posts( $args );
		if($myposts){
			foreach ($myposts as $notpost) {
				$img_id = get_post_thumbnail_id($notpost->ID); // This gets just the ID of 
				$feat_image = wp_get_attachment_url( $img_id );
				$alt_text = "";
				if($img_id){
					$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
				}
				$foundnotpost = array('id' => $notpost->ID, 'title' => $notpost->post_title, 'link' => get_permalink($notpost) , 'image_url'=> $feat_image, 'image_alt'=> $alt_text);
				$returnArray[] = $foundnotpost;
				//echo var_dump($foundnotpost);
			}

		}
		$post=$temp_post;
		return $returnArray;
	}

	public static function getSkills($ids = null){
		global $post;
		$temp_post=$post;
		$returnArray = array();
		$args = array( 'post_type' => 'skills' ,'posts_per_page' => 100 );
		if(!is_null($ids)){
			$args['include'] = $ids;
		}
		$myposts = get_posts( $args );
		if($myposts){
			foreach ($myposts as $notpost) {
				$img_id = get_post_thumbnail_id($notpost->ID); // This gets just the ID of 
				$feat_image = wp_get_attachment_url( $img_id );
				$alt_text = "";
				if($img_id){
					$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
				}
				$foundnotpost = array('id' => $notpost->ID, 'title' => $notpost->post_title, 'link' => get_permalink($notpost) , 'image_url'=> $feat_image, 'image_alt'=> $alt_text);
				$returnArray[] = $foundnotpost;
				//echo var_dump($foundnotpost);
			}
		}

		$post=$temp_post;
		return $returnArray;
	}

	public static function getProjects($ids = null){
		global $post;
		$temp_post=$post;
		$returnArray = array();
		$args = array( 'post_type' => 'projects','posts_per_page' => 100 );
		if(!is_null($ids)){
			$args['include'] = $ids;
		}
		$myposts = get_posts( $args );
		if($myposts){
			foreach ($myposts as $notpost) {
				$img_id = get_post_thumbnail_id($notpost->ID); // This gets just the ID of 
				$feat_image = wp_get_attachment_url( $img_id );
				$alt_text = "";
				if($img_id){
					$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
				}
				$foundnotpost = array('id' => $notpost->ID, 'title' => $notpost->post_title, 'link' => get_permalink($notpost) , 'image_url'=> $feat_image, 'image_alt'=> $alt_text);
				$returnArray[] = $foundnotpost;
				//echo var_dump($foundnotpost);
			}

		}
		$post=$temp_post;
		return $returnArray;
	}
}