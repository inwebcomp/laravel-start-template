<title>{{ $meta['title'] }}</title>

@if (isset($meta['description']) and $meta['description'])
    <meta name="description" content="{{ $meta['description'] }}" />
@endif

@if (isset($meta['keywords']) and $meta['keywords'])
    <meta name="keywords" content="{{ $meta['keywords'] }}" />
@endif

@if (isset($meta['canonical']) and $meta['canonical'])
    <link rel="canonical" href="{{ $meta['canonical'] }}"/>
@endif
