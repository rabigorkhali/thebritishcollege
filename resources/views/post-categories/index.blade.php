@extends('layouts.master')
@section('filter')

<div class="row">
    <form method="get" action="" style="display:flex;">
        <div class="col-md-4 mb-2">
            <input type="text" value="{{request('search')}}" name="search" class="form-control"
                placeholder="Search by name..">
        </div>
        <div class="col-md-4 mb-2">
            <button type="submit" class="btn btn-sm btn-warning">{{__('Search')}}</button>
            <a href="{{ url()->current() }}" class="btn btn-sm btn-success">{{__('Clear')}}</a>
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
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($postCategories->count())
            @foreach ($postCategories as $keyPostCategory => $datumPostCategory)
                <tr>

                    <td>{{ $i = 1 + $keyPostCategory }}</td>
                    <td>{{ $datumPostCategory->name ?? '' }}</td>
                    <td>
                        <a class="btn btn-sm btn-dark" href="{{ URL::to($indexUrl) . '/' . $datumPostCategory->id }}">View</a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ URL::to($indexUrl) . '/' . $datumPostCategory->id . '/edit' }}">Edit</a>
                        <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#confirmationModal"
                            data-actionurl="{{ URL::to($indexUrl) . '/' . $datumPostCategory->id }}">Delete</button>
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

<div class="row">
    <div class="col">
        <nav>
         {{ $postCategories->appends(request()->query())->links('pagination::bootstrap-4') }}
        </nav>
    </div>
</div>
@include('layouts.delete-modal')
@endsection