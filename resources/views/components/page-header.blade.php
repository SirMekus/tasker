@props(['header'])

<div class="navbar-collapse">
    @if(!empty(url()->previous()))
    <a href="{{url()->previous()}}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left fa-lg"></i>
        </a>
        @endif
<span class='ms-2 fs-5 fw-bold'>{{$header}}</h3>
    </div>