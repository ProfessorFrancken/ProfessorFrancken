@extends('layouts.content')

@section('sub-menu')
<ul class="nav navbar-nav navbar-center">
  <li><a href="#history">History</a></li>
  <li><a href="#boards">Boards</a></li>
  <li><a href="#committees">Committees</a></li>
  <li><a href="#something">Something something</a></li>
</ul>
@endsection

@section('content')

  <h1>About</h1>

  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
  cillum dolore eu fugiat nulla pariatur.

  <hr>

  <div class="row">
    <div class="col-md-7">
      <h2 id="history">History</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="/history" class="btn btn-default">Read more</a>
    </div>
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
    <div class="col-md-7">
      <h2 id="boards">Board</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="/boards" class="btn btn-default">List all boards</a>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-7">
      <h2 id="committees">Committees</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="#" class="btn btn-default">List of all committees</a>
    </div>
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-5">
      <img data-holder-rendered="true" src="" alt="300x300" width="300" height="300">
    </div>
    <div class="col-md-7">
      <h2 id="something">Something something</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <a href="#" class="btn btn-default">See all boards</a>
    </div>
  </div>

@endsection
