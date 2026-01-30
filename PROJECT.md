# Day 1

Good. Structured day = fast week. Random clicking = 3 extra weeks of regret.

Today is **Foundation + Core CMS Skeleton**.
By night, you should have **admin login + page CMS + course system working**.

Follow this in order. Don’t freestyle.

---

# 🟢 DAY 1 GOAL

**Working Laravel app with Admin Panel and 2 CMS modules live**

---

## 🧱 PART 1 — Project & Auth Setup

### ✅ Task 1 — Create Project

```bash
composer create-project laravel/laravel mgvimt-portal
cd mgvimt-portal
```

Set `.env` database credentials.

```bash
php artisan migrate
php artisan serve
```

🧠 **Hint:** If DB fails, fix this first. Nothing works without DB.

---

### ✅ Task 2 — Install Admin Auth (Breeze)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
```

Visit `/login` → register your admin user.

🧠 **Hint:** Later we disable public registration. For now it's fine.

---

## 🧱 PART 2 — Admin Area Structure

### ✅ Task 3 — Create Admin Route Group

Edit `routes/web.php`

```php
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');
});
```

Create file:
`resources/views/admin/dashboard.blade.php`

Simple text: **Admin Dashboard**

Test `/admin` after login.

🧠 **Hint:** If this works, your auth + middleware pipeline is correct.

---

## 🧱 PART 3 — Pages CMS (Most Important System)

This will power About, Director Message, Exam Info, etc.

### ✅ Task 4 — Create Model + Migration

```bash
php artisan make:model Page -mcr
```

Edit migration:

```php
$table->string('title');
$table->string('slug')->unique();
$table->longText('content')->nullable();
$table->string('meta_title')->nullable();
$table->text('meta_description')->nullable();
$table->timestamps();
```

Run:

```bash
php artisan migrate
```

---

### ✅ Task 5 — Add Fillable Fields

`app/Models/Page.php`

```php
protected $fillable = [
    'title','slug','content','meta_title','meta_description'
];
```

---

### ✅ Task 6 — Add Admin Resource Route

Inside admin group:

```php
Route::resource('pages', PageController::class);
```

---

### ✅ Task 7 — Build PageController Basic CRUD

In `store()` and `update()` add:

```php
$request->validate([
    'title' => 'required',
    'slug' => 'required|unique:pages,slug,' . $page->id ?? 'NULL',
]);
```

Use `Page::create($request->all());`

🧠 **Hint:** Keep logic simple. No services layer yet.

---

### ✅ Task 8 — Create Blade Views for Pages

Create folder:
`resources/views/admin/pages/`

Make:

-   index.blade.php
-   create.blade.php
-   edit.blade.php
-   form.blade.php (shared form)

Form fields:

-   Title
-   Slug
-   Content (textarea)
-   Meta title
-   Meta description

🧠 **Hint:** Don’t style. Just make it work.

---

## 🧱 PART 4 — Course System

### ✅ Task 9 — Course Categories

```bash
php artisan make:model CourseCategory -mcr
```

Fields:

```php
$table->string('name');
$table->string('slug')->unique();
```

Add resource route:

```php
Route::resource('course-categories', CourseCategoryController::class);
```

Create basic CRUD views like Pages.

---

### ✅ Task 10 — Courses

```bash
php artisan make:model Course -mcr
```

Fields:

```php
$table->string('title');
$table->string('slug')->unique();
$table->foreignId('course_category_id')->constrained();
$table->string('duration')->nullable();
$table->string('eligibility')->nullable();
$table->integer('intake')->nullable();
$table->longText('description')->nullable();
$table->string('syllabus_pdf')->nullable();
$table->timestamps();
```

Run migrate.

---

### ✅ Task 11 — Relationships

**Course Model**

```php
public function category() {
    return $this->belongsTo(CourseCategory::class,'course_category_id');
}
```

**CourseCategory Model**

```php
public function courses() {
    return $this->hasMany(Course::class);
}
```

---

### ✅ Task 12 — Course Admin CRUD

Add route:

```php
Route::resource('courses', CourseController::class);
```

Form fields:

-   Title
-   Slug
-   Category dropdown
-   Duration
-   Eligibility
-   Intake
-   Description
-   PDF upload (just input for now, we wire upload later)

🧠 **Hint:** Use `CourseCategory::pluck('name','id')` for dropdown.

---

## 🧱 PART 5 — Connect One Public Page

### ✅ Task 13 — Show Dynamic Page

Add route:

```php
Route::get('/page/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug',$slug)->firstOrFail();
    return view('page', compact('page'));
});
```

Create `resources/views/page.blade.php`

```blade
<h1>{{ $page->title }}</h1>
{!! $page->content !!}
```

Now create a page in admin with slug `about-institute`
Visit `/page/about-institute`

Boom. CMS is alive.

---

# 🎯 END OF DAY SUCCESS CHECKLIST

You win Day 1 if:

✔ Admin login works
✔ `/admin` dashboard loads
✔ Pages CRUD works
✔ Course Categories CRUD works
✔ Courses CRUD works
✔ You can create a page and view it publicly

If these are done, the **project foundation is officially solid**.

Tomorrow we add:

-   Notices
-   Specializations
-   Homepage CMS sections

Today = structure. No overdesign. Just working systems.
