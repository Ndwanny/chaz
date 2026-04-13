-- ============================================================
-- CHAZ Full Database Schema
-- Churches Health Association of Zambia
-- Generated: 2026-04-09
-- Engine: MySQL 8.0+ / MariaDB 10.6+
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- ============================================================
-- EXISTING TABLES (from base project)
-- ============================================================

CREATE TABLE IF NOT EXISTS `admins` (
    `id`                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`                 VARCHAR(100)    NOT NULL,
    `email`                VARCHAR(150)    NOT NULL UNIQUE,
    `password`             VARCHAR(255)    NOT NULL,
    `role`                 ENUM('superadmin','editor') NOT NULL DEFAULT 'editor',
    -- New RBAC columns (added via migration 2026_04_08_000005)
    `role_id`              BIGINT UNSIGNED NULL,
    `department_id`        BIGINT UNSIGNED NULL,
    `staff_id`             VARCHAR(20)     NULL UNIQUE,
    `phone`                VARCHAR(20)     NULL,
    `avatar`               VARCHAR(255)    NULL,
    `is_active`            TINYINT(1)      NOT NULL DEFAULT 1,
    `two_fa_enabled`       TINYINT(1)      NOT NULL DEFAULT 0,
    `last_password_change` TIMESTAMP       NULL,
    `created_at`           TIMESTAMP       NULL,
    `updated_at`           TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    INDEX `admins_role_id_index` (`role_id`),
    INDEX `admins_department_id_index` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- RBAC
-- ============================================================

CREATE TABLE IF NOT EXISTS `roles` (
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `display_name` VARCHAR(100)    NOT NULL,
    `slug`         VARCHAR(60)     NOT NULL UNIQUE,
    `description`  TEXT            NULL,
    `level`        TINYINT         NOT NULL DEFAULT 5 COMMENT '1=highest (super_admin), 10=lowest',
    `is_active`    TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`   TIMESTAMP       NULL,
    `updated_at`   TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `permissions` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(100)    NOT NULL,
    `slug`       VARCHAR(60)     NOT NULL UNIQUE,
    `group`      VARCHAR(60)     NOT NULL DEFAULT 'general',
    `description` TEXT           NULL,
    `created_at` TIMESTAMP       NULL,
    `updated_at` TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id`       BIGINT UNSIGNED NOT NULL,
    `permission_id` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    FOREIGN KEY (`role_id`)       REFERENCES `roles`(`id`)       ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- DEPARTMENTS
-- ============================================================

CREATE TABLE IF NOT EXISTS `departments` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(100)    NOT NULL,
    `code`        VARCHAR(20)     NOT NULL UNIQUE,
    `type`        ENUM('head_office','provincial','district','field') NOT NULL DEFAULT 'head_office',
    `parent_id`   BIGINT UNSIGNED NULL,
    `head_id`     BIGINT UNSIGNED NULL,
    `location`    VARCHAR(150)    NULL,
    `description` TEXT            NULL,
    `is_active`   TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    INDEX `departments_parent_id_index` (`parent_id`),
    FOREIGN KEY (`parent_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- FK back-references (added after both tables exist)
ALTER TABLE `admins`
    ADD CONSTRAINT `admins_role_id_foreign`       FOREIGN KEY (`role_id`)       REFERENCES `roles`(`id`)       ON DELETE SET NULL,
    ADD CONSTRAINT `admins_department_id_foreign`  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL;

ALTER TABLE `departments`
    ADD CONSTRAINT `departments_head_id_foreign`   FOREIGN KEY (`head_id`)       REFERENCES `admins`(`id`)      ON DELETE SET NULL;

-- ============================================================
-- HR — EMPLOYEES
-- ============================================================

CREATE TABLE IF NOT EXISTS `employees` (
    `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `staff_number`      VARCHAR(20)     NOT NULL UNIQUE,
    `admin_id`          BIGINT UNSIGNED NULL COMMENT 'linked admin account if any',
    `department_id`     BIGINT UNSIGNED NULL,
    `salary_grade_id`   BIGINT UNSIGNED NULL,
    `first_name`        VARCHAR(60)     NOT NULL,
    `last_name`         VARCHAR(60)     NOT NULL,
    `other_names`       VARCHAR(60)     NULL,
    `gender`            ENUM('male','female') NOT NULL,
    `date_of_birth`     DATE            NULL,
    `national_id`       VARCHAR(20)     NULL,
    `email`             VARCHAR(150)    NULL UNIQUE,
    `phone`             VARCHAR(20)     NULL,
    `address`           TEXT            NULL,
    `city`              VARCHAR(80)     NULL,
    `next_of_kin_name`  VARCHAR(100)    NULL,
    `next_of_kin_phone` VARCHAR(20)     NULL,
    `next_of_kin_rel`   VARCHAR(60)     NULL,
    `job_title`         VARCHAR(100)    NOT NULL,
    `employment_type`   ENUM('permanent','contract','casual','intern') NOT NULL DEFAULT 'permanent',
    `employment_status` ENUM('active','on_leave','suspended','terminated','resigned') NOT NULL DEFAULT 'active',
    `hire_date`         DATE            NULL,
    `termination_date`  DATE            NULL,
    `bank_name`         VARCHAR(100)    NULL,
    `bank_account`      VARCHAR(30)     NULL,
    `bank_branch`       VARCHAR(100)    NULL,
    `tpin`              VARCHAR(20)     NULL COMMENT 'ZRA Tax PIN',
    `napsa_number`      VARCHAR(20)     NULL,
    `avatar`            VARCHAR(255)    NULL,
    `notes`             TEXT            NULL,
    `deleted_at`        TIMESTAMP       NULL,
    `created_at`        TIMESTAMP       NULL,
    `updated_at`        TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    INDEX `employees_department_id_index` (`department_id`),
    FOREIGN KEY (`admin_id`)        REFERENCES `admins`(`id`)       ON DELETE SET NULL,
    FOREIGN KEY (`department_id`)   REFERENCES `departments`(`id`)  ON DELETE SET NULL,
    FOREIGN KEY (`salary_grade_id`) REFERENCES `salary_grades`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- HR — LEAVE
-- ============================================================

CREATE TABLE IF NOT EXISTS `leave_types` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`             VARCHAR(80)     NOT NULL,
    `code`             VARCHAR(10)     NOT NULL UNIQUE,
    `days_allowed`     INT             NOT NULL DEFAULT 14,
    `is_paid`          TINYINT(1)      NOT NULL DEFAULT 1,
    `requires_document` TINYINT(1)    NOT NULL DEFAULT 0,
    `applicable_gender` ENUM('all','male','female') NOT NULL DEFAULT 'all',
    `description`      TEXT            NULL,
    `is_active`        TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `leave_requests` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`      BIGINT UNSIGNED NOT NULL,
    `leave_type_id`    BIGINT UNSIGNED NOT NULL,
    `start_date`       DATE            NOT NULL,
    `end_date`         DATE            NOT NULL,
    `days_requested`   INT             NOT NULL DEFAULT 1,
    `reason`           TEXT            NULL,
    `status`           ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
    `approved_by`      BIGINT UNSIGNED NULL,
    `approved_at`      TIMESTAMP       NULL,
    `rejection_reason` TEXT            NULL,
    `document_path`    VARCHAR(255)    NULL,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    INDEX `lr_employee_id_index` (`employee_id`),
    FOREIGN KEY (`employee_id`)   REFERENCES `employees`(`id`)   ON DELETE CASCADE,
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`approved_by`)   REFERENCES `admins`(`id`)      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `performance_reviews` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`    BIGINT UNSIGNED NOT NULL,
    `reviewer_id`    BIGINT UNSIGNED NULL,
    `review_period`  VARCHAR(60)     NOT NULL,
    `review_date`    DATE            NOT NULL,
    `rating`         DECIMAL(3,1)    NOT NULL DEFAULT 3.0,
    `goals_achieved` TEXT            NULL,
    `strengths`      TEXT            NULL,
    `improvements`   TEXT            NULL,
    `comments`       TEXT            NULL,
    `status`         ENUM('draft','submitted','acknowledged') NOT NULL DEFAULT 'draft',
    `created_at`     TIMESTAMP       NULL,
    `updated_at`     TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`reviewer_id`) REFERENCES `admins`(`id`)    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PAYROLL
-- ============================================================

CREATE TABLE IF NOT EXISTS `salary_grades` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code`        VARCHAR(10)     NOT NULL UNIQUE,
    `name`        VARCHAR(80)     NOT NULL,
    `min_salary`  DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `max_salary`  DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `description` TEXT            NULL,
    `is_active`   TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `salary_components` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`             VARCHAR(100)    NOT NULL,
    `code`             VARCHAR(20)     NOT NULL UNIQUE,
    `type`             ENUM('allowance','deduction','tax') NOT NULL,
    `calculation_type` ENUM('percentage','fixed') NOT NULL DEFAULT 'percentage',
    `value`            DECIMAL(10,4)   NOT NULL DEFAULT 0,
    `is_taxable`       TINYINT(1)      NOT NULL DEFAULT 0,
    `is_mandatory`     TINYINT(1)      NOT NULL DEFAULT 0,
    `applies_to`       ENUM('all','permanent','contract') NOT NULL DEFAULT 'all',
    `description`      TEXT            NULL,
    `is_active`        TINYINT(1)      NOT NULL DEFAULT 1,
    `sort_order`       INT             NOT NULL DEFAULT 0,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `employee_salaries` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `employee_id`     BIGINT UNSIGNED NOT NULL,
    `salary_grade_id` BIGINT UNSIGNED NULL,
    `basic_salary`    DECIMAL(12,2)   NOT NULL,
    `effective_date`  DATE            NOT NULL,
    `end_date`        DATE            NULL,
    `is_current`      TINYINT(1)      NOT NULL DEFAULT 0,
    `notes`           TEXT            NULL,
    `approved_by`     BIGINT UNSIGNED NULL,
    `created_at`      TIMESTAMP       NULL,
    `updated_at`      TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    INDEX `es_employee_id_index` (`employee_id`),
    FOREIGN KEY (`employee_id`)     REFERENCES `employees`(`id`)      ON DELETE CASCADE,
    FOREIGN KEY (`salary_grade_id`) REFERENCES `salary_grades`(`id`)  ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)     REFERENCES `admins`(`id`)         ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `payroll_periods` (
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `year`         SMALLINT        NOT NULL,
    `month`        TINYINT         NOT NULL,
    `name`         VARCHAR(60)     NOT NULL,
    `start_date`   DATE            NOT NULL,
    `end_date`     DATE            NOT NULL,
    `payment_date` DATE            NULL,
    `status`       ENUM('open','closed') NOT NULL DEFAULT 'open',
    `notes`        TEXT            NULL,
    `created_at`   TIMESTAMP       NULL,
    `updated_at`   TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `pp_year_month_unique` (`year`,`month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `payroll_runs` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `payroll_period_id` BIGINT UNSIGNED NOT NULL,
    `run_by`           BIGINT UNSIGNED NULL,
    `approved_by`      BIGINT UNSIGNED NULL,
    `status`           ENUM('draft','approved','paid','cancelled') NOT NULL DEFAULT 'draft',
    `total_gross`      DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `total_deductions` DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `total_net`        DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `employee_count`   INT             NOT NULL DEFAULT 0,
    `run_at`           TIMESTAMP       NULL,
    `approved_at`      TIMESTAMP       NULL,
    `notes`            TEXT            NULL,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`payroll_period_id`) REFERENCES `payroll_periods`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`run_by`)            REFERENCES `admins`(`id`)          ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)       REFERENCES `admins`(`id`)          ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `payslips` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `payroll_run_id`   BIGINT UNSIGNED NOT NULL,
    `employee_id`      BIGINT UNSIGNED NOT NULL,
    `basic_salary`     DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `total_allowances` DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `gross_salary`     DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `total_deductions` DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `net_salary`       DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `paye`             DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `napsa_employee`   DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `napsa_employer`   DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `nhima_employee`   DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `nhima_employer`   DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `status`           ENUM('pending','paid','cancelled') NOT NULL DEFAULT 'pending',
    `paid_at`          TIMESTAMP       NULL,
    `payment_method`   VARCHAR(30)     NULL,
    `payment_reference` VARCHAR(60)    NULL,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `payslips_run_employee_unique` (`payroll_run_id`,`employee_id`),
    FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`employee_id`)    REFERENCES `employees`(`id`)    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `payslip_items` (
    `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `payslip_id`          BIGINT UNSIGNED NOT NULL,
    `salary_component_id` BIGINT UNSIGNED NULL,
    `item_type`           ENUM('allowance','deduction','tax') NOT NULL,
    `name`                VARCHAR(100)    NOT NULL,
    `calculation_type`    ENUM('percentage','fixed') NOT NULL DEFAULT 'fixed',
    `rate`                DECIMAL(10,4)   NOT NULL DEFAULT 0,
    `amount`              DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `created_at`          TIMESTAMP       NULL,
    `updated_at`          TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`payslip_id`)          REFERENCES `payslips`(`id`)           ON DELETE CASCADE,
    FOREIGN KEY (`salary_component_id`) REFERENCES `salary_components`(`id`)  ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- INVENTORY
-- ============================================================

CREATE TABLE IF NOT EXISTS `item_categories` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(100)    NOT NULL,
    `code`        VARCHAR(20)     NOT NULL UNIQUE,
    `parent_id`   BIGINT UNSIGNED NULL,
    `description` TEXT            NULL,
    `is_active`   TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`parent_id`) REFERENCES `item_categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `suppliers` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`           VARCHAR(150)    NOT NULL,
    `code`           VARCHAR(20)     NOT NULL UNIQUE,
    `contact_person` VARCHAR(100)    NULL,
    `email`          VARCHAR(150)    NULL,
    `phone`          VARCHAR(20)     NULL,
    `address`        TEXT            NULL,
    `city`           VARCHAR(80)     NULL,
    `country`        VARCHAR(80)     NULL DEFAULT 'Zambia',
    `tax_number`     VARCHAR(30)     NULL,
    `bank_name`      VARCHAR(100)    NULL,
    `bank_account`   VARCHAR(30)     NULL,
    `payment_terms`  INT             NULL DEFAULT 30 COMMENT 'days',
    `category`       VARCHAR(60)     NULL,
    `rating`         DECIMAL(2,1)    NULL,
    `is_active`      TINYINT(1)      NOT NULL DEFAULT 1,
    `notes`          TEXT            NULL,
    `created_at`     TIMESTAMP       NULL,
    `updated_at`     TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `items` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`             VARCHAR(150)    NOT NULL,
    `code`             VARCHAR(30)     NOT NULL UNIQUE,
    `sku`              VARCHAR(50)     NULL UNIQUE,
    `category_id`      BIGINT UNSIGNED NOT NULL,
    `supplier_id`      BIGINT UNSIGNED NULL,
    `unit`             VARCHAR(20)     NOT NULL DEFAULT 'pcs',
    `unit_price`       DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `reorder_level`    INT             NOT NULL DEFAULT 5,
    `reorder_quantity` INT             NOT NULL DEFAULT 10,
    `description`      TEXT            NULL,
    `is_active`        TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `item_categories`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`)       ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `warehouses` (
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(100)    NOT NULL,
    `code`         VARCHAR(20)     NOT NULL UNIQUE,
    `location`     VARCHAR(150)    NULL,
    `department_id` BIGINT UNSIGNED NULL,
    `manager_id`   BIGINT UNSIGNED NULL,
    `capacity`     INT             NULL,
    `is_active`    TINYINT(1)      NOT NULL DEFAULT 1,
    `description`  TEXT            NULL,
    `created_at`   TIMESTAMP       NULL,
    `updated_at`   TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`manager_id`)    REFERENCES `admins`(`id`)      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `stock_entries` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id`        BIGINT UNSIGNED NOT NULL,
    `warehouse_id`   BIGINT UNSIGNED NOT NULL,
    `entry_type`     ENUM('in','out','adjustment') NOT NULL,
    `quantity`       DECIMAL(10,2)   NOT NULL,
    `unit_cost`      DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `total_cost`     DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `reference_type` VARCHAR(60)     NULL,
    `reference_id`   BIGINT UNSIGNED NULL,
    `batch_number`   VARCHAR(50)     NULL,
    `expiry_date`    DATE            NULL,
    `notes`          TEXT            NULL,
    `created_by`     BIGINT UNSIGNED NULL,
    `created_at`     TIMESTAMP       NULL,
    `updated_at`     TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    INDEX `se_item_id_index` (`item_id`),
    FOREIGN KEY (`item_id`)      REFERENCES `items`(`id`)      ON DELETE RESTRICT,
    FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`created_by`)   REFERENCES `admins`(`id`)     ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PROCUREMENT
-- ============================================================

CREATE TABLE IF NOT EXISTS `requisitions` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `req_number`      VARCHAR(20)     NOT NULL UNIQUE,
    `department_id`   BIGINT UNSIGNED NOT NULL,
    `requested_by`    BIGINT UNSIGNED NULL,
    `approved_by`     BIGINT UNSIGNED NULL,
    `status`          ENUM('pending','approved','rejected','converted') NOT NULL DEFAULT 'pending',
    `priority`        ENUM('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
    `required_by`     DATE            NULL,
    `purpose`         TEXT            NOT NULL,
    `notes`           TEXT            NULL,
    `approved_at`     TIMESTAMP       NULL,
    `rejected_reason` TEXT            NULL,
    `created_at`      TIMESTAMP       NULL,
    `updated_at`      TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`requested_by`)  REFERENCES `admins`(`id`)      ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)   REFERENCES `admins`(`id`)      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `requisition_items` (
    `id`                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `requisition_id`        BIGINT UNSIGNED NOT NULL,
    `item_id`               BIGINT UNSIGNED NULL,
    `description`           VARCHAR(200)    NOT NULL,
    `quantity`              DECIMAL(10,2)   NOT NULL,
    `unit`                  VARCHAR(20)     NOT NULL DEFAULT 'pcs',
    `estimated_unit_price`  DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `estimated_total`       DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `notes`                 TEXT            NULL,
    `created_at`            TIMESTAMP       NULL,
    `updated_at`            TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`requisition_id`) REFERENCES `requisitions`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`)        REFERENCES `items`(`id`)         ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `purchase_orders` (
    `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `po_number`         VARCHAR(20)     NOT NULL UNIQUE,
    `supplier_id`       BIGINT UNSIGNED NOT NULL,
    `requisition_id`    BIGINT UNSIGNED NULL,
    `department_id`     BIGINT UNSIGNED NULL,
    `requested_by`      BIGINT UNSIGNED NULL,
    `approved_by`       BIGINT UNSIGNED NULL,
    `status`            ENUM('draft','pending_approval','approved','ordered','delivered','cancelled') NOT NULL DEFAULT 'draft',
    `order_date`        DATE            NOT NULL,
    `expected_delivery` DATE            NULL,
    `delivery_date`     DATE            NULL,
    `total_amount`      DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `tax_amount`        DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `grand_total`       DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `currency`          CHAR(3)         NOT NULL DEFAULT 'ZMW',
    `exchange_rate`     DECIMAL(10,4)   NOT NULL DEFAULT 1,
    `payment_terms`     INT             NULL,
    `delivery_address`  TEXT            NULL,
    `notes`             TEXT            NULL,
    `approved_at`       TIMESTAMP       NULL,
    `created_at`        TIMESTAMP       NULL,
    `updated_at`        TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`supplier_id`)    REFERENCES `suppliers`(`id`)    ON DELETE RESTRICT,
    FOREIGN KEY (`requisition_id`) REFERENCES `requisitions`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`department_id`)  REFERENCES `departments`(`id`)  ON DELETE SET NULL,
    FOREIGN KEY (`requested_by`)   REFERENCES `admins`(`id`)       ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)    REFERENCES `admins`(`id`)       ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `purchase_order_items` (
    `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `purchase_order_id` BIGINT UNSIGNED NOT NULL,
    `item_id`           BIGINT UNSIGNED NULL,
    `description`       VARCHAR(200)    NOT NULL,
    `quantity`          DECIMAL(10,2)   NOT NULL,
    `unit`              VARCHAR(20)     NOT NULL DEFAULT 'pcs',
    `unit_price`        DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `discount`          DECIMAL(10,2)   NOT NULL DEFAULT 0,
    `tax_rate`          DECIMAL(5,2)    NOT NULL DEFAULT 0,
    `total_price`       DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `quantity_received` DECIMAL(10,2)   NOT NULL DEFAULT 0,
    `notes`             TEXT            NULL,
    `created_at`        TIMESTAMP       NULL,
    `updated_at`        TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`)           REFERENCES `items`(`id`)            ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- FLEET
-- ============================================================

CREATE TABLE IF NOT EXISTS `vehicle_categories` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(60)     NOT NULL,
    `description` TEXT            NULL,
    `is_active`   TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `vehicles` (
    `id`                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `registration`       VARCHAR(20)     NOT NULL UNIQUE,
    `make`               VARCHAR(60)     NOT NULL,
    `model`              VARCHAR(60)     NOT NULL,
    `year`               YEAR            NOT NULL,
    `color`              VARCHAR(30)     NULL,
    `category_id`        BIGINT UNSIGNED NOT NULL,
    `department_id`      BIGINT UNSIGNED NULL,
    `chassis_number`     VARCHAR(50)     NULL UNIQUE,
    `engine_number`      VARCHAR(50)     NULL,
    `fuel_type`          ENUM('petrol','diesel','electric','hybrid') NOT NULL DEFAULT 'diesel',
    `engine_capacity`    VARCHAR(20)     NULL,
    `seating_capacity`   TINYINT         NULL,
    `purchase_date`      DATE            NULL,
    `purchase_price`     DECIMAL(12,2)   NULL,
    `current_mileage`    INT             NULL DEFAULT 0 COMMENT 'km',
    `status`             ENUM('available','active','maintenance','out_of_service') NOT NULL DEFAULT 'available',
    `assigned_driver_id` BIGINT UNSIGNED NULL,
    `notes`              TEXT            NULL,
    `image`              VARCHAR(255)    NULL,
    `created_at`         TIMESTAMP       NULL,
    `updated_at`         TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)       REFERENCES `vehicle_categories`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`department_id`)     REFERENCES `departments`(`id`)         ON DELETE SET NULL,
    FOREIGN KEY (`assigned_driver_id`) REFERENCES `employees`(`id`)         ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `vehicle_insurance` (
    `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `vehicle_id`      BIGINT UNSIGNED NOT NULL,
    `insurer`         VARCHAR(100)    NOT NULL,
    `policy_number`   VARCHAR(60)     NOT NULL,
    `insurance_type`  ENUM('comprehensive','third_party','fire_and_theft') NOT NULL DEFAULT 'comprehensive',
    `start_date`      DATE            NOT NULL,
    `expiry_date`     DATE            NOT NULL,
    `premium_amount`  DECIMAL(12,2)   NOT NULL DEFAULT 0,
    `coverage_amount` DECIMAL(14,2)   NULL,
    `status`          ENUM('active','expired','cancelled','superseded') NOT NULL DEFAULT 'active',
    `document_path`   VARCHAR(255)    NULL,
    `notes`           TEXT            NULL,
    `created_at`      TIMESTAMP       NULL,
    `updated_at`      TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `trip_logs` (
    `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `trip_number`         VARCHAR(20)     NOT NULL UNIQUE,
    `vehicle_id`          BIGINT UNSIGNED NOT NULL,
    `driver_id`           BIGINT UNSIGNED NULL,
    `requested_by`        BIGINT UNSIGNED NULL,
    `approved_by`         BIGINT UNSIGNED NULL,
    `purpose`             TEXT            NOT NULL,
    `destination`         VARCHAR(200)    NOT NULL,
    `departure_location`  VARCHAR(200)    NOT NULL,
    `departure_datetime`  DATETIME        NOT NULL,
    `return_datetime`     DATETIME        NULL,
    `actual_departure`    DATETIME        NULL,
    `actual_return`       DATETIME        NULL,
    `start_mileage`       INT             NULL,
    `end_mileage`         INT             NULL,
    `distance_covered`    INT             NULL COMMENT 'km, computed on return',
    `passengers`          JSON            NULL,
    `status`              ENUM('pending','approved','ongoing','completed','cancelled') NOT NULL DEFAULT 'pending',
    `notes`               TEXT            NULL,
    `approved_at`         TIMESTAMP       NULL,
    `created_at`          TIMESTAMP       NULL,
    `updated_at`          TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vehicle_id`)   REFERENCES `vehicles`(`id`)   ON DELETE RESTRICT,
    FOREIGN KEY (`driver_id`)    REFERENCES `employees`(`id`)  ON DELETE SET NULL,
    FOREIGN KEY (`requested_by`) REFERENCES `admins`(`id`)     ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)  REFERENCES `admins`(`id`)     ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `fuel_logs` (
    `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `vehicle_id`     BIGINT UNSIGNED NOT NULL,
    `driver_id`      BIGINT UNSIGNED NULL,
    `date`           DATE            NOT NULL,
    `fuel_type`      ENUM('petrol','diesel') NOT NULL DEFAULT 'diesel',
    `quantity`       DECIMAL(8,2)    NOT NULL COMMENT 'litres',
    `unit_price`     DECIMAL(8,2)    NOT NULL,
    `total_cost`     DECIMAL(10,2)   NOT NULL,
    `mileage_before` INT             NULL,
    `mileage_after`  INT             NULL,
    `fuel_efficiency` DECIMAL(6,2)   NULL COMMENT 'km/litre',
    `station`        VARCHAR(100)    NULL,
    `receipt_number` VARCHAR(30)     NULL,
    `trip_id`        BIGINT UNSIGNED NULL,
    `notes`          TEXT            NULL,
    `recorded_by`    BIGINT UNSIGNED NULL,
    `created_at`     TIMESTAMP       NULL,
    `updated_at`     TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vehicle_id`)   REFERENCES `vehicles`(`id`)   ON DELETE RESTRICT,
    FOREIGN KEY (`driver_id`)    REFERENCES `employees`(`id`)  ON DELETE SET NULL,
    FOREIGN KEY (`trip_id`)      REFERENCES `trip_logs`(`id`)  ON DELETE SET NULL,
    FOREIGN KEY (`recorded_by`)  REFERENCES `admins`(`id`)     ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `maintenance_records` (
    `id`                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `vehicle_id`           BIGINT UNSIGNED NOT NULL,
    `maintenance_type`     ENUM('preventive','corrective','inspection','tyres','oil_change','service') NOT NULL,
    `description`          TEXT            NOT NULL,
    `service_date`         DATE            NOT NULL,
    `next_service_date`    DATE            NULL,
    `mileage_at_service`   INT             NULL,
    `next_service_mileage` INT             NULL,
    `cost`                 DECIMAL(10,2)   NOT NULL DEFAULT 0,
    `service_provider`     VARCHAR(150)    NULL,
    `invoice_number`       VARCHAR(30)     NULL,
    `status`               ENUM('pending','scheduled','in_progress','completed') NOT NULL DEFAULT 'pending',
    `performed_by`         BIGINT UNSIGNED NULL,
    `approved_by`          BIGINT UNSIGNED NULL,
    `notes`                TEXT            NULL,
    `created_at`           TIMESTAMP       NULL,
    `updated_at`           TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vehicle_id`)   REFERENCES `vehicles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`performed_by`) REFERENCES `admins`(`id`)   ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)  REFERENCES `admins`(`id`)   ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `driver_assignments` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `vehicle_id`  BIGINT UNSIGNED NOT NULL,
    `driver_id`   BIGINT UNSIGNED NOT NULL,
    `assigned_by` BIGINT UNSIGNED NULL,
    `start_date`  DATE            NOT NULL,
    `end_date`    DATE            NULL,
    `is_current`  TINYINT(1)      NOT NULL DEFAULT 1,
    `notes`       TEXT            NULL,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`vehicle_id`)  REFERENCES `vehicles`(`id`)   ON DELETE CASCADE,
    FOREIGN KEY (`driver_id`)   REFERENCES `employees`(`id`)  ON DELETE RESTRICT,
    FOREIGN KEY (`assigned_by`) REFERENCES `admins`(`id`)     ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- FINANCE
