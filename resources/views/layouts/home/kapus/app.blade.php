<!DOCTYPE html>
<html lang="en">
<head>

    @include('layouts.home.head')


</head>
<body>

    <div class="wrapper">
        @include('layouts.home.kapus.sidebar')
        @include('layouts.home.body')
        @include('layouts.home.script')
        @stack('js')
</div>
</body>
</html>