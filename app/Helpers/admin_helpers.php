<?php

if (!function_exists('admin_can')) {
    /**
     * Check if the currently logged-in admin has a permission slug.
     */
    function admin_can(string $slug): bool
    {
        $permissions = session('admin_permissions', []);
        if (in_array('super_admin', $permissions)) return true;
        return in_array($slug, $permissions);
    }
}

if (!function_exists('admin_is')) {
    /**
     * Check if the current admin has a specific role slug.
     */
    function admin_is(string ...$roles): bool
    {
        $role = session('admin_role', '');
        return in_array($role, $roles);
    }
}

if (!function_exists('admin_name')) {
    function admin_name(): string
    {
        return session('admin_name', 'Admin');
    }
}

if (!function_exists('admin_id')) {
    function admin_id(): ?int
    {
        return session('admin_id');
    }
}

if (!function_exists('admin_department_id')) {
    function admin_department_id(): ?int
    {
        return session('admin_department');
    }
}

if (!function_exists('format_zmw')) {
    /**
     * Format amount as Zambian Kwacha.
     */
    function format_zmw(float $amount, int $decimals = 2): string
    {
        return 'ZMW ' . number_format($amount, $decimals);
    }
}
