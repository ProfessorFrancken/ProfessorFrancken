@extends('base-layout')

@section('sub-menu')
    @include('layout._subnavigation', [
        'list' => [
            ['url' => "/post", 'title' => 'All'],
            ['url' => "/news", 'title' => 'News'],
            ['url' => "/blog", 'title' => 'Blog'],
        ]
    ])
@endsection

@section('content')

<div>
  <h1>The Francken Blog</h1>
  <p class="lead">The official example template of creating a blog with Bootstrap.</p>
</div>

<div class="row">
  <div class="col-sm-8 blog-main">

    <!-- Fist post -->
    <div class="blog-post">
      <h2>Sample blog post</h2>
      <p>January 1, 2014 by <a href="#">Mark</a></p>

      <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
      <hr>
      <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
      <blockquote>
        <p>Mark should fix <strong>Mark Up</strong></p>
      </blockquote>
      <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
      <h2>Heading</h2>
      <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
      <h3>Sub-heading</h3>
      <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
      <pre><code>Example code block</code></pre>
      <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
      <h3>Sub-heading</h3>
      <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
      <ul>
        <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
        <li>Donec id elit non mi porta gravida at eget metus.</li>
        <li>Nulla vitae elit libero, a pharetra augue.</li>
      </ul>
      <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
      <ol>
        <li>Vestibulum id ligula porta felis euismod semper.</li>
        <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
        <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
      </ol>
      <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>
    </div><!-- /.blog-post -->

    <div class="blog-post">
      <h2>Sample blog post</h2>
      <p>January 1, 2014 by <a href="#">Mark</a></p>

      <p> Another blog post, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
    </div>

  </div><!-- /.blog-main -->


  <div class="col-sm-3 col-sm-offset-1" style="font-size: 14px;">
    <div class="thumbnail">
      <a href="#"><img src="http://www.professorfrancken.nl/franckenvrij/webplaatjes/20.2.jpg" alt=""</a>
      <div class="caption">
        <h3>Francken Vrij</h3>
        <p>Want to read more? Try the "Francken Vrij", T.F.V. Professor Francken's own magazine</p>
        <p><a href="#" class="btn btn-default" role="button">Overview</a></p>
      </div>
    </div>
    <div>
      <h4>Latest posts</h4>
      <ol class="list-unstyled">
        <li><a href="#">March 2014</a></li>
        <li><a href="#">February 2014</a></li>
        <li><a href="#">January 2014</a></li>
        <li><a href="#">December 2013</a></li>
        <li><a href="#">November 2013</a></li>
        <li><a href="#">October 2013</a></li>
        <li><a href="#">September 2013</a></li>
        <li><a href="#">August 2013</a></li>
        <li><a href="#">July 2013</a></li>
        <li><a href="#">June 2013</a></li>
        <li><a href="#">May 2013</a></li>
        <li><a href="#">April 2013</a></li>
      </ol>
    </div>
  </div><!-- /.blog-sidebar -->

</div><!-- /.row -->

@endsection
