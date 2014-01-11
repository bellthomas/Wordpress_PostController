<?php

/*
Plugin Name: Auto Post Creator
Plugin URI: ttp://hbt.io/
Description: Change the way that you use Wordpress with a complete admin UI overhaul and impress both your customers and users.
Version: 1.0.0
Author: Harri Bell-Thomas
Author URI: http://hbt.io/
*/
if (!isset($wp_rewrite))
	$wp_rewrite = new WP_Rewrite();
	
class PostController {
	
	// Variables for Post Data
	public $PC_title;
	public $PC_type;
	public $PC_content;
	public $PC_category;
	public $PC_template;
	public $PC_slug;
	public $PC_auth_id = "1";
	public $PC_status = "publish";
	
	// Variables for Post Updating
	public $PC_current_post;
	public $PC_current_post_id;
	public $PC_current_post_permalink;
	
	// Error Array
	public $errors;
	
	
	// Creation functions
	public function create() {
		if(isset($PC_title) ) {
			if ($this->PC_type == 'page') 
				$post = get_page_by_title( $this->PC_title, 'OBJECT', $this->PC_type );
			else 
				$post = get_page_by_title( $this->PC_title, 'OBJECT', $this->PC_type );
				
			$post_data = array(
				//'post_title'    => wp_strip_all_tags($this->PC_title),
				'post_title'    => $this->PC_title,
				'post_name'     => $this->PC_slug,
				'post_content'  => $this->PC_content,
				'post_status'   => $this->PC_status,
				'post_type'     => $this->PC_type,
				'post_author'   => $this->PC_auth_id,
				'post_category' => $this->PC_category,
				'page_template' => $this->PC_template
			);
			if(!isset($post)){
				$this->PC_current_post_id = wp_insert_post( $post_data, $error_obj );
				$this->PC_current_post = get_post((integer)$this->PC_current_post_id, 'OBJECT');
				return $error_obj;
			}
			else
				$this->update();
				return 'That page already exists. Try updating instead.';
		} 
		else {
			$this->errors[] = 'Title has not been set.';
			return FALSE;
		}
	}
	
	public function set_title($name){
		$this->PC_title = $name;	
		return $this->PC_title;
	}
	
	public function set_type($type){
		$this->PC_type = $type;	
		return $this->PC_type;
	}
	
	public function set_content($content){
		$this->PC_content = $content;	
		return $this->PC_content;
	}
	
	public function set_author_id($auth_id){
		$this->PC_auth_id = $auth_id;	
		return $this->PC_auth_id;
	}
	
	public function set_post_slug($slug){
		$args = array('name' => $slug);
		$posts_query = get_posts( $args );
		if( !get_posts( $args ) && !get_page_by_path( $this->PC_slug ) ) {
			$this->PC_slug = $slug;	
			return $this->PC_slug;	
		}
		else
			$this->errors[] = 'Slug already in use.';
			return FALSE;
	}
	
	public function set_page_template($content){
		if ($this->PC_type == "page")
			$this->PC_template = $content;
		else
			$this->errors[] = 'You can only use template for pages.';
		return $this->PC_template;
	}
	
	public function set_post_state($content){
		$this->PC_status = $content;
		return $this->PC_status;
	}
	
	public function add_category($IDs){
		if(is_array($IDs)) {
			foreach ($IDs as $id) {
				if (is_int($id)) {
					$this->PC_category[] = $id;
				} else {
					$this->errors[] = '<b>' .$id . '</b> is not a valid integer input.';
					return FALSE;
				}
			}
		} else {
			$this->errors[] = 'Input specified in not a valid array.';
			return FALSE;
		}
	}
	
