<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ ($title ?? null) ? $title . ' — Cacao Nativa E-Learning' : 'Cacao Nativa E-Learning' }}</title>

<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance