<?php

// ─────────────────────────────────────────────────────────────────────────────
// ADD THIS LINE TO YOUR routes/web.php
// Place it with the other public routes (e.g. after the /contact route)
// ─────────────────────────────────────────────────────────────────────────────

use App\Http\Controllers\EmployeePortalController;

Route::get('/employee-portal', [EmployeePortalController::class, 'index'])->name('employee-portal');

// ─────────────────────────────────────────────────────────────────────────────
// Also add "Employee Portal" to your navbar in:
//   resources/views/layouts/app.blade.php
//
// Find the <ul class="navbar__list"> section and add before the Contact item:
//
//   <li class="navbar__item {{ request()->routeIs('employee-portal') ? 'active' : '' }}">
//       <a href="{{ route('employee-portal') }}">Employee Portal</a>
//   </li>
// ─────────────────────────────────────────────────────────────────────────────
