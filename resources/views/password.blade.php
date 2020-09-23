@extends('layout.wireframe')

@section('content')
    <section class="password">
        @if($algorithm !== null)
            <h1>{{ $algorithm }}</h1>
        @elseif($hash !== null && isset($password) && $password->value !== null)
            <h1>
                {{ $hash }}
                <br/>↓<br/>
                <a href="/password/{{ $password->value }}" title="{{ $password->value }}">{{ $password->value }}</a>
            </h1>
        @elseif(isset($password) && $password->value !== null)
            <h1>{{ $password->value }}</h1>
        @endif
    </section>

    <section>
        <h2>hashes</h2>

        <table>
            <tr>
                <th>timestamp</th>
                <th>hash</th>
                <th>algorithm</th>
            </tr>

            @foreach ($hashes as $hash)
                <tr>
                    <td>{{ $hash->updated_at }}</td>
                    <td><a href="/hash/{{ $hash->hash }}" title="{{ $hash->hash }}">{{ $hash->hash }}</a></td>
                    <td><a href="/algorithm/{{ $hash->algorithm }}" title="{{ $hash->algorithm }}">{{ $hash->algorithm }}</a></td>
                </tr>
            @endforeach
        </table>

        <div class="links">
            {{ $hashes->links() }}
        </div>
    </section>

@endsection
