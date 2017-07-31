@extends('layout.two-column-layout')
@section('title', "Research Groups - T.F.V. 'Professor Francken'")
@section('header-image-url', '/images/header/practice-session.jpg')

@section('content')
  <h1 class="section-header">
      Research Groups
  </h1>

  <p>
     
  </p>

  <h2>Zernike Institute for Advanced Materials</h2>

  <p>
    The <i>Zernike Institute for Advanced Materials</i> at the University of Groningen is simultaneously young and old. We got our current name on 16 January 2007, making us quite young, but we grew out of the Materials Science Centre, which started back in 1970. Much has changed since those early days, but there are a few constants. Possibly our greatest asset is the close collaboration between people with different backgrounds. Physicists and chemists, and increasingly biologists, theoreticians and experimentalists work closely together, giving the Institute a breadth rarely found elsewhere. In our efforts we involve the whole chain of knowledge; modelling, design, synthesis, characterization, physical properties, theory and device functionality.

    <img src="/images/study/rug_zernike_institute_logoen_rood_rgb.png" alt="Zernike Institute for Advanced Materials" class="img-fluid mt-4">
  </p>

 @endsection


@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        Research Groups
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
                        @if (isset($group['photo']))
                            <img
                                class="rounded d-flex ml-3"
                                src="{{ image("https://www.rug.nl" . $group['photo'], ['width' => 75, 'height' => 75]) }}"
                                alt="{{ $group['title'] }}'s logo"
                                style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                            >
                        @endif
                    </div>
                </a>

            </li>
        @endforeach
    </ul>
</div>
@endsection
