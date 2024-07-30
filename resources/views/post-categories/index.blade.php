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
            @foreach ($postCategories as $keyUserDatum => $datumUser)
                <tr>

                    <td>{{ $i = 1 + $keyUserDatum }}</td>
                    <td>{{ $datumUser->name ?? '' }}</td>
                    <td>
                        <a class="btn btn-sm btn-dark" href="{{ URL::to($indexUrl) . '/' . $datumUser->id }}">View</a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ URL::to($indexUrl) . '/' . $datumUser->id . '/edit' }}">Edit</a>
                        <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#confirmationModal"
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
{{-- <ul class="pagination">
    {{ $postCategories->links() }}
</ul> --}}
@include('layouts.delete-modal')
@endsection