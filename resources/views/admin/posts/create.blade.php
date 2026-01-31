@extends('layouts.admin')

@section('page-title', 'Create Post')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                @include('admin.posts.form', ['post' => null])
            </form>
        </div>
    </div>
@endsection
