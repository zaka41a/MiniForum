# 💬 MiniForum

> A modern, professional Questions & Answers forum platform built with native PHP

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![Status](https://img.shields.io/badge/status-active-success.svg?style=flat-square)]()

![MiniForum Banner](doc/screenshots/scr.png)

## 🌟 Overview

**MiniForum** is a lightweight yet powerful Q&A forum platform built entirely with native PHP. It combines modern UI/UX design with robust backend functionality, offering a complete solution for community discussions, knowledge sharing, and collaborative problem-solving.

Perfect for educational purposes, community forums, internal knowledge bases, or as a learning project to understand modern PHP development patterns.

---

## ✨ Features

### 🎯 Core Functionality

- **📝 Topics & Posts**
  - Create, view, and reply to discussion topics
  - Full Markdown support for rich content formatting
  - Real-time topic status management (Open/Closed)
  - Pin important topics to the top

- **⬆️ Voting System**
  - Upvote/downvote posts with AJAX
  - Real-time score calculation
  - Reputation tracking for users
  - Vote management for moderators

- **🔍 Search & Discovery**
  - Full-text search across topics
  - Tag-based filtering and organization
  - Smart slug-based URLs for SEO
  - Pagination with customizable page size

- **👥 User Management**
  - Secure registration and authentication
  - Three role levels: User, Moderator, Admin
  - Profile pages with activity tracking
  - Password hashing with bcrypt

### 🛡️ Administration & Moderation

#### 👑 Admin Panel (`/panel/admin`)
- **User Management**
  - Edit user information (name, email, role)
  - Change user passwords
  - Assign roles (User/Mod/Admin)
  - Delete users

- **Tag Management**
  - Create and delete tags
  - Organize content categories

- **Topic Control**
  - Pin/unpin topics
  - Open/close discussions
  - Delete topics with cascading cleanup
  - View all topics with advanced filtering

#### 🛠️ Moderator Panel (`/panel/mod`)
- **Comment Moderation**
  - Delete inappropriate comments
  - Reset vote counts
  - View recent posts with scores

- **Topic Management**
  - Open/close topics
  - Monitor community discussions

### 🎨 Modern UI/UX

- **Professional Design**
  - Clean, modern interface with indigo theme
  - Glassmorphism effects and smooth animations
  - Responsive layout (mobile-first approach)
  - Gradient accents and elegant shadows

- **Interactive Elements**
  - Hover effects on all interactive components
  - Real-time feedback for user actions
  - Flash messages for confirmations
  - Loading states and transitions

- **Accessibility**
  - Semantic HTML structure
  - Keyboard navigation support
  - High contrast ratios
  - Screen reader friendly

---
## 🚀 Quick Start

### Prerequisites

- **PHP 7.4+** (PHP 8.x recommended)
- **MySQL 5.7+** or **MariaDB 10.3+**
- **Apache 2.4+** with `mod_rewrite` enabled
- **Composer** (optional, for future dependencies)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/miniforum.git
   cd miniforum
   ```

2. **Configure Apache**

   Ensure your Apache virtual host or XAMPP points to the `public/` directory:
   ```apache
   DocumentRoot "/Applications/XAMPP/xamppfiles/htdocs/MiniForum/public"
   <Directory "/Applications/XAMPP/xamppfiles/htdocs/MiniForum/public">
       AllowOverride All
       Require all granted
   </Directory>
   ```

3. **Import Database**

   Create a database and import the SQL schema:
   ```bash
   mysql -u root -p
   CREATE DATABASE miniforum CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE miniforum;
   SOURCE bin/schema.sql;
   ```

4. **Configure Database Connection**

   Edit `config/config.php`:
   ```php
   'db' => [
     'dsn'  => 'mysql:host=localhost;dbname=miniforum;charset=utf8mb4',
     'user' => 'root',
     'pass' => '',
     'options' => [
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     ]
   ]
   ```

5. **Set Permissions**
   ```bash
   chmod -R 755 storage/
   chmod -R 777 storage/logs/
   ```

6. **Access the Application**

   Open your browser and navigate to:
   ```
   http://localhost/MiniForum/
   ```

---

## 📁 Project Structure

```
MiniForum/
├── app/
│   ├── Controllers/        # Request handlers
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── PanelController.php
│   │   ├── PostController.php
│   │   ├── TopicController.php
│   │   └── VoteController.php
│   │
│   ├── Models/             # Data layer
│   │   ├── Post.php
│   │   ├── Tag.php
│   │   ├── Topic.php
│   │   ├── User.php
│   │   └── Vote.php
│   │
│   ├── Views/              # Presentation layer
│   │   ├── auth/           # Login, Register
│   │   ├── panel/          # Admin, Mod, User panels
│   │   ├── topics/         # Topic views
│   │   └── layout.php      # Main layout template
│   │
│   ├── Core/               # Framework components
│   │   ├── Container.php   # Dependency injection
│   │   ├── Router.php      # URL routing
│   │   ├── View.php        # Template rendering
│   │   └── Helpers.php     # Utility functions
│   │
│   └── Services/           # Business logic
│       ├── Auth.php
│       ├── Markdown.php
│       ├── RateLimiter.php
│       └── Mailer.php
│
├── config/
│   ├── config.php          # Main configuration
│   ├── database.php        # Database factory
│   └── routes.php          # Route definitions
│
├── public/                 # Web root
│   ├── assets/
│   │   ├── app.css         # Compiled styles
│   │   ├── app.js          # Frontend logic
│   │   └── logo.svg        # Brand assets
│   ├── favicon.svg
│   ├── .htaccess
│   └── index.php           # Entry point
│
├── storage/
│   └── logs/               # Application logs
│
├── bin/
│   └── schema.sql          # Database schema
│
├── doc/
│   └── screenshots/        # Project screenshots
│
└── README.md               # This file
```

---

## 🔧 Configuration

### Database Setup

The database configuration is located in `config/config.php`. You can customize:

- **Host**: Database server address
- **Database**: Database name
- **User/Password**: Credentials
- **Charset**: UTF-8 encoding

### Session Configuration

```php
'session_name' => 'miniforum_session',
'session_lifetime' => 86400, // 24 hours
```

### Security Settings

- **CSRF Protection**: Enabled by default on all POST requests
- **Password Hashing**: Bcrypt with default cost factor
- **XSS Prevention**: All user input escaped with `htmlspecialchars()`
- **SQL Injection**: Prepared statements with PDO

---

## 🎨 Customization

### Theme Colors

Edit `public/assets/app.css` to customize the color scheme:

```css
:root {
  --primary: #6366f1;        /* Indigo */
  --primary-600: #5457e3;    /* Darker indigo */
  --success: #10b981;        /* Green */
  --warning: #f59e0b;        /* Orange */
  --danger: #ef4444;         /* Red */
}
```

### Logo

Replace `public/assets/logo.svg` and `public/favicon.svg` with your own branding.

---

## 👥 User Roles & Permissions

| Feature                  | User | Moderator | Admin |
|--------------------------|------|-----------|-------|
| Create Topics            | ✅   | ✅        | ✅    |
| Reply to Topics          | ✅   | ✅        | ✅    |
| Vote on Posts            | ✅   | ✅        | ✅    |
| Delete Own Comments      | ❌   | ❌        | ❌    |
| Delete Any Comment       | ❌   | ✅        | ✅    |
| Reset Votes              | ❌   | ✅        | ✅    |
| Open/Close Topics        | ❌   | ✅        | ✅    |
| Pin Topics               | ❌   | ❌        | ✅    |
| Manage Users             | ❌   | ❌        | ✅    |
| Edit User Passwords      | ❌   | ❌        | ✅    |
| Manage Tags              | ❌   | ❌        | ✅    |
| Delete Topics            | ❌   | ❌        | ✅    |

---

## 🛣️ API Routes

### Public Routes

```
GET  /                              # Home page
GET  /topics                        # Topics list
GET  /topics/{id}-{slug}            # View topic
GET  /login                         # Login form
POST /login                         # Authenticate
GET  /register                      # Registration form
POST /register                      # Create account
```

### Authenticated Routes

```
GET  /topics/new                    # Create topic form
POST /topics/create                 # Save new topic
POST /topics/{id}/reply             # Reply to topic
POST /posts/{id}/vote               # Vote on post
POST /logout                        # Logout
GET  /me                            # User profile
```

### Moderator Routes

```
GET  /panel/mod                     # Mod dashboard
POST /panel/mod/topics/{id}/toggle  # Open/close topic
POST /panel/mod/votes/{id}/reset    # Reset post votes
POST /panel/mod/posts/{id}/delete   # Delete comment
```

### Admin Routes

```
GET  /panel/admin                         # Admin dashboard
GET  /panel/admin/users/{id}/edit         # Edit user form
POST /panel/admin/users/{id}/update       # Update user
POST /panel/admin/users/{id}/role         # Change role
POST /panel/admin/users/{id}/delete       # Delete user
POST /panel/admin/tags/create             # Create tag
POST /panel/admin/tags/{id}/delete        # Delete tag
POST /panel/admin/topics/{id}/pin         # Pin topic
POST /panel/admin/topics/{id}/toggle      # Open/close topic
POST /panel/admin/topics/{id}/delete      # Delete topic
```

---

## 🔐 Security Features

- ✅ **CSRF Protection** on all forms
- ✅ **Password Hashing** with bcrypt
- ✅ **XSS Prevention** via output escaping
- ✅ **SQL Injection** prevention with prepared statements
- ✅ **Session Security** with regeneration
- ✅ **Role-Based Access Control** (RBAC)
- ✅ **Input Validation** and sanitization
- ✅ **Rate Limiting** ready for implementation

---

## 📚 Technologies Used

### Backend
- **PHP 7.4+** - Server-side programming
- **PDO** - Database abstraction layer
- **MySQL** - Relational database
- **Native Sessions** - User authentication

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with custom properties
- **Vanilla JavaScript** - AJAX voting system
- **SVG** - Scalable vector graphics

### Architecture
- **MVC Pattern** - Model-View-Controller separation
- **Dependency Injection** - Container-based DI
- **Router** - Clean URL routing
- **Template Engine** - Simple PHP-based views

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Code Standards

- Follow PSR-12 coding standards
- Write descriptive commit messages
- Add comments for complex logic
- Test your changes thoroughly

---

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- Inspired by modern forum platforms like Discourse and Stack Overflow
- Icons and graphics designed with SVG for scalability
- Built with ❤️ using native PHP (no frameworks)

---

## 📧 Contact & Support

- **Author**: Your Name
- **Email**: your.email@example.com
- **GitHub**: [@yourusername](https://github.com/yourusername)
- **Issues**: [Report a bug](https://github.com/yourusername/miniforum/issues)

---

## 🗺️ Roadmap

### Version 2.0 (Planned)
- [ ] Real-time notifications
- [ ] Email verification
- [ ] Two-factor authentication (2FA)
- [ ] File attachments support
- [ ] User mentions (@username)
- [ ] Advanced search filters
- [ ] Dark mode theme
- [ ] REST API for mobile apps
- [ ] OAuth integration (Google, GitHub)
- [ ] Activity feed

### Version 1.1 (Current)
- [x] Modern UI/UX redesign
- [x] Admin user management
- [x] Moderator comment deletion
- [x] Password change functionality
- [x] Professional logo and favicon
- [x] Responsive design
- [x] Enhanced security

---

<div align="center">

**Made with 💻 and ☕**

⭐ Star this repository if you find it helpful!

[Report Bug](https://github.com/yourusername/miniforum/issues) • [Request Feature](https://github.com/yourusername/miniforum/issues)

</div>
