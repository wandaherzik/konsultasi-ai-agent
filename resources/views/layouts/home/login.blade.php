<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.home.head')
</head>
<body>

        @include('layouts.home.body')
        @include('layouts.home.script')
        @stack('js')
</body>
</html>