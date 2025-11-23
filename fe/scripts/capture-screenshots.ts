import { chromium, type Browser, type Page } from '@playwright/test'
import * as path from 'path'
import * as fs from 'fs'

// Configuration
const BASE_URL = 'http://localhost:5173'
const SCREENSHOTS_DIR = path.join(process.cwd(), 'user-manual', 'images')

// Admin credentials - UPDATE THESE WITH YOUR ACTUAL CREDENTIALS
const ADMIN_USERNAME = 'superadmin' // Update this
const ADMIN_PASSWORD = 'superadmin123' // Update this

// Helper function to ensure directory exists
function ensureDirectoryExists(dir: string) {
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true })
  }
}

// Helper function to wait for animations
async function waitForAnimations(page: Page, timeout = 1000) {
  await page.waitForTimeout(timeout)
}

// Helper function to scroll to element
async function scrollToElement(page: Page, selector: string) {
  await page.locator(selector).scrollIntoViewIfNeeded()
  await waitForAnimations(page, 500)
}

async function captureScreenshot(page: Page, filename: string, fullPage = false) {
  const filepath = path.join(SCREENSHOTS_DIR, filename)
  await page.screenshot({ path: filepath, fullPage })
  console.log(`✅ Captured: ${filename}`)
}

async function captureFrontendScreenshots(page: Page) {
  console.log('\n📸 Capturing Frontend Screenshots...\n')

  // 1. Homepage
  await page.goto(BASE_URL)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'homepage-user.png', true)

  // 2. Navbar (Desktop)
  await page.setViewportSize({ width: 1920, height: 1080 })
  await waitForAnimations(page)
  await captureScreenshot(page, 'navbar-user.png')

  // 3. Navbar Mobile
  await page.setViewportSize({ width: 375, height: 812 })
  await page.goto(BASE_URL)
  await waitForAnimations(page, 1000)
  // Click hamburger menu if exists
  const hamburger = page
    .locator('button[aria-label="Menu"], .hamburger, [class*="menu-toggle"]')
    .first()
  if (await hamburger.isVisible().catch(() => false)) {
    await hamburger.click()
    await waitForAnimations(page, 500)
  }
  await captureScreenshot(page, 'navbar-mobile.png')
  // Close menu if opened
  if (await hamburger.isVisible().catch(() => false)) {
    await hamburger.click()
  }

  // Reset to desktop view
  await page.setViewportSize({ width: 1920, height: 1080 })
  await page.goto(BASE_URL)
  await waitForAnimations(page, 2000)

  // 4. Hero Section
  await captureScreenshot(page, 'hero-section.png')

  // 5. Product Section
  const productSection = page.locator('#produk, [id*="produk"], section:has-text("Produk")').first()
  if (await productSection.isVisible().catch(() => false)) {
    await scrollToElement(page, '#produk, [id*="produk"], section:has-text("Produk")')
    await captureScreenshot(page, 'produk-section.png')
  }

  // 6. Client Section
  const clientSection = page
    .locator('#klien, #client, [id*="client"], section:has-text("Client")')
    .first()
  if (await clientSection.isVisible().catch(() => false)) {
    await scrollToElement(page, '#klien, #client, [id*="client"]')
    await captureScreenshot(page, 'client-section.png')
  }

  // 7. Testimonial Section
  const testimoniSection = page
    .locator('#testimoni, [id*="testimoni"], section:has-text("Testimoni")')
    .first()
  if (await testimoniSection.isVisible().catch(() => false)) {
    await scrollToElement(page, '#testimoni, [id*="testimoni"]')
    await captureScreenshot(page, 'testimoni-section.png')
  }

  // 8. Vision & Mission Section
  const visiMisiSection = page.locator('#visi-misi, [id*="visi"], section:has-text("Visi")').first()
  if (await visiMisiSection.isVisible().catch(() => false)) {
    await scrollToElement(page, '#visi-misi, [id*="visi"]')
    await captureScreenshot(page, 'visi-misi-section.png')
  }

  // 9. Company History Section
  const historySection = page
    .locator('#riwayat, #history, [id*="history"], section:has-text("Sejarah")')
    .first()
  if (await historySection.isVisible().catch(() => false)) {
    await scrollToElement(page, '#riwayat, #history, [id*="history"]')
    await captureScreenshot(page, 'history-section.png')
  }

  // 10. Contact Section
  const kontakSection = page.locator('#kontak, #contact, [id*="kontak"]').first()
  if (await kontakSection.isVisible().catch(() => false)) {
    await scrollToElement(page, '#kontak, #contact, [id*="kontak"]')
    await captureScreenshot(page, 'kontak-info.png')
  }

  // 11. WhatsApp Form
  const waForm = page.locator('form:has-text("WhatsApp"), [class*="whatsapp-form"]').first()
  if (await waForm.isVisible().catch(() => false)) {
    await scrollToElement(page, 'form:has-text("WhatsApp")')
    await captureScreenshot(page, 'whatsapp-form.png')
  }

  // 12. Google Maps
  const mapsSection = page.locator('iframe[src*="google.com/maps"]').first()
  if (await mapsSection.isVisible().catch(() => false)) {
    await scrollToElement(page, 'iframe[src*="google.com/maps"]')
    await captureScreenshot(page, 'google-maps.png')
  }

  // 13. Footer
  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight))
  await waitForAnimations(page)
  await captureScreenshot(page, 'footer.png')

  // 14. WhatsApp Floating Button
  await page.goto(BASE_URL)
  await waitForAnimations(page, 1000)
  const waButton = page
    .locator('[class*="whatsapp-float"], [class*="wa-float"], a[href*="wa.me"]')
    .first()
  if (await waButton.isVisible().catch(() => false)) {
    await waButton.hover()
    await waitForAnimations(page, 300)
    await captureScreenshot(page, 'wa-floating-button.png')
  }

  console.log('\n✅ Frontend screenshots completed!\n')
}

