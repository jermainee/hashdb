<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>hashdb</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <a href="/" title="hashdb">
            <pre>
@@@  @@@   @@@@@@    @@@@@@   @@@  @@@  @@@@@@@   @@@@@@@
@@@  @@@  @@@@@@@@  @@@@@@@   @@@  @@@  @@@@@@@@  @@@@@@@@
@@!  @@@  @@!  @@@  !@@       @@!  @@@  @@!  @@@  @@!  @@@
!@!  @!@  !@!  @!@  !@!       !@!  @!@  !@!  @!@  !@   @!@
@!@!@!@!  @!@!@!@!  !!@@!!    @!@!@!@!  @!@  !@!  @!@!@!@
!!!@!!!!  !!!@!!!!   !!@!!!   !!!@!!!!  !@!  !!!  !!!@!!!!
!!:  !!!  !!:  !!!       !:!  !!:  !!!  !!:  !!!  !!:  !!!
:!:  !:!  :!:  !:!      !:!   :!:  !:!  :!:  !:!  :!:  !:!
::   :::  ::   :::  :::: ::   ::   :::   :::: ::   :: ::::
 :   : :   :   : :  :: : :     :   : :  :: :  :   :: : ::
</pre></a>

            <div class="metrics">
                {{ number_format(DB::table('hashes')->count(), 0, ',', '.') }} hashes, {{ number_format(DB::table('passwords')->count(), 0, ',', '.') }} passwords
            </div>
        </header>

        <nav>
            <h2>algorithms</h2>

            @foreach(hash_algos() as $algorithm)
                @if(str_contains($algorithm, '/'))
                    @continue
                @endif
                <a href="/algorithm/{{ $algorithm }}" title="{{ $algorithm }}">{{ $algorithm }}</a>
            @endforeach
        </nav>

        @yield('content')
    </div>
</body>
</html>
