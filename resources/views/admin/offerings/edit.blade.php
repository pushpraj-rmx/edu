@extends('layouts.admin')

@section('page-title', 'Edit Offering')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('offerings.update', $offering) }}">
                @csrf
                @method('PUT')
                @include('admin.offerings.form', ['offering' => $offering, 'categories' => $categories, 'tags' => $tags])
            </form>
        </div>
    </div>
@endsection
