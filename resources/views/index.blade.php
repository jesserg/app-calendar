<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <title>Jesser - Test Calendar</title>
 
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="px-4"> <!-- container -->
                <calendar-component></calendar-component>
            </div>
        </main>
    </div>
</body>
</html>