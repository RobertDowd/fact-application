html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @include('layouts.header')

        @include('layouts.navbar')
      
        @yield('content')

        @include('layouts.footbar')
        
        @include('layouts.footer')
    </body>
</html>