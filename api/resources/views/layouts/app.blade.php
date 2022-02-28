<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--Here we update title with every new value from template--}}
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<div class="container mt-3">
    {{--Here we add a header from Bootstrap example--}}
    @include('includes.header')
</div>

{{--Use if to render HERO only on main page--}}
@if(Request::is('/'))
    @include('includes.hero')
@endif
{{--Don't forget to close IF directive--}}


<div class="container py-3">
    {{-- 5. Messages will contain errors and success blocks --}}
    @include('includes.messages')
    <div class="row">
        <div class="col-8">
            {{--Here we update content section with every new value from template--}}
            @yield('content')
        </div>
        <div class="col-4">
            {{--Here we INCLUDE a file into a main template--}}
            @include('includes.aside')
        </div>
    </div>
    {{--Here we add footer template--}}
    @include('includes.footer')
</div>
</body>
</html>
