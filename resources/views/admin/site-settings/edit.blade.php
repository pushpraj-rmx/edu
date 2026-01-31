@extends('layouts.admin')

@section('page-title', 'Site Settings')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('site-settings.update') }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="site_name" :value="__('Site Name')" />
                            <x-text-input id="site_name" name="site_name" type="text" class="mt-1 block w-full" :value="old('site_name', $siteSetting->site_name ?? '')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('site_name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="hero_title" :value="__('Hero Title')" />
                            <x-text-input id="hero_title" name="hero_title" type="text" class="mt-1 block w-full" :value="old('hero_title', $siteSetting->hero_title ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('hero_title')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="hero_subtitle" :value="__('Hero Subtitle')" />
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('hero_subtitle', $siteSetting->hero_subtitle ?? '') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('hero_subtitle')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="hero_image" :value="__('Hero Image')" />
                            <x-text-input id="hero_image" name="hero_image" type="text" class="mt-1 block w-full" :value="old('hero_image', $siteSetting->hero_image ?? '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('hero_image')" />
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="stat_1_label" :value="__('Stat 1 Label')" />
                                    <x-text-input id="stat_1_label" name="stat_1_label" type="text" class="mt-1 block w-full" :value="old('stat_1_label', $siteSetting->stat_1_label ?? '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stat_1_label')" />
                                </div>
                                <div>
                                    <x-input-label for="stat_1_value" :value="__('Stat 1 Value')" />
                                    <x-text-input id="stat_1_value" name="stat_1_value" type="text" class="mt-1 block w-full" :value="old('stat_1_value', $siteSetting->stat_1_value ?? '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stat_1_value')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <x-input-label for="stat_2_label" :value="__('Stat 2 Label')" />
                                    <x-text-input id="stat_2_label" name="stat_2_label" type="text" class="mt-1 block w-full" :value="old('stat_2_label', $siteSetting->stat_2_label ?? '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stat_2_label')" />
                                </div>
                                <div>
                                    <x-input-label for="stat_2_value" :value="__('Stat 2 Value')" />
                                    <x-text-input id="stat_2_value" name="stat_2_value" type="text" class="mt-1 block w-full" :value="old('stat_2_value', $siteSetting->stat_2_value ?? '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stat_2_value')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <x-input-label for="stat_3_label" :value="__('Stat 3 Label')" />
                                    <x-text-input id="stat_3_label" name="stat_3_label" type="text" class="mt-1 block w-full" :value="old('stat_3_label', $siteSetting->stat_3_label ?? '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stat_3_label')" />
                                </div>
                                <div>
                                    <x-input-label for="stat_3_value" :value="__('Stat 3 Value')" />
                                    <x-text-input id="stat_3_value" name="stat_3_value" type="text" class="mt-1 block w-full" :value="old('stat_3_value', $siteSetting->stat_3_value ?? '')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('stat_3_value')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Update Settings') }}</x-primary-button>
                        </div>
                    </form>
        </div>
    </div>
@endsection
