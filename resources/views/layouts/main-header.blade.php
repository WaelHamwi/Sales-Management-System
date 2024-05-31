<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" />
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <!-- New Links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/">{{__('s.sales_statistics')}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/stocks/details">{{__('s.inventory_details')}}</a>
      </li>
    </ul>
    <!-- End New Links -->

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            @if($user->image)
            <img src="{{ asset('uploads/' . $user->image) }}" alt="">
            @else
            <img src="{{ asset('images/placeholder.png') }}" alt="">
            @endif
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"> {{ $user->first_name }}</p>
          </div>
        </a>

        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a href="{{ url('profile/edit') }}" class="dropdown-item" id="editProfileLink">
            <i class="mdi mdi-account me-2"></i> {{__('s.edit_profile')}}
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="mdi mdi-power me-2"></i> {{__('s.logout')}}
            </button>
          </form>
        </div>
      </li>
    </ul>



    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<!-- partial -->