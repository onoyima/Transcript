<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript Application System</title>

    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" /> --}}

    <!-- Your custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    {{-- <link href="{{ mix('css/style.css') }}" rel="stylesheet" /> --}}

    <!-- Optional: You can keep both Bootstrap versions if needed, else remove the one not required -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Other necessary JS files can be added here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>


<body x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark': darkMode === true}"
    class="bg-white dark:bg-gray-900"
  >
<!-- ===== Preloader Start ===== -->
    <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed top-0 left-0 z-999999 flex h-screen w-screen items-center justify-center bg-gray-50 dark:bg-gray-900">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-green-800 border-t-transparent dark:border-green-400">
        </div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden ">

         
    

            <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto" >
                <!-- Small Device Overlay Start -->
                <div :class="sidebarToggle ? 'block lg:hidden' : 'hidden' "class="fixed z-9 h-screen w-full bg-gray-900/50" ></div>
                <!-- Small Device Overlay End -->
        
                <!-- ===== Main Content Start ===== -->
                <main>
                  <!-- ===== Header Start ===== -->
                  @include('partials.navbars') <!-- Include navbar partial here -->
                  @yield('content') <!-- Dynamic content goes here -->
                </main>
                <!-- ===== Main Content End ===== -->
              </div>
    </div>
 
    <!-- Add your JavaScript files -->
    <script data-cfasync="false" src="{{ asset('cdn-cgi/5c5dd728/email-decode.min.js') }}"></script>
    <script data-cfasync="false" src="{{ asset('cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}">
    </script>
    <script defer src="{{ asset('js/bundle.js') }}"></script>


    {{-- <script src="{{ mix('js/bundle.js') }}" defer></script> --}}

</body>

</html>
