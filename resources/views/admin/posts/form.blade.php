<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post->title ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div class="mt-4">
    <x-input-label for="type" :value="__('Type')" />
    <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">Select a type</option>
        <option value="notice" {{ old('type', $post->type ?? '') == 'notice' ? 'selected' : '' }}>Notice</option>
        <option value="blog" {{ old('type', $post->type ?? '') == 'blog' ? 'selected' : '' }}>Blog</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('type')" />
</div>

<div class="mt-4">
    <x-input-label for="content" :value="__('Content')" />
    <textarea id="content" name="content" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('content', $post->content ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('content')" />
</div>

<div class="mt-4">
    <x-input-label for="publish_date" :value="__('Publish Date')" />
    <x-text-input id="publish_date" name="publish_date" type="datetime-local" class="mt-1 block w-full" :value="old('publish_date', isset($post) && $post->publish_date ? $post->publish_date->format('Y-m-d\TH:i') : '')" />
    <x-input-error class="mt-2" :messages="$errors->get('publish_date')" />
</div>

<div class="mt-4">
    <div class="flex items-center">
        <x-text-input id="is_active" name="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('is_active', isset($post) && $post->is_active ? true : false) ? 'checked' : '' }} />
        <x-input-label for="is_active" :value="__('Is Active')" class="ml-2" />
    </div>
    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
</div>

<div class="flex items-center gap-4 mt-6">
    <x-primary-button>{{ isset($post) ? __('Update') : __('Create') }}</x-primary-button>
    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
</div>
