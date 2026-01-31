<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $page->title ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="slug" :value="__('Slug')" />
        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $page->slug ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <div>
        <x-input-label for="meta_title" :value="__('Meta Title')" />
        <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" :value="old('meta_title', $page->meta_title ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('meta_title')" />
    </div>

    <div>
        <x-input-label for="layout" :value="__('Layout')" />
        <select id="layout" name="layout" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="public" {{ old('layout', $page->layout ?? 'public') === 'public' ? 'selected' : '' }}>Public</option>
            <option value="landing" {{ old('layout', $page->layout ?? '') === 'landing' ? 'selected' : '' }}>Landing</option>
            <option value="minimal" {{ old('layout', $page->layout ?? '') === 'minimal' ? 'selected' : '' }}>Minimal</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('layout')" />
    </div>
</div>

<div class="mt-4">
    <x-input-label for="meta_description" :value="__('Meta Description')" />
    <textarea id="meta_description" name="meta_description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('meta_description')" />
</div>

<div class="mt-4 flex items-center gap-6">
    <label class="flex items-center">
        <input type="checkbox" name="is_homepage" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_homepage', $page->is_homepage ?? false) ? 'checked' : '' }}>
        <span class="ml-2 text-sm text-gray-600">Set as Homepage</span>
    </label>

    <label class="flex items-center">
        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
        <span class="ml-2 text-sm text-gray-600">Active</span>
    </label>
</div>

<div class="flex items-center gap-4 mt-6">
    <x-primary-button>{{ isset($page) && $page->exists ? __('Update') : __('Create') }}</x-primary-button>
    <a href="{{ route('pages.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
</div>
