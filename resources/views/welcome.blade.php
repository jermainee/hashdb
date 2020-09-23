@extends('layout.wireframe')

@section('content')
    <section>
        <h2>latest hashes</h2>

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
