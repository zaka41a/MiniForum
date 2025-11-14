# 📸 MiniForum Screenshots Guide

This document provides guidelines for capturing screenshots for the MiniForum project.

## 📋 Required Screenshots

### 1. Banner Image (`banner.png`)
- **Size**: 1200x400px
- **Description**: Main project banner with logo and tagline
- **Content**: MiniForum logo, "Professional Q&A Platform" tagline, gradient background

### 2. Home Page (`home.png`)
- **Size**: 1400x900px (full page)
- **Description**: Landing page showing hero section and topic list
- **Capture**:
  - Hero section with "Welcome to MiniForum"
  - Search bar
  - Latest topics with badges (Open/Closed/Pinned)
  - Pagination
  - Professional navigation bar with logo

### 3. Topic View (`topic.png`)
- **Size**: 1400x1000px
- **Description**: Complete topic discussion page
- **Capture**:
  - Topic title with status badge
  - Topic body with Markdown formatting
  - Multiple replies with voting buttons
  - Vote scores
  - User avatars and names
  - Reply form (if logged in)

### 4. Admin Dashboard (`admin.png`)
- **Size**: 1400x1200px
- **Description**: Admin panel showing all management sections
- **Capture**:
  - Quick access cards (Users, Tags, Topics)
  - Users table with Edit/Save/Delete buttons
  - Tags management section
  - Topics table with Pin/Open-Close/Delete actions
  - Professional table styling

### 5. Moderator Panel (`mod.png`)
- **Size**: 1400x1000px
- **Description**: Moderator dashboard
- **Capture**:
  - Topics management section
  - Comments management table
  - Reset votes and Delete buttons
  - Post scores
  - Clean table layout

### 6. User Edit Page (`edit-user.png`)
- **Size**: 1000x900px
- **Description**: Admin user editing interface
- **Capture**:
  - User information card (ID, member since, reputation)
  - Edit form (Name, Email, Role)
  - Password change section
  - Warning message
  - Update/Cancel buttons

### 7. Login Page (`login.png`) - Optional
- **Size**: 800x700px
- **Description**: Login form
- **Capture**:
  - "Welcome Back" header
  - Email and Password fields
  - Login button
  - Link to registration

### 8. Register Page (`register.png`) - Optional
- **Size**: 800x700px
- **Description**: Registration form
- **Capture**:
  - "Create Account" header
  - Name, Email, Password fields
  - Create account button
  - Link to login

## 🎨 Screenshot Guidelines

### General Requirements

1. **Browser**: Use latest Chrome or Firefox
2. **Window Size**: Set to specified dimensions before capturing
3. **Zoom Level**: 100% (default)
4. **Sample Data**: Use realistic, professional demo data
5. **Theme**: Ensure indigo theme is properly displayed

### Quality Standards

- **Resolution**: High-DPI/Retina (2x) if possible
- **Format**: PNG with transparency where applicable
- **File Size**: Optimize (use TinyPNG or similar)
- **Naming**: Use exact names as specified above
- **Location**: Save all screenshots in `doc/screenshots/`

### Content Guidelines

#### For Topics/Posts
- Use meaningful titles (e.g., "How to structure a PHP forum?")
- Include varied content (questions, code snippets, discussions)
- Show different vote scores (positive, negative, neutral)
- Include realistic usernames

#### For User Data
- Use professional demo names (e.g., "John Doe", "Alice Smith")
- Use example email addresses (e.g., "john@example.com")
- Show different user roles (user, mod, admin)
- Include varied reputation scores

#### For Admin/Mod Panels
- Show tables with multiple entries (at least 5-7 items)
- Display various status badges (Open, Closed, Pinned)
- Include realistic dates and timestamps
- Show buttons in their default state

### Visual Consistency

- ✅ Ensure navbar logo is visible
- ✅ Show proper spacing and margins
- ✅ Capture hover states where relevant
- ✅ Include flash messages if applicable
- ✅ Show proper color scheme (indigo primary)

## 🛠️ Tools for Capturing

### Recommended Tools

1. **Browser DevTools**
   - Press F12 → Device Toolbar
   - Set custom dimensions
   - Capture full-page screenshots

2. **Screenshot Extensions**
   - Full Page Screen Capture (Chrome)
   - Fireshot (Chrome/Firefox)
   - Nimbus Screenshot (Cross-browser)

3. **OS Native Tools**
   - macOS: Cmd + Shift + 4 (selection)
   - Windows: Snipping Tool / Snip & Sketch
   - Linux: gnome-screenshot / Spectacle

### Post-Processing

1. **Crop & Resize**: Use exact dimensions
2. **Optimize**: Compress PNG files (TinyPNG, ImageOptim)
3. **Verify**: Check all images display correctly in README

## 📝 Checklist

Before committing screenshots:

- [ ] All 6 required screenshots captured
- [ ] Correct dimensions for each image
- [ ] Professional demo data used
- [ ] Files properly named
- [ ] Images optimized (< 500KB each)
- [ ] Saved in `doc/screenshots/` folder
- [ ] Tested in README.md preview
- [ ] Visual quality is high (no blur, proper colors)

## 🎯 Quick Capture Commands

```bash
# Navigate to screenshots directory
cd /Applications/XAMPP/xamppfiles/htdocs/MiniForum/doc/screenshots

# Verify all screenshots are present
ls -lh

# Expected files:
# - banner.png
# - home.png
# - topic.png
# - admin.png
# - mod.png
# - edit-user.png
```

## 📐 Banner Creation

For the banner image, you can create it using:

1. **Canva** (recommended for non-designers)
   - Template size: 1200x400px
   - Background: Gradient (indigo to purple)
   - Add MiniForum logo
   - Add tagline: "Professional Q&A Platform"

2. **Figma** (for designers)
   - Create artboard 1200x400px
   - Design with brand colors
   - Export as PNG @2x

3. **Photoshop/GIMP**
   - Canvas size: 1200x400px
   - Apply gradient overlay
   - Add text and logo
   - Export optimized PNG

---

**Note**: Screenshots should represent the current state of the application with all latest features implemented.
