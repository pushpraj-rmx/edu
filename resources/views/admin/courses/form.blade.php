<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $course->title ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div class="mt-4">
    <x-input-label for="slug" :value="__('Slug')" />
    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $course->slug ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
</div>

<div class="mt-4">
    <x-input-label for="course_category_id" :value="__('Category')" />
    <select id="course_category_id" name="course_category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">Select a category</option>
        @foreach ($categories as $id => $name)
            <option value="{{ $id }}" {{ old('course_category_id', $course->course_category_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('course_category_id')" />
</div>

<div class="mt-4">
    <x-input-label for="duration" :value="__('Duration')" />
    <x-text-input id="duration" name="duration" type="text" class="mt-1 block w-full" :value="old('duration', $course->duration ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('duration')" />
</div>

<div class="mt-4">
    <x-input-label for="eligibility" :value="__('Eligibility')" />
    <x-text-input id="eligibility" name="eligibility" type="text" class="mt-1 block w-full" :value="old('eligibility', $course->eligibility ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('eligibility')" />
</div>

<div class="mt-4">
    <x-input-label for="intake" :value="__('Intake')" />
    <x-text-input id="intake" name="intake" type="number" class="mt-1 block w-full" :value="old('intake', $course->intake ?? '')" />
    <x-input-error class="mt-2" :messages="$errors->get('intake')" />
</div>

<div class="mt-4">
    <x-input-label for="description" :value="__('Description')" />
    <textarea id="description" name="description" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $course->description ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

<div class="mt-4">
    <x-input-label for="syllabus_pdf" :value="__('Syllabus PDF')" />
    <x-text-input id="syllabus_pdf" name="syllabus_pdf" type="file" class="mt-1 block w-full" />
    <x-input-error class="mt-2" :messages="$errors->get('syllabus_pdf')" />
    @if (isset($course) && $course->syllabus_pdf)
        <p class="mt-1 text-sm text-gray-600">Current: {{ $course->syllabus_pdf }}</p>
    @endif
</div>

<div class="flex items-center gap-4 mt-6">
    <x-primary-button>{{ isset($course) ? __('Update') : __('Create') }}</x-primary-button>
    <a href="{{ route('courses.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
</div>
