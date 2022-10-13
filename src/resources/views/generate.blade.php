<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">

</head>
<body>

    <main>
        <section>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
                </div>
            </nav>
        </section>
    </main>

    <main class="container mt-4">

        <section>

        @if(!empty($error))
            <div class="row">
                <div class="col">
                    <div class="alert-danger">{{ $error }}</div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <h3>{{ $title }}</h3>
                    <h4>{{ $sub_title }}</h4>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <p>{{ $description }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p><span class="text-black">Repetitions:</span> {{ $repetitions }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p><span class="text-black">Tool:</span> {{ $tool }}</p>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">

                    <h5>Sample Images</h5>
                    <ul class="list-group">
                    @foreach($samples as $sample)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <img class="img-fluid" src="{{ $sample }}" alt="{{ $title }}">
                        </li>
                    @endforeach
                    </ul>

                </div>
            </div>

            @php
                $embed = str_contains($video, "youtu");
                $embeded = str_replace(
                    ["https://youtu.be/", "?t"],
                    ["https://www.youtube-nocookie.com/embed/", "?start"],
                    $video
                );
            @endphp

            <div class="row mt-3">
                <div class="col">
                    @if ($embed)
                        <h5>Preview Video</h5>
                        <div class="youtube-video-container">
                            <iframe width="560"
                                    height="315"
                                    src="{{ $embeded }}"
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <a href="{{ $video }}">Preview Video</a>
                    @endif
                </div>
            </div>

        @endif

        </section>

        <section>
            <div class="row mt-4">
                <p class="text-black-50 small text-end"><small>Copyright {{ date('Y') }} Andres Bastidas</small></p>
            </div>
        </section>

    </main>
</body>
</html>
