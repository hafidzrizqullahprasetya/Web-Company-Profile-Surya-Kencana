# 📸 Automated Screenshot Generator for User Manual

This tool automatically captures all screenshots needed for the User Manual (user-manual.tex) using Playwright automation.

## 🎯 Features

- ✅ Automatically captures **40+ screenshots** covering:
  - Frontend pages (homepage, sections, responsive views)
  - Admin dashboard (all management pages)
  - Forms (add, edit, delete)
  - Mobile responsive views
  - UI components (navbar, footer, buttons, etc.)

- ✅ Saves screenshots to `user-manual/images/` with names matching the LaTeX document references
- ✅ Configurable via JSON file
- ✅ Handles authentication automatically
- ✅ Supports both desktop and mobile viewports

## 📋 Prerequisites

1. **Development server must be running**:
   ```bash
   npm run dev
   ```
   Make sure your app is accessible at `http://localhost:5173`

2. **Admin credentials configured**:
   Edit `scripts/screenshot-config.json` and set your admin username and password:
   ```json
   {
     "adminCredentials": {
       "username": "your-admin-username",
       "password": "your-admin-password"
     }
   }
   ```

3. **Database populated with sample data**:
   - At least 1-2 products with images
   - At least 1-2 clients with logos
   - At least 1-2 testimonials
   - Company history entries
   - Vision & mission configured

## 🚀 Usage

### Step 1: Configure Admin Credentials

Edit `scripts/screenshot-config.json`:

```json
{
  "baseUrl": "http://localhost:5173",
  "screenshotsDir": "user-manual/images",
  "adminCredentials": {
    "username": "admin",        // ⚠️ UPDATE THIS
    "password": "admin123"      // ⚠️ UPDATE THIS
  },
  "viewports": {
    "desktop": {
      "width": 1920,
      "height": 1080
    },
    "mobile": {
      "width": 375,
      "height": 812
    }
  },
  "options": {
    "headless": false,
    "slowMo": 100,
    "waitTimeout": 1000,
    "navigationTimeout": 2000
  }
}
```

### Step 2: Start Development Server

```bash
npm run dev
```

Wait until the server is running on `http://localhost:5173`

### Step 3: Run Screenshot Automation

In a **new terminal window**, run:

```bash
npm run screenshots
```

### Step 4: Watch the Magic Happen!

The script will:
1. Open a browser window (Chromium)
2. Navigate through all pages
3. Capture screenshots automatically
4. Save them to `user-manual/images/`

**Duration**: The entire process takes approximately **3-5 minutes**.

## 📁 Generated Screenshots

All screenshots will be saved to: `user-manual/images/`

### Frontend Screenshots (14 files)
- `homepage-user.png` - Full homepage
- `navbar-user.png` - Desktop navigation bar
- `navbar-mobile.png` - Mobile navigation menu
- `hero-section.png` - Hero/banner section
- `produk-section.png` - Products section
- `client-section.png` - Our clients section
- `testimoni-section.png` - Testimonials section
- `visi-misi-section.png` - Vision & Mission section
- `history-section.png` - Company history timeline
- `kontak-info.png` - Contact information
- `whatsapp-form.png` - WhatsApp contact form
- `google-maps.png` - Embedded Google Maps
- `footer.png` - Website footer
- `wa-floating-button.png` - WhatsApp floating button

### Admin Screenshots (26+ files)
- `admin-login-url.png` - Admin login URL
- `login-page.png` - Login page
- `logout-button.png` - Logout button
- `admin-dashboard.png` - Main dashboard
- `produk-list.png` - Products list
- `produk-form-add.png` - Add product form
- `produk-form-edit.png` - Edit product form
- `produk-delete-confirm.png` - Delete confirmation dialog
- `client-list.png` - Clients list
- `client-form-add.png` - Add client form
- `testimoni-list.png` - Testimonials list
- `testimoni-form-add.png` - Add testimonial form
- `testimoni-preview.png` - Testimonials preview
- `visi-misi-page.png` - Vision & Mission management
- `visi-misi-form.png` - Vision & Mission form
- `kontak-form.png` - Contact management form
- `hero-backgrounds.png` - Hero section backgrounds
- `hero-save.png` - Save hero section button
- `history-list.png` - Company history list
- `history-form-add.png` - Add history form
- `settings-page.png` - Site settings page
- `admin-list.png` - Admin users list (Super Admin only)
- `admin-form-add.png` - Add admin form (Super Admin only)
- `admin-mobile-sidebar.png` - Mobile sidebar
- `responsive-table.png` - Responsive table view

