<?php

/**
 * @author Harri Bell-Thomas <contact@hbt.io>
 * @created January, 2014 
 * @version 1.0.0
 * @license Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * @license url : http://creativecommons.org/licenses/by-sa/3.0/
*/ 


/*  INCLUDE WRAPPER  */
require_once('class.postcontroller.php');



/*  USAGE  */

$Poster = new PostController;

$Poster->set_title( "My Post's Title" );
$Poster->add_category(array(1,2,8));
$Poster->set_type( "post" );
$Poster->set_content( "This my awesome content" );
$Poster->set_author_id( 1 );
$Poster->set_post_slug( 'updated_post' );
//$Poster->set_page_template( "login-infusion-page.php" );
$Poster->set_post_state( "publish" );

$Poster->search('title', 'Old Post');
$Poster->update();

//$Poster->create();

//$Poster->PrettyPrintAll();

$Poster->get_var('slug');

?>