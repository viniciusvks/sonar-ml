@extends('layout')
@section('js')
    <script src="{{ mix('js/queries.js') }}" defer></script>
@endsection
@section('content')
    <div class="row justify-content-center text-center">
        <div class="col-lg-8">
            <div class="card mb-2">
                <div class="card-body">
                    <form action="{{ route('query.create') }}" method="post">
                        @csrf
                        <div class="form-group row mb-0">
                            <div class="col-md-11 pr-0">
                                <input id="search-box" name="searchKey" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-1 p-0">
                                <button type="submit" id="search" class="btn btn-primary self-align-center">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-sm-left"> Queries </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Search Key</th>
                                <th>New</th>
                                <th><i id="bulk-sync" class="fas fa-sync-alt" role="button"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($queries as $query)
                                <tr id="{{$query->id}}">
                                    <td>
                                        <a class="search-key text-decoration-none" href="{{ route('query.show', ['query' => $query->id]) }}" data-text="{{ $query->search_key }}">
                                            {{ $query->search_key }}
                                        </a>
                                    </td>
                                    <td class="new">{{ $query->listings()->unread()->count() }}</td>
                                    <td>
                                        <button class="btn sync">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button class="btn delete-query">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                        <button class="btn edit-query">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
