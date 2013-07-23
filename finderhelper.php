<?php

class WordPressFinder{
	public function __construct(){

	}

	public static function getMembers(){
		global $post;
		$returnArray = array();
		$tmp_post = $post;
		$args = array( 'post_type' => 'members' );
		$myposts = get_posts( $args );
		foreach ($myposts as $post) {
			$foundPost = array('id' => $post['ID'], 'title' => $post['post_title '], 'link' => get_permalink($post) );
			$returnArray[] = $foundPost;
		}
		$post = $tmp_post
		return $returnArray;
	}

	public static function getSkills(){
		global $post;
		$returnArray = array();
		$tmp_post = $post;
		$args = array( 'post_type' => 'sills' );
		$myposts = get_posts( $args );
		foreach ($myposts as $post) {
			$foundPost = array('id' => $post['ID'], 'title' => $post['post_title '], 'link' => get_permalink($post) );
			$returnArray[] = $foundPost;
		}
		$post = $tmp_post
		return $returnArray;
	}

	public static function getProjects(){
		global $post;
		$returnArray = array();
		$tmp_post = $post;
		$args = array( 'post_type' => 'projects' );
		$myposts = get_posts( $args );
		foreach ($myposts as $post) {
			$foundPost = array('id' => $post['ID'], 'title' => $post['post_title '], 'link' => get_permalink($post) );
			$returnArray[] = $foundPost;
		}
		$post = $tmp_post
		return $returnArray;
	}
}