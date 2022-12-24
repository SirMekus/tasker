<x-layout.general>

    <x-nav></x-nav>
  
    <section class="row d-flex justify-content-center">
      <div class="col-lg-6 col-xs-4 d-none d-lg-block mt-4" style="background-color:#F6FEF8; text-align: center;">
        <div class="header-sideimage-sign mt-5">
          <img class="header-sideimage-img-sign" src="{{asset('storage/for_site/staff.webp')}}" alt="">
          <div class="header-content">
            <h1 class="header-sideimage-img-sign-text">Your No.1 Task Manager</h1>
            <p class="header-sideimage-img-sign-text-p ">Providing swift and easy administration.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-xs-12 p-5">
        <div class="card mt-5" style='border-radius:30px; box-shadow:5px 10px;'>
  
          <div class="card-body">
            <h1 class="text-center mt-5 fw-bold">User Portal</h1>
            <p class="text-center">Sign in to User Dashboard.</p>
            <form action="{{route('login')}}" id="form" method="post">
              <div class="col-12 mt-3">
                <input name="email" type="email" class="form-control form-control-lg" placeholder="Email Address">
              </div>
              <div class="col-12 mt-3">
                <input type="password" class="form-control form-control-lg" placeholder="Password" name="password">
              </div>
              <div class="col-12 mt-2">
  
                <input type="submit" class="btn home-color text-white form-control" value="Sign In" />
  
  
              </div>
            </form>
  
          </div>
        </div>
      </div>
    </section>
  
  </x-nav>