-- ============================================================

CREATE TABLE IF NOT EXISTS `budget_periods` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(80)     NOT NULL,
    `fiscal_year` VARCHAR(9)      NOT NULL COMMENT 'e.g. 2025/2026',
    `start_date`  DATE            NOT NULL,
    `end_date`    DATE            NOT NULL,
    `status`      ENUM('active','closed','draft') NOT NULL DEFAULT 'active',
    `notes`       TEXT            NULL,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `budgets` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `budget_period_id` BIGINT UNSIGNED NOT NULL,
    `department_id`    BIGINT UNSIGNED NOT NULL,
    `title`            VARCHAR(150)    NOT NULL,
    `total_allocated`  DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `total_spent`      DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `total_committed`  DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `status`           ENUM('draft','submitted','approved','closed') NOT NULL DEFAULT 'draft',
    `approved_by`      BIGINT UNSIGNED NULL,
    `approved_at`      TIMESTAMP       NULL,
    `notes`            TEXT            NULL,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `budgets_period_dept_unique` (`budget_period_id`,`department_id`),
    FOREIGN KEY (`budget_period_id`) REFERENCES `budget_periods`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`department_id`)    REFERENCES `departments`(`id`)    ON DELETE RESTRICT,
    FOREIGN KEY (`approved_by`)      REFERENCES `admins`(`id`)         ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `budget_lines` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `budget_id`        BIGINT UNSIGNED NOT NULL,
    `account_code`     VARCHAR(20)     NOT NULL,
    `description`      VARCHAR(150)    NOT NULL,
    `allocated_amount` DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `spent_amount`     DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `committed_amount` DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `notes`            TEXT            NULL,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`budget_id`) REFERENCES `budgets`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `expense_categories` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(80)     NOT NULL,
    `code`        VARCHAR(20)     NOT NULL UNIQUE,
    `description` TEXT            NULL,
    `is_active`   TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `expenses` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `exp_number`       VARCHAR(20)     NOT NULL UNIQUE,
    `category_id`      BIGINT UNSIGNED NOT NULL,
    `department_id`    BIGINT UNSIGNED NULL,
    `budget_id`        BIGINT UNSIGNED NULL,
    `employee_id`      BIGINT UNSIGNED NULL,
    `submitted_by`     BIGINT UNSIGNED NULL,
    `approved_by`      BIGINT UNSIGNED NULL,
    `title`            VARCHAR(200)    NOT NULL,
    `description`      TEXT            NULL,
    `amount`           DECIMAL(12,2)   NOT NULL,
    `currency`         CHAR(3)         NOT NULL DEFAULT 'ZMW',
    `exchange_rate`    DECIMAL(10,4)   NOT NULL DEFAULT 1,
    `amount_zmw`       DECIMAL(14,2)   NOT NULL DEFAULT 0,
    `expense_date`     DATE            NOT NULL,
    `payment_method`   ENUM('cash','bank_transfer','cheque','mobile_money') NULL,
    `receipt_path`     VARCHAR(255)    NULL,
    `status`           ENUM('pending','approved','paid','rejected') NOT NULL DEFAULT 'pending',
    `approved_at`      TIMESTAMP       NULL,
    `paid_at`          TIMESTAMP       NULL,
    `rejection_reason` TEXT            NULL,
    `notes`            TEXT            NULL,
    `created_at`       TIMESTAMP       NULL,
    `updated_at`       TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)   REFERENCES `expense_categories`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`)         ON DELETE SET NULL,
    FOREIGN KEY (`budget_id`)     REFERENCES `budgets`(`id`)             ON DELETE SET NULL,
    FOREIGN KEY (`employee_id`)   REFERENCES `employees`(`id`)           ON DELETE SET NULL,
    FOREIGN KEY (`submitted_by`)  REFERENCES `admins`(`id`)              ON DELETE SET NULL,
    FOREIGN KEY (`approved_by`)   REFERENCES `admins`(`id`)              ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- COMMUNICATIONS
-- ============================================================

CREATE TABLE IF NOT EXISTS `announcements` (
    `id`                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`              VARCHAR(200)    NOT NULL,
    `content`            TEXT            NOT NULL,
    `category`           ENUM('general','hr','finance','it','operations','event','urgent') NOT NULL DEFAULT 'general',
    `priority`           ENUM('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
    `target_audience`    ENUM('all','staff','management','department') NOT NULL DEFAULT 'all',
    `target_departments` JSON            NULL,
    `is_published`       TINYINT(1)      NOT NULL DEFAULT 0,
    `published_at`       TIMESTAMP       NULL,
    `expires_at`         TIMESTAMP       NULL,
    `created_by`         BIGINT UNSIGNED NULL,
    `updated_by`         BIGINT UNSIGNED NULL,
    `attachment_path`    VARCHAR(255)    NULL,
    `views_count`        INT             NOT NULL DEFAULT 0,
    `created_at`         TIMESTAMP       NULL,
    `updated_at`         TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`created_by`) REFERENCES `admins`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`updated_by`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- AUDIT
-- ============================================================

CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `admin_id`    BIGINT UNSIGNED NULL,
    `action`      VARCHAR(100)    NOT NULL,
    `model_type`  VARCHAR(80)     NULL,
    `model_id`    BIGINT UNSIGNED NULL,
    `old_values`  JSON            NULL,
    `new_values`  JSON            NULL,
    `ip_address`  VARCHAR(45)     NULL,
    `user_agent`  VARCHAR(255)    NULL,
    `url`         VARCHAR(500)    NULL,
    `created_at`  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `audit_admin_id_index` (`admin_id`),
    INDEX `audit_action_index` (`action`),
    FOREIGN KEY (`admin_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- End of CHAZ Full Schema (48 tables)
-- ============================================================
