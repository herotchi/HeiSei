<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'HeiSei') }}</title>

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('img/Herotchi_CMS.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('img/Herotchi_CMS.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        
    </head>
    <body>
        <div class="container">
            <main>
                <div class="row">
                    <div class="col-md-4" id="news">
                        <div class="accordion" id="newsChild">
                        @foreach ($news as $year => $lists)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#{{$year}}" aria-expanded="false" aria-controls="{{$year}}">
                                        {{$year}}年
                                    </button>
                                </h2>
                                <div id="{{$year}}" class="accordion-collapse collapse" data-bs-parent="#newsChild">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                        @foreach ($lists as $list)
                                            <li class="list-group-item">
                                                {{$list->month}}月@if ($list->day){{$list->day}}日@endif
                                                <button type="button" class="btn btn-link text-start" onclick="clickFunction({{$list->year}}, this);">{{$list->context}}</button>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                    <div class="col-md-4" id="nouns">

                    </div>
                    <div class="col-md-4" id="music">

                    </div>
                </div>
            </main>
        </div>

        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="toast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex" data-bs-theme="dark">
                    <div class="toast-body">
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="閉じる"></button>
                </div>
            </div>
        </div>

        <script type="module" src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
