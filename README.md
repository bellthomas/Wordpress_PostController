<h2>Wordpress PostController</h2>

This is a PHP Class which enables you to create/manage/update Wordpress posts and pages.

This require Wordpress 2.9+ to run.

<h3>Usage</h3>
Include the <code>class.postcontroller.php</code> file in your Wordpress plugin/theme.

You now have access to the class and its functions. Instantiate the class.
<pre>
$Poster = new PostController;
</pre>
<p>This class has two major functions; Creating and Updating posts. We'll start with creating.</p>
<p>See <code>index.php</code> for working examples.</p>
<h3>Post Creation</h3>
<p>The minimum requisite for creating a post is having the title set. You can do this by using the following code;</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre>
<p>After this has been set, simply run the create method.</p>
<pre>$Poster-&gt;create();</pre>
<p><strong>Note:</strong> The method will check if there is another post with the same name (just to ensure that it isn't making duplicates). Hence a<strong> unique title </strong>is required.</p>
<p>There are many other attributes you can set. To do this, you simply run their respective method before calling the create method.</p>
<p>&nbsp;</p>
<h3>Post Updating</h3>
<h4>Search</h4>
<p>Before we can update a post, we need to find it. To do this, we use the search method.</p>
<pre>$Poster-&gt;search( ' SEARCH_BY ' , ' DATA ' );
</pre>
<p>This method accepts 2 parameters, the attribute to search by and the data to search for.</p>
<p>You can search by title;</p>
<pre>$Poster-&gt;search( 'title' , ' DATA ' );
</pre>
<p>You can search by ID;</p>
<pre>$Poster-&gt;search( 'id' , ' DATA ' );
</pre>
<p>And you can search by slug;</p>
<pre>$Poster-&gt;search( 'slug' , ' DATA ' );</pre>
<p>The data parameter will accept either a string (if searching by title or slug) or an integer (if searching by title).</p>
<p>If a post or page cannot be found with the specified parameters, an error will be added to the <code>$erros</code> array. You can call and display this with the following code.</p>
<pre>$error = $Poster-&gt;get_var(errors);
$Poster-&gt;PrettyPrint($error);</pre>
<h4>&nbsp;</h4>
<h4>Update</h4>
<p>Once a post has been found, you can assign it new attributes.</p>
<p>Once the attributes have been set, simply call the update method.</p>
<pre>$Poster-&gt;update();
</pre>
<p>For example, if you wish to change the title of post 1 (ID = 1), you would use the following code.</p>
<pre>$Poster-&gt;search( 'id' , 1 );
$Poster-&gt;set_title( &quot;New Title&quot; ); 
$Poster-&gt;update();
</pre>
<p>All the attributes can be updated this way.</p>
<p>&nbsp;</p>
<h3>Attributes</h3>
<h4>Title</h4>
<p>We have already seen this method. It sets the post's title. No HTML is allowed here, and is stripped out.</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre>
<h4>Type</h4>
<p>This method sets the post type of the page. Input the slug of the post type, eg. <code>'post'</code> and <code>'page'</code>. Custom post types are supported.</p>
<pre>$Poster-&gt;set_type( &quot;page&quot; ); 
</pre>
<h4>Content</h4>
<p>This method sets the post's content. HTML is allowed.</p>
<pre>$Poster-&gt;set_content( &quot;&lt;h1&gt;This is my awesome new post!&lt;/h1&gt;&quot; ); 
</pre><h4>Author</h4>
<p>This sets the post's author. Simply specify the author ID of the new author. This must be an integer.</p>
<pre>$Poster-&gt;set_author_id( 12 ); 
</pre>
<h4>Slug / 'Name'</h4>
<p>This is the custom url path of the post (if enabled). <strong>Take care</strong> with this, as if the slug is already in use, it may cause some errors. I have included validation to try and avoid this at all costs though. No special characters or html allowed.</p>
<pre>$Poster-&gt;set_post_slug( &quot;new_slug&quot; ); 
</pre>
<h4>Categories</h4>
<p>This is an integer or array of integers. This function is <b>non destructive</b>, meaning it will preserve any categories already set (see 'Multiple Function Example'). The integers correspond to Category ID's, which will be unique to each Wordpress site. NB Category with ID 1 is created automatically and can't be deleted.</p>
<pre>$Poster-&gt;add_category( array( 1 , 2 ) );    // Adds post to both categories 1 and 2.
$Poster-&gt;add_category( 1 );    // Adds post to category 1.
// Multiple Function Example
$Poster-&gt;add_category( 1 );
$Poster-&gt;add_category( 2 );
// This adds the post to both category 1 and 2.
</pre>
<h4>Template (Pages Only)</h4>
<p>This method alows you to set your page's template (must be a page). If applied to a different post type it will be ignored, and an error will be added to the errors array. The format of the input will be <code>'php_template_name.php'</code> and will be unique to each theme.</p>
<pre>$Poster-&gt;set_page_template( &quot;fullwidth_page.php&quot; ); 
</pre><h4>State</h4>
<p>This method sets the post's state.</p>
<p>Available options; [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | custom registered status ] </p>
<pre>$Poster-&gt;set_post_state( &quot;pending&quot; ); 
</pre><p>&nbsp;</p>
<h3>Retrieving Variables</h3>
<p>To retrieve defined variables you can use the get_vars method.</p>
<pre>
$Poster->get_var('title'); // Returns the title (if you have set it)
$Poster->get_var('type'); // Returns the post type (if you have set it)
$Poster->get_var('content'); // Returns the content (if you have set it)
$Poster->get_var('category'); // Returns the category as an array (if you have set it)
$Poster->get_var('template'); // Returns the template (if you have set it)
$Poster->get_var('slug'); // Returns the slug (if you have set it)
$Poster->get_var('auth_id'); // Returns the author id (if you have set it)
$Poster->get_var('status'); // Returns the post's status (if you have set it)

// AFTER YOU HAVE EITHER CREATED A POST OR SUCCESFULLY SEARCHED FOR ONE YOU CAN USE THESE

$Poster->get_var('current_post'); // Returns the a PHP Object of the post. This can be used to check if the search method was successful
$Poster->get_var('current_post_id'); // Returns the selected post's ID (integer). 
$Poster->get_var('current_post_permalink'); // Returns the URL permalink of the selected post
</pre>
