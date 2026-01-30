<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $courseCategory->name ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div class="mt-4">
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $courseCategory->slug ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
</div>

<div class="flex items-center gap-4 mt-6">
    <x-primary-button>{{ isset($courseCategory) ? __('Update') : __('Create') }}</x-primary-button>
    <a href="{{ route('course-categories.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
</div>
