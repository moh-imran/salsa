@if(Session::has('flash_message'))
    <div class="alert bg-success">
        <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
        <span class="text-semibold"> {!! Session::get('flash_message')  !!} </span>
    </div>
@endif

@if(Session::has('flash_warning'))
    <div class="alert bg-warning">
        <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
        <span class="text-semibold"> {!! Session::get('flash_warning')  !!} </span>
    </div>
@endif

@if(Request::has('e'))
    <div class="alert bg-danger">
        <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
        <span class="text-semibold"> {!! Request::get('e')  !!} </span>
    </div>
@endif

@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has($msg))
        <div class="alert bg-{{ $msg }}">
            <button data-dismiss="alert" class="close" type="button"><span>×</span><span class="sr-only">Close</span></button>
            <span class="text-semibold">{{ ucwords($msg) }}: {{ Session::get($msg) }}</span>
        </div>
    @endif
@endforeach

{{--
@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif--}}
