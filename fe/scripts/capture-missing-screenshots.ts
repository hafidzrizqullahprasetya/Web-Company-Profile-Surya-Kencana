import { chromium, type Browser, type Page } from '@playwright/test'
import * as path from 'path'
import * as fs from 'fs'

// Load configuration
const configPath = path.join(process.cwd(), 'scripts', 'screenshot-config.json')
const config = JSON.parse(fs.readFileSync(configPath, 'utf-8'))

// Configuration
const BASE_URL = config.baseUrl
const SCREENSHOTS_DIR = path.join(process.cwd(), config.screenshotsDir)
const ADMIN_USERNAME = config.adminCredentials.username
const ADMIN_PASSWORD = config.adminCredentials.password

async function waitForAnimations(page: Page, timeout = 1000) {
  await page.waitForTimeout(timeout)
}

async function captureScreenshot(page: Page, filename: string, fullPage = false) {
  const filepath = path.join(SCREENSHOTS_DIR, filename)
  await page.screenshot({ path: filepath, fullPage })
  console.log(`✅ Captured: ${filename}`)
}

async function captureMissingScreenshots(page: Page) {
  console.log('\n📸 Capturing Missing Screenshots...\n')

  // Reset to desktop view
  await page.setViewportSize({ width: 1920, height: 1080 })

  // 1. Company Logo
  console.log('🔍 Attempting to capture company logo...')
  await page.goto(BASE_URL)
  await waitForAnimations(page, 2000)

  // Try multiple selectors for logo
  const logoSelectors = [
    'img[alt*="logo" i]',
    'img[alt*="surya" i]',
    '[class*="logo"] img',
    'header img',
    'nav img:first-of-type',
    '.navbar img',
    'a[href="/"] img'
  ]

  for (const selector of logoSelectors) {
    const logo = page.locator(selector).first()
    if (await logo.isVisible().catch(() => false)) {
      try {
        await logo.screenshot({ path: path.join(SCREENSHOTS_DIR, 'logo-company.png') })
        console.log('✅ Captured: logo-company.png')
        break
      } catch (error) {
        continue
      }
    }
  }

  // 2. Client Section (Frontend)
  console.log('\n🔍 Capturing client section...')
  await page.goto(BASE_URL)
  await waitForAnimations(page, 2000)

  const clientSection = page.locator('section#klien, section#client, section:has-text("Client") >> nth=0').first()
  if (await clientSection.isVisible().catch(() => false)) {
    await clientSection.scrollIntoViewIfNeeded()
    await waitForAnimations(page, 2000) // Wait for logos to load
    await clientSection.screenshot({ path: path.join(SCREENSHOTS_DIR, 'client-section.png') })
    console.log('✅ Captured: client-section.png')
  }

  // Login for admin screenshots
  console.log('\n🔐 Logging in to admin...')
  await page.goto(`${BASE_URL}/login`)
  await waitForAnimations(page, 1000)
  await page.fill('input[type="text"], input[name="username"]', ADMIN_USERNAME)
  await page.fill('input[type="password"], input[name="password"]', ADMIN_PASSWORD)
  await page.click('button[type="submit"], button:has-text("Login")')
  await waitForAnimations(page, 2000)

  if (!page.url().includes('/admin')) {
    console.error('❌ Login failed! Cannot capture admin screenshots.')
    return
  }
  console.log('✅ Login successful!\n')

  // 3. Product Form Edit
  console.log('🔍 Capturing product edit form...')
  await page.goto(`${BASE_URL}/admin/produk`)
  await waitForAnimations(page, 2000)

  const editBtn = page.locator('button:has-text("Edit"), button:has-text("Ubah")').first()
  if (await editBtn.isVisible().catch(() => false)) {
    await editBtn.click()
    await waitForAnimations(page, 1500)
    await captureScreenshot(page, 'produk-form-edit.png')

    // Close modal
    const closeBtn = page.locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]').first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
    } else {
      await page.keyboard.press('Escape')
    }
    await waitForAnimations(page, 500)
  }

  // 4. Product Delete Confirmation
  console.log('🔍 Capturing product delete confirmation...')
  const deleteBtn = page.locator('button:has-text("Hapus"), button:has-text("Delete")').first()
  if (await deleteBtn.isVisible().catch(() => false)) {
    await deleteBtn.click()
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'produk-delete-confirm.png')

    // Cancel deletion
    const cancelBtn = page.locator('button:has-text("Batal"), button:has-text("Tidak"), button:has-text("Cancel")').first()
    if (await cancelBtn.isVisible().catch(() => false)) {
      await cancelBtn.click()
    } else {
      await page.keyboard.press('Escape')
    }
    await waitForAnimations(page, 500)
  }

  // 5. Client Form Add
  console.log('🔍 Capturing client add form...')
  await page.goto(`${BASE_URL}/admin/client`)
  await waitForAnimations(page, 2000)

  const addClientBtn = page.locator('button:has-text("Tambah")').first()
  if (await addClientBtn.isVisible().catch(() => false)) {
    await addClientBtn.click()
    await waitForAnimations(page, 1500)
    await captureScreenshot(page, 'client-form-add.png')

    // Close modal
    const closeBtn = page.locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]').first()
    if (await closeBtn.isVisible().catch(() => false)) {
      await closeBtn.click()
    } else {
      await page.keyboard.press('Escape')
    }
    await waitForAnimations(page, 500)
  }

  // 6. Testimonial Preview
  console.log('🔍 Capturing testimonial preview...')
  await page.goto(`${BASE_URL}/admin/testimoni`)
  await waitForAnimations(page, 2000)

  // Scroll to preview section
  const previewSection = page.locator('[class*="preview"], [class*="pratinjau"], section:has-text("Pratinjau")').first()
  if (await previewSection.isVisible().catch(() => false)) {
    await previewSection.scrollIntoViewIfNeeded()
    await waitForAnimations(page, 1500)
    await previewSection.screenshot({ path: path.join(SCREENSHOTS_DIR, 'testimoni-preview.png') })
    console.log('✅ Captured: testimoni-preview.png')
  } else {
    // If no specific preview section, capture the bottom part of the page
    await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight / 2))
    await waitForAnimations(page, 1000)
    await captureScreenshot(page, 'testimoni-preview.png')
  }

  // 7. Admin Form Add (Super Admin only)
  console.log('🔍 Capturing admin add form...')
  try {
    await page.goto(`${BASE_URL}/admin/manajemen-admin`)
    await waitForAnimations(page, 2000)

    const addAdminBtn = page.locator('button:has-text("Tambah")').first()
    if (await addAdminBtn.isVisible().catch(() => false)) {
      await addAdminBtn.click()
      await waitForAnimations(page, 1500)
      await captureScreenshot(page, 'admin-form-add.png')

      // Close modal
      const closeBtn = page.locator('button:has-text("Batal"), button:has-text("Close"), [aria-label="Close"]').first()
      if (await closeBtn.isVisible().catch(() => false)) {
        await closeBtn.click()
      } else {
        await page.keyboard.press('Escape')
      }
      await waitForAnimations(page, 500)
    }
  } catch (error) {
    console.log('⚠️  Admin Management not accessible (requires Super Admin)')
  }

  // 8. Admin Mobile Sidebar
  console.log('🔍 Capturing admin mobile sidebar...')
  await page.setViewportSize({ width: 375, height: 812 })
  await page.goto(`${BASE_URL}/admin/dashboard`)
  await waitForAnimations(page, 2000)

  // Try to find and click menu toggle
  const menuToggles = [
    'button[aria-label="Menu"]',
    'button[aria-label="Toggle sidebar"]',
    '.hamburger',
    '[class*="menu-toggle"]',
    '[class*="sidebar-toggle"]',
    'button:has(svg) >> nth=0'
  ]

  let sidebarOpened = false
  for (const selector of menuToggles) {
    const toggle = page.locator(selector).first()
    if (await toggle.isVisible().catch(() => false)) {
      try {
        await toggle.click()
        await waitForAnimations(page, 1000)
        sidebarOpened = true
        break
      } catch (error) {
        continue
      }
    }
  }

  if (sidebarOpened) {
    await captureScreenshot(page, 'admin-mobile-sidebar.png')
  } else {
    console.log('⚠️  Could not open mobile sidebar')
  }

  console.log('\n✅ Missing screenshots capture completed!\n')
}

async function main() {
  console.log('\n🚀 Starting Missing Screenshots Capture...\n')
  console.log(`📁 Screenshots will be saved to: ${SCREENSHOTS_DIR}\n`)

  let browser: Browser | null = null

  try {
    browser = await chromium.launch({
      headless: false,
      slowMo: 100,
    })

    const context = await browser.newContext({
      viewport: { width: 1920, height: 1080 },
    })

    const page = await context.newPage()

    await captureMissingScreenshots(page)

    console.log('\n✅ All missing screenshots captured successfully!')
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

main().catch(console.error)
