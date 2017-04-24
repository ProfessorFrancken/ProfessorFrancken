@extends('homepage.two-column-layout')

@section('content')
  <h1 class="section-header">
      Research Groups
  </h1>

  <p>
      Orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla facilisi cras fermentum, odio eu feugiat pretium, nibh ipsum consequat nisl, vel. Fames ac turpis egestas integer eget.
  </p>

  <h2>Research proposals</h2>

  <p>
      Dignissim sodales ut eu sem integer vitae justo eget magna fermentum iaculis eu. Nisi porta lorem mollis aliquam ut porttitor leo a diam sollicitudin tempor id eu nisl nunc mi!
  </p>

  <p>
      Gravida arcu ac tortor dignissim convallis aenean et tortor at risus viverra adipiscing at in tellus integer feugiat scelerisque varius morbi enim nunc, faucibus a pellentesque sit amet? Lectus urna duis convallis convallis tellus, id interdum? Sit amet, dictum sit amet justo donec enim diam, vulputate ut pharetra sit amet, aliquam! Sodales ut etiam sit amet nisl purus, in mollis nunc sed id semper risus in hendrerit gravida rutrum quisque non? Facilisis magna etiam tempor, orci eu lobortis elementum, nibh tellus molestie nunc, non blandit massa enim nec dui nunc mattis enim ut tellus elementum sagittis vitae et leo duis?
  </p>
 @endsection


@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        Research groups
    </h3>
    <ul class="agenda-list list-unstyled">
        @foreach ($groups as $group)

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/study/research-groups/{{ str_slug($group['title'])  }}"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                {{ $group['title'] }}
                            </h5>
                        </div>
                        <img
                            class="rounded d-flex ml-3"
                            src="https://www.rug.nl{{ $group['photo'] or '' }}"
                            alt="{{ $group['title'] }}'s logo"
                            style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                        >
                    </div>
                </a>

            </li>
        @endforeach
    </ul>
</div>
@endsection
