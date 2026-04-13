# CHAZ Employee Portal — Drop-in Files

These are the 3 files you need to copy into your existing VS Code project.

---

## Files to Copy

| File (in this zip)                                          | Copy to (in your project)                                          |
|-------------------------------------------------------------|--------------------------------------------------------------------|
| `app/Http/Controllers/EmployeePortalController.php`        | `app/Http/Controllers/EmployeePortalController.php`               |
| `resources/views/employee-portal.blade.php`                | `resources/views/employee-portal.blade.php`                       |
| `ROUTES_SNIPPET.php`                                       | Open it and copy the route line into your `routes/web.php`        |

---

## Step-by-Step Instructions

### 1. Copy the Controller
Drag `app/Http/Controllers/EmployeePortalController.php` into your project's
`app/Http/Controllers/` folder.

### 2. Copy the View
Drag `resources/views/employee-portal.blade.php` into your project's
`resources/views/` folder.

### 3. Add the Route
Open `ROUTES_SNIPPET.php` and copy this line into your `routes/web.php`,
alongside the other public routes:

```php
use App\Http\Controllers\EmployeePortalController;

Route::get('/employee-portal', [EmployeePortalController::class, 'index'])->name('employee-portal');
```

### 4. Add to Navbar (optional but recommended)
Open `resources/views/layouts/app.blade.php` and find the navbar list.
Add this item before the Contact link:

```blade
<li class="navbar__item {{ request()->routeIs('employee-portal') ? 'active' : '' }}">
    <a href="{{ route('employee-portal') }}">Employee Portal</a>
</li>
```

### 5. Test
Visit: http://localhost:8000/employee-portal

---

## What's on the Page

Sourced from https://www.deel.com/glossary/employee-portal/ and extended for CHAZ:

**Sections:**
- Hero with sign-in form and live stats
- Quick access action buttons (8 shortcuts)
- "What is the portal?" explainer with key attributes
- 12 feature cards (all portal capabilities)
- 4 benefits (efficiency, engagement, transparency, cost)
- 6 analytics/metrics the portal measures
- Security & privacy section (6 controls)
- 4-step onboarding guide
- FAQ accordion (5 questions)
- CTA banner linking to sign-in and HR contact

**Features covered:**
- Personalised Dashboard
- Self-Service Profile
- Document Management (payslips, contracts, policies)
- Leave Management (submit, track, approve)
- Staff Noticeboard
- Training & Development (CPD, James Cairns Institute)
- Employee Directory
- Benefits & Medical Aid
- Performance Management
- Incident & Grievance Reporting
- Internal Communication
- Organisational Chart

No new dependencies required — uses the existing CHAZ design system.
