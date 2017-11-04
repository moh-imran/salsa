<!DOCTYPE html>
<html lang="gr">
    @include('user.partials.masterhead')
    @yield('style')
    @include('user.partials.script')
    <body>
        @include('user.partials.header')
        {{ csrf_field() }}
        @yield('content')

        @include('user.partials.footer')
    </body>
    @yield('script')
</html>