@extends('layouts.admin')

@section('page-title', 'Create Offering')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('offerings.store') }}">
                @csrf
                @include('admin.offerings.form', ['offering' => null, 'categories' => $categories, 'tags' => $tags])
            </form>
        </div>
    </div>
@endsection