async function captureAdminScreenshots(page: Page) {
  console.log('\n📸 Capturing Admin Screenshots...\n')

  // Reset to desktop view
  await page.setViewportSize({ width: 1920, height: 1080 })

  // 1. Admin Login URL (Browser URL bar)
  await page.goto(`${BASE_URL}/admin/dashboard`)
  await waitForAnimations(page, 1000)
  await captureScreenshot(page, 'admin-login-url.png')

  // 2. Login Page
  await page.goto(`${BASE_URL}/login`)
  await waitForAnimations(page, 1000)
  await captureScreenshot(page, 'login-page.png', true)

  // Perform login
  console.log('🔐 Logging in...')
  await page.fill('input[type="text"], input[name="username"]', ADMIN_USERNAME)
  await page.fill('input[type="password"], input[name="password"]', ADMIN_PASSWORD)
  await page.click('button[type="submit"], button:has-text("Login")')
  await waitForAnimations(page, 2000)

  // Check if login was successful
  const currentUrl = page.url()
  if (!currentUrl.includes('/admin') && !currentUrl.includes('/dashboard')) {
    console.error('❌ Login failed! Please check credentials.')
    console.error('Current URL:', currentUrl)
    return
  }

  console.log('✅ Login successful!\n')

  // 3. Admin Dashboard
  await page.goto(`${BASE_URL}/admin/dashboard`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'admin-dashboard.png', true)

  // 4. Logout Button (Header)
  const logoutButton = page
    .locator('button:has-text("Logout"), a:has-text("Logout"), [class*="logout"]')
    .first()
  if (await logoutButton.isVisible().catch(() => false)) {
    await logoutButton.hover()
    await waitForAnimations(page, 300)
    await captureScreenshot(page, 'logout-button.png')
  }

  // 5-9. Product Management
  await page.goto(`${BASE_URL}/admin/produk`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'produk-list.png', true)

  // Add Product Form
  const addProductBtn = page.locator('button:has-text("Tambah"), button:has-text("Produk")').first()
  if (await addProductBtn.isVisible().catch(() => false)) {
    await addProductBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'produk-form-add.png')

    // Close modal/form
    const closeBtn = page
      .locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]')
      .first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
      await waitForAnimations(page, 500)
    } else {
      await page.keyboard.press('Escape')
      await waitForAnimations(page, 500)
    }
  }

  // Edit Product Form (click first edit button)
  const editProductBtn = page.locator('button:has-text("Edit")').first()
  if (await editProductBtn.isVisible().catch(() => false)) {
    await editProductBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'produk-form-edit.png')

    // Close modal/form
    const closeBtn = page
      .locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]')
      .first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
      await waitForAnimations(page, 500)
    } else {
      await page.keyboard.press('Escape')
      await waitForAnimations(page, 500)
    }
  }

  // Delete Product Confirmation (click first delete button)
  const deleteProductBtn = page.locator('button:has-text("Hapus")').first()
  if (await deleteProductBtn.isVisible().catch(() => false)) {
    await deleteProductBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'produk-delete-confirm.png')

    // Cancel deletion
    const cancelBtn = page.locator('button:has-text("Batal"), button:has-text("Tidak")').first()
    if (await cancelBtn.isVisible().catch(() => false)) {
      await cancelBtn.click()
      await waitForAnimations(page, 500)
    } else {
      await page.keyboard.press('Escape')
      await waitForAnimations(page, 500)
    }
  }

  // 10-11. Client Management
  await page.goto(`${BASE_URL}/admin/client`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'client-list.png', true)

  const addClientBtn = page.locator('button:has-text("Tambah"), button:has-text("Client")').first()
  if (await addClientBtn.isVisible().catch(() => false)) {
    await addClientBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'client-form-add.png')

    const closeBtn = page
      .locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]')
      .first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
      await waitForAnimations(page, 500)
    } else {
      await page.keyboard.press('Escape')
      await waitForAnimations(page, 500)
    }
  }

  // 12-14. Testimonial Management
  await page.goto(`${BASE_URL}/admin/testimoni`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'testimoni-list.png', true)

  const addTestimoniBtn = page
    .locator('button:has-text("Tambah"), button:has-text("Testimoni")')
    .first()
  if (await addTestimoniBtn.isVisible().catch(() => false)) {
    await addTestimoniBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'testimoni-form-add.png')

    const closeBtn = page
      .locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]')
      .first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
      await waitForAnimations(page, 500)
    } else {
      await page.keyboard.press('Escape')
      await waitForAnimations(page, 500)
    }
  }

  // Testimonial Preview (scroll to preview section)
  const previewSection = page.locator('[class*="preview"], section:has-text("Pratinjau")').first()
  if (await previewSection.isVisible().catch(() => false)) {
    await scrollToElement(page, '[class*="preview"], section:has-text("Pratinjau")')
    await captureScreenshot(page, 'testimoni-preview.png')
  }

  // 15-16. Vision & Mission
  await page.goto(`${BASE_URL}/admin/visi-misi`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'visi-misi-page.png', true)

  // Focus on form
  const visiMisiForm = page.locator('form, [class*="form"]').first()
  if (await visiMisiForm.isVisible().catch(() => false)) {
    await scrollToElement(page, 'form, [class*="form"]')
    await captureScreenshot(page, 'visi-misi-form.png')
  }

  // 17. Contact Management
  await page.goto(`${BASE_URL}/admin/kontak`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'kontak-form.png', true)

  // 18-19. Hero Section Management
  await page.goto(`${BASE_URL}/admin/hero`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'hero-backgrounds.png', true)

  // Scroll to save button
  const saveBtn = page.locator('button:has-text("Simpan")').first()
  if (await saveBtn.isVisible().catch(() => false)) {
    await scrollToElement(page, 'button:has-text("Simpan")')
    await captureScreenshot(page, 'hero-save.png')
  }

  // 20-21. Company History
  await page.goto(`${BASE_URL}/admin/riwayat`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'history-list.png', true)

  const addHistoryBtn = page
    .locator('button:has-text("Tambah"), button:has-text("Riwayat")')
    .first()
  if (await addHistoryBtn.isVisible().catch(() => false)) {
    await addHistoryBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'history-form-add.png')

    const closeBtn = page
      .locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]')
      .first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
      await waitForAnimations(page, 500)
    } else {
      await page.keyboard.press('Escape')
      await waitForAnimations(page, 500)
    }
  }

  // 22. Settings Page
  await page.goto(`${BASE_URL}/admin/settings`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'settings-page.png', true)

  // 23-24. Admin Management (if accessible)
  try {
    await page.goto(`${BASE_URL}/admin/manajemen-admin`)
    await waitForAnimations(page, 2000)
    await captureScreenshot(page, 'admin-list.png', true)

    const addAdminBtn = page.locator('button:has-text("Tambah"), button:has-text("Admin")').first()
    if (await addAdminBtn.isVisible().catch(() => false)) {
      await addAdminBtn.click()
      await waitForAnimations(page, 1000)
      await captureScreenshot(page, 'admin-form-add.png')

      const closeBtn = page
        .locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]')
        .first()
      if (await closeBtn.isVisible().catch(() => false)) {
        await closeBtn.click()
        await waitForAnimations(page, 500)
      } else {
        await page.keyboard.press('Escape')
        await waitForAnimations(page, 500)
      }
    }
  } catch (error) {
    console.log('⚠️  Admin Management page not accessible (might require Super Admin role)')
  }

  // 25. Mobile Sidebar
  await page.setViewportSize({ width: 375, height: 812 })
  await page.goto(`${BASE_URL}/admin/dashboard`)
  await waitForAnimations(page, 1000)

  // Click hamburger to open sidebar
  const mobileMenuBtn = page
    .locator(
      'button[aria-label="Menu"], .hamburger, [class*="menu-toggle"], [class*="sidebar-toggle"]',
    )
    .first()
  if (await mobileMenuBtn.isVisible().catch(() => false)) {
    await mobileMenuBtn.click()
    await waitForAnimations(page, 500)
    await captureScreenshot(page, 'admin-mobile-sidebar.png')
  }

  // 26. Responsive Table
  await page.setViewportSize({ width: 375, height: 812 })
  await page.goto(`${BASE_URL}/admin/testimoni`)
  await waitForAnimations(page, 2000)
  await captureScreenshot(page, 'responsive-table.png')

  console.log('\n✅ Admin screenshots completed!\n')
}

