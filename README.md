# MiniForum (PHP + MySQL)

A minimal forum built with **native PHP 8** (no framework) and **MySQL**.  
Features login/registration, topics, posts, votes, tags, and role-based dashboards
(**admin**, **moderator**, **user**). The UI is light theme, with SVG icons.

---

## Features

- Public home page with:
  - Search bar
  - Topics list (status + “view” button)
  - “New Topic” button (redirects to login if not authenticated)

- Authentication
  - Register / Login / Logout (CSRF protected)
  - Post-login redirect: `admin → /admin`, `mod → /moderator`, `user → /me`

- Topics & Posts
  - Create topic (title + body)
  - Reply to a topic
  - Up/Down votes per post (1 vote per user, upsert)
  - Open/Close topic (admin/mod)

- Admin dashboard
  - Manage users (change role: user/mod/admin)
  - Manage topics (open/close, pin/unpin, delete)
  - Manage tags (create/delete)

- Moderator dashboard
  - Open/Close topics
  - Delete posts

- User space
  - Minimal “My space” page (you can extend later)

- Security
  - CSRF tokens on every POST
  - Simple session-based auth
  - Basic escaping in views

---

## Tech

- PHP 8.1+ (native, no framework)
- MySQL 5.7+/8 (InnoDB, utf8mb4)
- HTML/CSS/vanilla JS
- Simple DI container



