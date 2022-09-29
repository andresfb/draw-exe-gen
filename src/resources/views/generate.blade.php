<h1>Exercise</h1>

@if(!empty($error))
    <h2>{{ $error }}</h2>
@endif

{{ $title }}<br>
{{ $sub_title }}<br>
{{ $description }}<br>
{{ $repetitions }}<br>
{{ $tool }}<br>
@foreach($samples as $sample)
    <img src="{{ $sample }}" alt="{{ $title }}">
@endforeach
<br>
@php
    $embeded = str_replace(
        ["https://youtu.be/", "?t"],
        ["https://www.youtube-nocookie.com/embed/", "?start"],
        $video
    );
@endphp
{{ $embeded }}<br>
{{ $video }}<br>

<iframe width="560"
        height="315"
        src="{{ $embeded }}"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
