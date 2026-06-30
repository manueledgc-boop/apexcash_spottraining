<title>{{ $title ?? config('seo.title') }}</title>

<meta name="description" content="{{ $description ?? config('seo.description') }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('seo.site_name') }}">
<meta property="og:title" content="{{ $title ?? config('seo.title') }}">
<meta property="og:description" content="{{ $description ?? config('seo.description') }}">
<meta property="og:image" content="{{ asset($image ?? config('seo.image')) }}">
<meta property="og:url" content="{{ url()->current() }}">

<meta name="twitter:card" content="{{ config('seo.twitter_card') }}">
<meta name="twitter:title" content="{{ $title ?? config('seo.title') }}">
<meta name="twitter:description" content="{{ $description ?? config('seo.description') }}">
<meta name="twitter:image" content="{{ asset($image ?? config('seo.image')) }}">