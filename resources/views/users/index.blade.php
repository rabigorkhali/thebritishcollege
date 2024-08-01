@extends('layouts.master')
@section('filter')

<div class="row">
    <form method="get" action="" style="display:flex;">
        <div class="col-md-4 mb-2">
            <input type="text" value="{{request('search')}}" name="search" class="form-control"
                placeholder="Search by name or email..">
        </div>
        <div class="col-md-4 mb-2">
            <button type="submit" class="btn btn-sm btn-warning">{{__('Search')}}</button>
        </div>
    </form>
</div>
@endsection
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($users->count())
            @foreach ($users as $keyUserDatum => $datumUser)
                <tr>

                    <td>{{ $i = 1 + $keyUserDatum }}</td>
                    <td>{{ $datumUser->name ?? '' }}</td>
                    <td>{{ $datumUser->email ?? '' }}</td>
                    <td>
                        <a class="btn btn-sm btn-dark" href="{{ URL::to($indexUrl) . '/' . $datumUser->id }}">View</a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ URL::to($indexUrl) . '/' . $datumUser->id . '/edit' }}">Edit</a>
                        <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#confirmationModal"
                            data-email="{{ $datumUser->email }}"
                            data-actionurl="{{ URL::to($indexUrl) . '/' . $datumUser->id }}">Delete</button>
                    </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">Data not found.</td>
            </tr>
        @endif


    </tbody>

</table>
<ul class="pagination">
    {{ $users->links() }}
</ul>
@include('layouts.delete-modal')
@endsection