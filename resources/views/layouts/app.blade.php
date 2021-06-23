<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
      @include('layouts.head')
</head>

@guest
  <body id="body">
@else
  <body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
@endguest

	<script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
  </script>

    <div class="page-wrapper">

      @include('layouts.side')

      @include('layouts.nav')

       
      @yield('content')

      @include('layouts.footer')
    </div>
    
@include('layouts.js')

@yield('javascript')

</body>
</html>
