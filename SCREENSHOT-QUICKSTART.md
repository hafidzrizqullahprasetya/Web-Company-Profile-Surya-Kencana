# 📸 Quick Start: Automated Screenshot Generator

Generate all screenshots for the User Manual in just 3 steps!

## 🚀 Quick Start

### 1. Update Admin Credentials

Edit `scripts/screenshot-config.json`:

```json
{
  "adminCredentials": {
    "username": "YOUR_ADMIN_USERNAME",
    "password": "YOUR_ADMIN_PASSWORD"
  }
}
```

### 2. Start Dev Server

```bash
npm run dev
```

### 3. Run Screenshot Tool

**In a new terminal:**

```bash
npm run screenshots
```

## ✅ What Happens Next?

- Browser opens automatically
- Navigates through **all pages** (frontend + admin)
- Captures **40+ screenshots**
- Saves to `user-manual/images/`
- Takes ~3-5 minutes

## 📁 Output

All screenshots saved to: `user-manual/images/`

Ready to use in your LaTeX document!

## 🔧 Optional: Headless Mode (Faster)

For faster execution without browser UI:

Edit `scripts/screenshot-config.json`:
```json
{
  "options": {
    "headless": true,
    "slowMo": 0
  }
}
```

---

📖 **Full Documentation**: `scripts/README-SCREENSHOTS.md`

🎯 **Script Location**: `scripts/capture-screenshots.ts`

⚙️ **Config File**: `scripts/screenshot-config.json`
