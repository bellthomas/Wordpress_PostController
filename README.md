<h2>Wordpress PostController</h2>

This is a PHP Class which enables you to create/manage/update Wordpress posts and pages.

This require Wordpress to run.

<h3>Usage</h3>
Include the <code>class.postcontroller.php</code> file in your Wordpress plugin/theme.

You now have access to the class and its functions. Instantiate the class.
<pre>
$Poster = new PostController;
</pre>
<p>This class has two major functions; Creating and Updating posts. We'll start with creating.</p>
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
<p>&nbsp;</p>
<h3>Other Attributes</h3>
<h4>Title</h4>
<p>We have already seen this method. It sets the post's title. No HTML is allowed here, and is stripped out.</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre>
<h4>Type</h4>
<p>This method sets the post type of the page to be created. Input the slug of the post type, eg. 'post' and 'page'. Custom post types are supported.</p>
<pre>$Poster-&gt;set_type( &quot;page&quot; ); 
</pre>
<h4>Content</h4>
<p>This method sets the post's content. HTML is allowed.</p>
<pre>$Poster-&gt;set_content( &quot;&lt;h1&gt;This is my awesome new post!&lt;/h1&gt;&quot; ); 
</pre><h4>Author</h4>
<p>We have already seen this method. It sets the post's title. No HTML is allowed here, and is stripped out.</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre><h4>Slug / 'Name'</h4>
<p>We have already seen this method. It sets the post's title. No HTML is allowed here, and is stripped out.</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre><h4>Template (Pages Only)</h4>
<p>We have already seen this method. It sets the post's title. No HTML is allowed here, and is stripped out.</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre><h4>State</h4>
<p>We have already seen this method. It sets the post's title. No HTML is allowed here, and is stripped out.</p>
<pre>$Poster-&gt;set_title( &quot;New Post&quot; ); 
</pre><p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