async function captureLogoAndMiscScreenshots(page: Page) {
  console.log('\n📸 Capturing Logo and Miscellaneous Screenshots...\n')

  // Try to capture company logo
  await page.goto(BASE_URL)
  await waitForAnimations(page, 1000)

  const logo = page.locator('img[alt*="logo"], [class*="logo"] img, header img').first()
  if (await logo.isVisible().catch(() => false)) {
    await logo.screenshot({ path: path.join(SCREENSHOTS_DIR, 'logo-company.png') })
    console.log('✅ Captured: logo-company.png')
  } else {
    console.log('⚠️  Could not find company logo')
  }

  console.log('\n✅ Misc screenshots completed!\n')
}

async function main() {
  console.log('\n🚀 Starting Screenshot Automation...\n')
  console.log(`📁 Screenshots will be saved to: ${SCREENSHOTS_DIR}\n`)

  // Ensure screenshots directory exists
  ensureDirectoryExists(SCREENSHOTS_DIR)

  let browser: Browser | null = null

  try {
    // Launch browser
    browser = await chromium.launch({
      headless: false, // Set to true for headless mode
      slowMo: 100, // Slow down by 100ms for better visibility
    })

    const context = await browser.newContext({
      viewport: { width: 1920, height: 1080 },
      userAgent:
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    })

    const page = await context.newPage()

    // Capture all screenshots
    await captureFrontendScreenshots(page)
    await captureAdminScreenshots(page)
    await captureLogoAndMiscScreenshots(page)

    console.log('\n✅ All screenshots captured successfully!')
    console.log(`📁 Location: ${SCREENSHOTS_DIR}\n`)
  } catch (error) {
    console.error('\n❌ Error capturing screenshots:', error)
    throw error
  } finally {
    if (browser) {
      await browser.close()
    }
  }
}

// Run the script
main().catch(console.error)
