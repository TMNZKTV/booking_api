{{-- 4. @if +@endif / $errors - array of errors available in every html template --}}

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            {{-- 4. @foreach + @endforeach / all() - checks all items in array /
            {{item}} to render --}}
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
