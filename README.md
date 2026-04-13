# CHAZ — Churches Health Association of Zambia
## Laravel Website + Admin Dashboard

A fully redesigned, production-ready **Laravel 10** website for the Churches Health Association of Zambia (CHAZ), complete with a full admin management panel.

---

## 🚀 Quick Start

### Requirements
- PHP 8.1+
- Composer
- MySQL / MariaDB (SQLite also works for local dev)

### Installation

```bash
# 1. Extract and enter the project
cd chaz-website

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and configure
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your database in .env
#    DB_DATABASE=chaz_website
#    DB_USERNAME=root
#    DB_PASSWORD=yourpassword

# 6. Run migrations + seed default data
php artisan migrate --seed

# 7. Create storage symlink (for file uploads)
php artisan storage:link

# 8. Start the dev server
php artisan serve
```

Visit **http://localhost:8000** — public website  
Visit **http://localhost:8000/admin** — admin panel

---

## 🔐 Admin Access

| Field    | Value                  |
|----------|------------------------|
| URL      | `/admin/login`         |
| Email    | `admin@chaz.org.zm`    |
| Password | `Chaz@2024!`           |

> **Change the password immediately after first login** via Settings.

---

## 📁 Full Project Structure

```
chaz-website/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── NewsController.php
│   │   │   │   ├── JobsController.php
│   │   │   │   ├── TendersController.php
│   │   │   │   ├── MembersController.php
│   │   │   │   ├── DownloadsController.php
│   │   │   │   ├── MessagesController.php
│   │   │   │   └── SettingsController.php
│   │   │   ├── HomeController.php
│   │   │   ├── AboutController.php
│   │   │   ├── NewsController.php
│   │   │   ├── MembersController.php
│   │   │   ├── DownloadsController.php
│   │   │   ├── TendersController.php
│   │   │   ├── JobsController.php
│   │   │   └── ContactController.php
│   │   └── Middleware/
│   │       └── AdminAuthenticate.php
│   ├── Models/
│   │   ├── Admin.php
│   │   ├── News.php
│   │   ├── Job.php
│   │   ├── Tender.php
│   │   ├── Member.php
│   │   ├── Download.php
│   │   ├── ContactMessage.php
│   │   └── Setting.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/app.php
├── config/{app,cache,database,logging,mail,session,view}.php
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000001_create_chaz_tables.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
│   ├── css/app.css        ← Full design system
│   ├── js/app.js          ← Animations & interactivity
│   ├── index.php
│   └── .htaccess
├── resources/views/
│   ├── layouts/app.blade.php      ← Public layout
│   ├── home.blade.php
│   ├── about.blade.php
│   ├── about-board.blade.php
│   ├── members.blade.php
│   ├── gallery.blade.php
│   ├── contact.blade.php
│   ├── jobs.blade.php
│   ├── jobs-show.blade.php
│   ├── news/{index,show}.blade.php
│   ├── downloads/{index,publications,annual-reports,newsletters}.blade.php
│   ├── tenders/{index,sub-recipient-adverts}.blade.php
│   └── admin/
│       ├── layouts/app.blade.php  ← Admin layout (sidebar + topbar)
│       ├── auth/login.blade.php
│       ├── dashboard.blade.php
│       ├── news/{index,form}.blade.php
│       ├── jobs/{index,form}.blade.php
│       ├── tenders/{index,form}.blade.php
│       ├── members/{index,form}.blade.php
│       ├── downloads/{index,form}.blade.php
│       ├── messages/{index,show}.blade.php
│       └── settings/index.blade.php
└── routes/web.php         ← All public + admin routes
```

---

## 🌐 Public Pages

| Route | Page |
|-------|------|
| `/` | Home — hero, stats, achievements, news, CTAs |
| `/about` | About CHAZ — history, mission, programmes |
| `/about/board-of-trustees` | Board of Trustees |
| `/members` | Member institutions (filterable) |
| `/news` | News listing |
| `/news/{slug}` | Individual article |
| `/gallery` | Photo gallery |
| `/downloads` | Downloads hub |
| `/downloads/publications` | Publications |
| `/downloads/annual-reports` | Annual Reports |
| `/downloads/newsletters` | Newsletters + subscribe |
| `/tenders` | Active tenders |
| `/tenders/sub-recipient-adverts` | SR adverts |
| `/jobs` | Job listings |
| `/jobs/{id}` | Job detail + apply |
| `/contact` | Contact form |

---

## 🎛️ Admin Panel (`/admin`)

| Route | Feature |
|-------|---------|
| `/admin` | Dashboard — stats, quick actions, recent activity |
| `/admin/news` | News CRUD — create, edit, publish/draft, delete |
| `/admin/jobs` | Jobs CRUD — post, update status, close |
| `/admin/tenders` | Tenders CRUD — open/closed/awarded status |
| `/admin/members` | Members CRUD — all 162 institutions |
| `/admin/downloads` | Downloads CRUD — file upload support |
| `/admin/messages` | Inbox — view, reply by email, delete |
| `/admin/settings` | Site settings — name, contact, social links |

---

## 🗄️ Database Tables

| Table | Purpose |
|-------|---------|
| `admins` | Admin users with role-based access |
| `news` | News articles with draft/published status |
| `jobs` | Job postings with open/closed status |
| `tenders` | Procurement tenders |
| `sub_recipient_adverts` | Global Fund SR adverts |
| `members` | 162 member health institutions |
| `downloads` | Publications, reports & newsletters |
| `contact_messages` | Submitted contact form messages |
| `settings` | Key-value site configuration |

---

## 🎨 Design System

**Colours:** Forest Green `#1B4332` · Gold `#C9A84C` · Cream `#FAF7F0`  
**Fonts:** Playfair Display (headings) · DM Sans (body)  
**Features:** Responsive, sticky navbar, animated counters, fade-in on scroll, member filtering

---

## 📧 Email Configuration

Set `MAIL_*` values in `.env` to enable contact form email delivery.  
Uncomment the `Mail::to(...)` line in `ContactController.php`.

---

*Built with Laravel 10 · Churches Health Association of Zambia · © 2026*
