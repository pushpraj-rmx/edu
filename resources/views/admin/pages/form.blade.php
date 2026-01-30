<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $page->title ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div class="mt-4">
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $page->slug ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
</div>

<div class="mt-4">
    <x-input-label for="content" :value="__('Content')" />
    <textarea id="content" name="content" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content', $page->content ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('content')" />
</div>

<div class="mt-4">
    <x-input-label for="meta_title" :value="__('Meta Title')" />
    <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" :value="old('meta_title', $page->meta_title ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('meta_title')" />
</div>

<div class="mt-4">
    <x-input-label for="meta_description" :value="__('Meta Description')" />
    <textarea id="meta_description" name="meta_description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('meta_description')" />
</div>

<div class="flex items-center gap-4 mt-6">
    <x-primary-button>{{ isset($page) ? __('Update') : __('Create') }}</x-primary-button>
    <a href="{{ route('pages.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
</div>
