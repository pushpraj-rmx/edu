@extends('layouts.admin')

@section('page-title', 'Create Category')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                @include('admin.categories.form', ['category' => null])
            </form>
        </div>
    </div>
@endsection
