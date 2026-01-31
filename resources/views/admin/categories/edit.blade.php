@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')
                @include('admin.categories.form', ['category' => $category])
            </form>
        </div>
    </div>
@endsection