### Miscellaneous
- `logo-company.png` - Company logo

## ⚙️ Configuration Options

Edit `scripts/screenshot-config.json` to customize:

### Base URL
Change if your app runs on a different port:
```json
"baseUrl": "http://localhost:3000"
```

### Screenshots Directory
Change output directory:
```json
"screenshotsDir": "docs/images"
```

### Viewports
Adjust screenshot dimensions:
```json
"viewports": {
  "desktop": {
    "width": 1920,
    "height": 1080
  },
  "mobile": {
    "width": 414,
    "height": 896
  }
}
```

### Browser Options
```json
"options": {
  "headless": true,           // Run without browser UI (faster)
  "slowMo": 0,                // Remove delay between actions
  "waitTimeout": 500,         // Shorter animation wait time
  "navigationTimeout": 1000   // Shorter page load wait time
}
```

## 🐛 Troubleshooting

### Issue: Login Failed
**Error**: `❌ Login failed! Please check credentials.`

**Solution**:
1. Verify admin credentials in `scripts/screenshot-config.json`
2. Make sure the user exists in the database
3. Check if login route is `/login` (update script if different)

### Issue: Screenshot Missing
**Problem**: Some screenshots are not captured

**Solution**:
1. Verify the page/section exists in your app
2. Check console for error messages
3. Manually test the navigation path
4. Adjust selectors in `capture-screenshots.ts` if needed

### Issue: Elements Not Found
**Error**: Element locator not found

**Solution**:
1. Ensure sample data exists in database
2. Update CSS selectors in script if UI has changed
3. Increase `waitTimeout` in config if elements load slowly

### Issue: Browser Closes Too Fast
**Problem**: Can't see what's happening

**Solution**:
Set `headless: false` and increase `slowMo` in config:
```json
"options": {
  "headless": false,
  "slowMo": 500
}
```

## 🔧 Advanced Usage

### Run in Headless Mode (Faster)
For production screenshot generation:

```json
"options": {
  "headless": true,
  "slowMo": 0
}
```

Then run:
```bash
npm run screenshots
```

### Capture Only Specific Sections

Edit `scripts/capture-screenshots.ts` and comment out unwanted sections:

```typescript
// Capture all screenshots
// await captureFrontendScreenshots(page)  // Comment out to skip
await captureAdminScreenshots(page)        // Only capture admin
// await captureLogoAndMiscScreenshots(page)
```

### Custom Screenshot Function

Add your own screenshot capture:

```typescript
async function captureCustomScreenshot(page: Page) {
  await page.goto(`${BASE_URL}/custom-page`)
  await waitForAnimations(page, 1000)
  await captureScreenshot(page, 'custom-screenshot.png')
}
```

## 📝 Integrating with LaTeX User Manual

The screenshots are automatically named to match the LaTeX document references.

In `user-manual/user-manual.tex`, images are referenced like:

```latex
\begin{figure}[h]
    \centering
    \includegraphics[width=0.9\textwidth]{images/homepage-user.png}
    \caption{Tampilan Halaman Beranda Website}
\end{figure}
```

After running the script, compile your LaTeX document:

```bash
cd user-manual
pdflatex user-manual.tex
pdflatex user-manual.tex  # Run twice for TOC
```

## 🎨 Tips for Better Screenshots

1. **Populate with realistic data**: Use real-looking company names, descriptions, and high-quality images
2. **Clean state**: Remove any test/debug data before capturing
3. **Consistent styling**: Ensure all pages use the same theme/colors
4. **Full data**: Have at least 2-3 items in each section for better visual representation
5. **Mobile testing**: Test mobile views manually first to ensure they look good

## 🤝 Contributing

To add new screenshots:

1. Add the screenshot capture code in `capture-screenshots.ts`
2. Follow the naming convention matching the LaTeX file
3. Add the new screenshot to this README's list
4. Update the LaTeX document with the figure reference

## 📄 License

This screenshot automation tool is part of the PT. Surya Kencana Gemilang Teknik Company Profile project.

---

**Last Updated**: December 2024
**Version**: 1.0
