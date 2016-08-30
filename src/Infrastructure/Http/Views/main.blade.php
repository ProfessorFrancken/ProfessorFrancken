@extends('layouts.basic')


@section('content')
<div class="row">
  <!-- #18191B; -->
  <!-- #343538; -->
  <div class="col-sm-3">
    <div class="sidebar">
      <h3>Agenda</h3>
      <hr/>
      <h4>Wednesday 13th of april</h4>
      <ol class="list-unstyled">
        <li>
          <i class="glyphicon glyphicon-education"></i>
          Id leo in.</li>
        <li>
          <i class="glyphicon glyphicon-picture"></i>
          Massa tincidunt dui ut!</li>
        <li>
          <i class="glyphicon glyphicon-glass"></i>
          Mattis rhoncus, urna neque.</li>
        <li>
          <i class="glyphicon glyphicon-music"></i>
          Ornare massa, eget.</li>
        <li>
          <i class="glyphicon glyphicon-education"></i>
          Placerat duis ultricies lacus.</li>
      </ol>

      <h4>Friday 15th of april</h4>
      <ol class="list-unstyled">
        <li style="line-height: 1.5">
          <i class="glyphicon glyphicon-glass"></i>Id leo in.</li>
        <li>
      </ol>

      <h4>Thuesday 19th of april</h4>
      <ol class="list-unstyled">
        <li><i class="glyphicon glyphicon-picture"></i>Id leo in.</li>
        <li><i class="glyphicon glyphicon-education"></i>Massa tincidunt dui ut!</li>
        <li><i class="glyphicon glyphicon-music"></i>Mattis rhoncus, urna neque.</li>
        <li><i class="glyphicon glyphicon-music"></i>Ornare massa, eget.</li>
        <li><i class="glyphicon glyphicon-education"></i>Placerat duis ultricies lacus.</li>
      </ol>

      <p class="text-muted show-more">
        <small>
          Show more activities
        </small>
      </p>
    </div>

    {{--
    <h3 href="#">Slide show hierzo</h3>
    <div>
      <img style="width: 100%; border-radius: 5px;" src="http://c2.staticflickr.com/2/1546/25832438345_b7f086c708_h.jpg">
    </div>

    <h3>Upcoming events</h3>
    <div class="panel panel-default">
      <div class="panel-heading">Evenement <span class="date">12-09-1989<span></div>
      <div class="panel-body">
        Omschrijving evemenet
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Evenement <span class="date">12-09-1989<span></div>
      <div class="panel-body">
        Omschrijving evemenet
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Evenement <span class="date">12-09-1989<span></div>
      <div class="panel-body">
        Omschrijving evemenet
      </div>
    </div>
    --}}
  </div>
  <div class="col-sm-6">
    <div class="main-content">
      <ul class="list-unstyled">
        <li>
          <article>
            <div class="media">
              <div class="media-left media-middle">
                <div  class="francken-category">
                  <a style="line-height: 64px; font-size: 2em" class="glyphicon glyphicon-education"></a>
                </div>
              </div>
              <div class="media-body">
                <h3 class="media-heading">Experiences of a freshmen</h3>
                <i>Posted by <a href="#">Mark Boer</a> on 03-04-2001</i>
              </div>
            </div>
            <p>
              Tortor aliquam nulla facilisi cras fermentum, odio eu feugiat pretium, nibh ipsum consequat nisl, vel pretium lectus quam id leo!
            </p>
          </article>
        </li>
        <li>
          <article>

            <div class="media">
              <div class="media-left media-middle">
                <div  class="francken-category">
                  <a style="line-height: 64px; font-size: 2em" class="glyphicon glyphicon-education"></a>
                </div>
              </div>
              <div class="media-body">
                <h3 class="media-heading">Experiences of a freshmen</h3>
                <i>Posted by <a href="#">Mark Boer</a> on 03-04-2001</i>
              </div>
            </div>
            <p>
              Sapien, faucibus et molestie ac, feugiat sed lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi tincidunt ornare massa, eget egestas purus viverra accumsan in nisl nisi, scelerisque. Ridiculus mus mauris vitae ultricies leo integer malesuada nunc vel risus commodo viverra maecenas accumsan, lacus vel facilisis volutpat, est velit egestas dui.
            </p>
          </article>
        </li>
        <li>
          <article>
            <div class="media">
              <div class="media-left media-middle">
                <div  class="francken-category">
                  <a style="line-height: 64px; font-size: 2em" class="glyphicon glyphicon-education"></a>
                </div>
              </div>
              <div class="media-body">
                <h3 class="media-heading">Experiences of a freshmen</h3>
                <i>Posted by <a href="#">Mark Boer</a> on 03-04-2001</i>
              </div>
            </div>
            <p>
              Donec adipiscing tristique risus nec feugiat in fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed? Sit amet commodo nulla facilisi nullam vehicula ipsum a arcu cursus vitae congue.
            </p>
          </article>
        </li>
        <li>
          <article>
            <div class="media">
              <div class="media-left media-middle">
                <div  class="francken-category">
                  <a style="line-height: 64px; font-size: 2em" class="glyphicon glyphicon-education"></a>
                </div>
              </div>
              <div class="media-body">
                <h3 class="media-heading">Experiences of a freshmen</h3>
                <i>Posted by <a href="#">Mark Boer</a> on 03-04-2001</i>
              </div>
            </div>
            <p>
              Egestas egestas fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae? Leo in vitae turpis massa sed elementum tempus egestas sed sed risus pretium quam vulputate dignissim suspendisse in est. Diam vel quam elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor sit amet, consectetur adipiscing.
            </p>
          </article>
        </li>
      </ul>

      <hr>
    </div>
  </div>
</div><!--  .row  -->


@endsection
