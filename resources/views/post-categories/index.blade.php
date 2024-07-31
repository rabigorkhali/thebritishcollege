@extends('layouts.master')

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
    <ul class="pagination">
        {{ $postCategories->links() }}
    </ul>
</div>

@include('layouts.delete-modal')
@endsection