	// Search for Post function
	public function search($by, $data){
		switch ($by) {
			case 'id' :
				if(is_integer($data) && get_post((integer)$data) !== NULL) {
					$this->PC_current_post = get_post((integer)$data, 'OBJECT');
					$this->PC_current_post_id = (integer)$data;
					$this->PC_current_post_permalink = get_permalink((integer)$data);
					return TRUE;
				} else {
					$this->errors[] = 'No post found with that ID.';
					return FALSE;
				}
			break;
			
			case 'title' :
				$post = get_page_by_title($data);
				$id = $post->ID;
				if(is_integer($id) && get_post((integer)$id) !== NULL) {
					$this->PC_current_post = get_post((integer)$id, 'OBJECT');
					$this->PC_current_post_id = (integer)$id;
					$this->PC_current_post_permalink = get_permalink((integer)$id);
					$this->errors[] = 'No post found with that title.';
					return TRUE;
				} else {
					return FALSE;
				}
			break;
			case 'slug' :
				$args = array('name' => $data, 'max_num_posts' => 1);
				$posts_query = get_posts( $args );
				if( $posts_query ) 
					$id = $posts_query[0]->ID;
				else
					$this->errors[] = 'No post found with that slug.';
				if(is_integer($id) && get_post((integer)$id) !== NULL) {
					$this->PC_current_post = get_post((integer)$id, 'OBJECT');
					$this->PC_current_post_id = (integer)$id;
					$this->PC_current_post_permalink = get_permalink((integer)$id);
					return TRUE;
				} else {
					$this->errors[] = 'No post found with that slug.';
					return FALSE;
				}
				
			break;
			
			default:
				$this->errors[] = 'No post found with that slug.';
				return FALSE;
			break;
		}
	}
	
	// Update Post
	public function update(){
		if (isset($this->PC_current_post_id)) {
			
			// Declare ID of Post to be updated
			$PC_post['ID'] = $this->PC_current_post_id;
			
			// Declare ID of Post to be updated
			if (isset($this->PC_title) && $this->PC_title !== $this->PC_current_post->post_title)
				$PC_post['post_title'] = $this->PC_title;
				
			if (isset($this->PC_type) && $this->PC_type !== $this->PC_current_post->post_type)
				$PC_post['post_type'] = $this->PC_type;
				
			if (isset($this->PC_auth_id) && $this->PC_auth_id !== $this->PC_current_post->post_type)
				$PC_post['post_author'] = $this->PC_auth_id;
				
			if (isset($this->PC_status) && $this->PC_status !== $this->PC_current_post->post_status)
				$PC_post['post_status'] = $this->PC_status;
				
			if (isset($this->PC_category) && $this->PC_category !== $this->PC_current_post->post_category)
				$PC_post['post_category'] = $this->PC_category;
				
			if (isset($this->PC_template) && $this->PC_template !== $this->PC_current_post->page_template && ($PC_post['post_type'] == 'page' || $this->PC_current_post->post_type == 'page'))
				$PC_post['page_template'] = $this->PC_template;
				
			if (isset($this->PC_slug) && $this->PC_slug !== $this->PC_current_post->post_name) {
				$args = array('name' => $this->PC_slug);
				if( !get_posts( $args ) && !get_page_by_path( $this->PC_slug ) )
					$PC_post['post_name'] = $this->PC_slug;
				else
					$errors[] = 'Slug Defined is Not Unique';
			}
			
			if (isset($this->PC_content) && $this->PC_content !== $this->PC_status->post_content )
				$PC_post['post_content'] = $this->PC_content;
	
			wp_update_post( $PC_post );
		}
		return($errors);
	}
	
	// General functions
	public function get_content(){
		if (isset($this->PC_status->post_content ) )
			return $this->PC_status->post_content;
	}
	
	public function get_var($name){
		$name = 'PC_'.$name;
		if (isset($this->$name))
			return $this->$name;
	}
	
	public function unset_all(){
		foreach (get_class_vars(get_class($this)) as $name => $default) 
			$this->$name = $default;	
	}
	
	public function __toString()  {  
		return 'Use the PrettyPrint function to return the contents of this Object. E.g;<pre>$my_post->PrettyPrint();</pre>';
    } 
	
	public function PrettyPrint(){
		echo "<pre>";
		print_r($this);
		echo "</pre>"; 
	}

}

$Poster = new PostController;

//$Poster->add_category(array(1,2,8));
$Poster->set_title( "Alexander" );
//$Poster->set_type( "post" );
//$Poster->set_content( "This my awesome content" );
//$Poster->set_author_id( 1 );
$Poster->set_post_slug( 'alex2' );
//$Poster->set_page_template( "login-infusion-page.php" );
//$Poster->set_post_state( "publish" );

//$Poster->search('title', 'Testing4');
//$Poster->update();
$Poster->create();
//$Poster->PrettyPrint();

$Poster->get_var('slug');


  


?>