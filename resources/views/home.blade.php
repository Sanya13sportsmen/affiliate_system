@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <div class="row justify-content-center">
                            @if(!$links->isEmpty())
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Url</th>
                                        <th>Redirect to</th>
                                        <th>Number of redirects</th>
                                        <th>Number of unique redirects</th>
                                        <th>Number of clicks</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($links as $link)
                                        <tr>
                                            <td>{{ $link->name }}</td>
                                            <td>
                                                <a href="{{ route('links.short', $link->code) }}">
                                                    {{ route('links.short', $link->code) }}
                                                </a>
                                            </td>
                                            <td><a href="{{ $link->url }}">{{ $link->url }}</a></td>
                                            <td>{{ $link->visitors->count() }}</td>
                                            <td>{{ $link->visitors->unique('ip')->count() }}</td>
                                            <td>{{ $link->clicks->count() }}</td>
                                            <td>{{ $link->visitors->count() > 0 ? round($link->clicks->count() / $link->visitors->count() * 100) : 0 }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            <a class="btn btn-primary" href="{{ route('links.create') }}" role="button">Create new
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
