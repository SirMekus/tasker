<nav class="navbar navbar-expand-lg navbar-light nav-sticky bg-white">
    <div class="container navigation">
      <a class="navbar-brand" href="{{ route('home') }}"> <img src="{{ asset('storage/for_site/heart.png')}}" alt=""
          srcset="" width="64px" height="64px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="nav justify-content-end nav-ul">
          <li class="nav-item ">
            <a class="nav-link text-dark fw-bold" aria-current="page" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark fw-bold" href="#">Explore</a>
          </li>

          <li class="nav-item">
            <a href="{{route('login')}}" class="nav-link fw-bold @if(Route::currentRouteName() == 'login') home-color text-white @endif text-dark">User Login </a>
          </li>
        </ul>

      </div>
    </div>
  </nav>