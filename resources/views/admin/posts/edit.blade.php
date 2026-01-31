@extends('layouts.admin')

@section('page-title', 'Edit Post')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('PUT')
                @include('admin.posts.form', ['post' => $post])
            </form>
        </div>
    </div>
@endsection
