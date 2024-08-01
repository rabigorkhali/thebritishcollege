<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{  'Rabi Gorkhali' }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div id="app">
        @include('layouts.navbar')

        <main class="py-4">

            <div class="container">
                @guest
                @else
                    @if(str_contains(Route::currentRouteName(), 'home'))
                        <center>
                            <h1 class="mb-4">{{ __('WELCOME !') }} {{ Auth::user()->name }}</h1>
                        </center>
                    @endif
                @endguest

                @if (isset($indexUrl) && $indexUrl == env('SYSTEM_PREFIX', '') . '/' . last(explode('/', url()->current())))
                    <a class="btn btn-sm btn-primary mb-1 float-right"
                        href="{{ URL::to($indexUrl . '/create') }}">Create</a>
                @elseif(isset($indexUrl))
                    <a class="btn btn-sm btn-success mb-1 float-right" href="{{ URL::to($indexUrl) }}">Back</a>
                @endif
                @yield('filter')
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __(ucwords(str_replace('-', ' ', $title ?? ''))) }}</div>
                            <div class="card-body">
                                <!-- Success Message -->
                                @if ($errors->first('alert-success'))
                                    <div id="successAlert" class="alert alert-success alert-dismissible fade show"
                                        role="alert">
                                        {{ $errors->first('alert-success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <!-- Danger Message -->
                                @if ($errors->first('alert-danger'))
                                    <div id="dangerAlert" class="alert alert-danger alert-dismissible fade show"
                                        role="alert">
                                        {{ $errors->first('alert-danger') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

{{-- SCRIPT --}}
@include('layouts.script')
<script>
    $(document).ready(function () {
        $('#categories').select2();
    });
</script>

</html>