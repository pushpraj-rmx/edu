<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $offering->title ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div class="mt-4">
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $offering->slug ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
</div>

<div class="mt-4">
    <x-input-label for="type" :value="__('Type')" />
    <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="filterCategoriesAndTags()">
        <option value="">Select a type</option>
        <option value="course" {{ old('type', $offering->type ?? '') == 'course' ? 'selected' : '' }}>Course</option>
        <option value="service" {{ old('type', $offering->type ?? '') == 'service' ? 'selected' : '' }}>Service</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('type')" />
</div>

<div class="mt-4">
    <x-input-label for="category_id" :value="__('Category')" />
    <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">Select a category</option>
        @foreach ($categories as $id => $name)
            <option value="{{ $id }}" data-type="{{ \App\Models\Category::find($id)->type ?? '' }}" {{ old('category_id', $offering->category_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
</div>

<div class="mt-4">
    <x-input-label for="duration" :value="__('Duration')" />
    <x-text-input id="duration" name="duration" type="text" class="mt-1 block w-full" :value="old('duration', $offering->duration ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('duration')" />
</div>

<div class="mt-4">
    <x-input-label for="eligibility" :value="__('Eligibility')" />
    <x-text-input id="eligibility" name="eligibility" type="text" class="mt-1 block w-full" :value="old('eligibility', $offering->eligibility ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('eligibility')" />
</div>

<div class="mt-4">
    <x-input-label for="intake" :value="__('Intake')" />
    <x-text-input id="intake" name="intake" type="number" class="mt-1 block w-full" :value="old('intake', $offering->intake ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('intake')" />
</div>

<div class="mt-4">
    <x-input-label for="description" :value="__('Description')" />
    <textarea id="description" name="description" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $offering->description ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

<div class="mt-4">
    <x-input-label for="brochure_pdf" :value="__('Brochure PDF')" />
    <x-text-input id="brochure_pdf" name="brochure_pdf" type="file" class="mt-1 block w-full" />
    <x-input-error class="mt-2" :messages="$errors->get('brochure_pdf')" />
    @if (isset($offering) && $offering->brochure_pdf)
        <p class="mt-1 text-sm text-gray-600">Current: {{ $offering->brochure_pdf }}</p>
    @endif
</div>

<div class="mt-4">
    <x-input-label for="tags" :value="__('Tags')" />
    <select id="tags" name="tags[]" multiple class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach ($tags as $id => $name)
            <option value="{{ $id }}" data-type="{{ \App\Models\Tag::find($id)->type ?? '' }}" {{ (isset($offering) && $offering->tags->contains($id)) || in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('tags')" />
</div>

<div class="mt-4">
    <x-input-label for="meta_title" :value="__('Meta Title')" />
    <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" :value="old('meta_title', $offering->meta_title ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('meta_title')" />
</div>

<div class="mt-4">
    <x-input-label for="meta_description" :value="__('Meta Description')" />
    <textarea id="meta_description" name="meta_description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('meta_description', $offering->meta_description ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('meta_description')" />
</div>

<div class="flex items-center gap-4 mt-6">
    <x-primary-button>{{ isset($offering) ? __('Update') : __('Create') }}</x-primary-button>
    <a href="{{ route('offerings.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
</div>

<script>
function filterCategoriesAndTags() {
    const type = document.getElementById('type').value;
    const categorySelect = document.getElementById('category_id');
    const tagSelect = document.getElementById('tags');
    
    // Filter categories
    Array.from(categorySelect.options).forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = option.dataset.type === type ? 'block' : 'none';
            if (option.dataset.type !== type && option.selected) {
                option.selected = false;
            }
        }
    });
    
    // Filter tags
    Array.from(tagSelect.options).forEach(option => {
        option.style.display = option.dataset.type === type ? 'block' : 'none';
        if (option.dataset.type !== type && option.selected) {
            option.selected = false;
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    if (typeSelect.value) {
        filterCategoriesAndTags();
    }
});
</script>
