<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MrBmj') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-app>
            <v-toolbar color="white">
                <v-toolbar-title>MRBMJ Admin</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-side-icon class="hidden-md-and-up"></v-toolbar-side-icon>
                <v-toolbar-items class="hidden-sm-and-down">
                    @if (Route::currentRouteName() == 'login')
                      <v-btn flat href="{{ route('register') }}">Register</v-btn>
                    @endif
                    @if (Route::currentRouteName() == 'register')
                      <v-btn flat href="{{ route('login') }}"><v-link>Login</v-link></v-btn>
                    @endif
                </v-toolbar-items>
            </v-toolbar>
            @yield('content')
        </v-app>
    </div>
    <!-- Scripts -->
     <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>