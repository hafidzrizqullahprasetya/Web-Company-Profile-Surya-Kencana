import { chromium, type Browser, type Page } from '@playwright/test'
import * as path from 'path'
import * as fs from 'fs'

// Load configuration
const configPath = path.join(process.cwd(), 'scripts', 'screenshot-config.json')
const config = JSON.parse(fs.readFileSync(configPath, 'utf-8'))

const BASE_URL = config.baseUrl
const SCREENSHOTS_DIR = path.join(process.cwd(), config.screenshotsDir)
const ADMIN_USERNAME = config.adminCredentials.username
const ADMIN_PASSWORD = config.adminCredentials.password

async function waitForAnimations(page: Page, timeout = 1000) {
  await page.waitForTimeout(timeout)
}

async function captureScreenshot(page: Page, filename: string) {
  const filepath = path.join(SCREENSHOTS_DIR, filename)
  await page.screenshot({ path: filepath, fullPage: false })
  console.log(`✅ Captured: ${filename}`)
}

async function main() {
  console.log('\n🚀 Capturing Final Missing Screenshots...\n')

  const browser = await chromium.launch({
    headless: false,
    slowMo: 200,
  })

  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 },
  })

  const page = await context.newPage()

  try {
    // 1. Logo Company
    console.log('📸 1/6: Capturing company logo...')
    await page.goto(BASE_URL)
    await waitForAnimations(page, 2000)

    // Take screenshot of header area where logo typically is
    const header = page.locator('header, nav, .navbar').first()
    if (await header.isVisible()) {
      const logoImg = header.locator('img').first()
      if (await logoImg.isVisible()) {
        const boundingBox = await logoImg.boundingBox()
        if (boundingBox) {
          await page.screenshot({
            path: path.join(SCREENSHOTS_DIR, 'logo-company.png'),
            clip: {
              x: boundingBox.x - 10,
              y: boundingBox.y - 10,
              width: boundingBox.width + 20,
              height: boundingBox.height + 20
            }
          })
          console.log('✅ Captured: logo-company.png')
        }
      }
    }

    // Login
    console.log('\n🔐 Logging in...')
    await page.goto(`${BASE_URL}/login`)
    await waitForAnimations(page, 1000)
    await page.locator('input').first().fill(ADMIN_USERNAME)
    await page.locator('input[type="password"]').fill(ADMIN_PASSWORD)
    await page.locator('button[type="submit"]').click()
    await waitForAnimations(page, 3000)

    // 2. Product Edit Form
    console.log('📸 2/6: Capturing product edit form...')
    await page.goto(`${BASE_URL}/admin/produk`)
    await waitForAnimations(page, 2000)

    const editButtons = await page.locator('button').all()
    for (const btn of editButtons) {
      const text = await btn.textContent()
      if (text && (text.includes('Edit') || text.includes('Ubah') || text.includes('edit'))) {
        await btn.click()
        await waitForAnimations(page, 2000)
        await captureScreenshot(page, 'produk-form-edit.png')
        await page.keyboard.press('Escape')
        await waitForAnimations(page, 500)
        break
      }
    }

    // 3. Product Delete Confirmation
    console.log('📸 3/6: Capturing product delete confirmation...')
    const deleteButtons = await page.locator('button').all()
    for (const btn of deleteButtons) {
      const text = await btn.textContent()
      if (text && (text.includes('Hapus') || text.includes('Delete') || text.includes('delete'))) {
        await btn.click()
        await waitForAnimations(page, 1500)
        await captureScreenshot(page, 'produk-delete-confirm.png')
        await page.keyboard.press('Escape')
        await waitForAnimations(page, 500)
        break
      }
    }

    // 4. Client Add Form
    console.log('📸 4/6: Capturing client add form...')
    await page.goto(`${BASE_URL}/admin/client`)
    await waitForAnimations(page, 2000)

    const addButtons = await page.locator('button').all()
    for (const btn of addButtons) {
      const text = await btn.textContent()
      if (text && text.includes('Tambah')) {
        await btn.click()
        await waitForAnimations(page, 2000)
        await captureScreenshot(page, 'client-form-add.png')
        await page.keyboard.press('Escape')
        await waitForAnimations(page, 500)
        break
      }
    }

    // 5. Admin Add Form
    console.log('📸 5/6: Capturing admin add form...')
    try {
      await page.goto(`${BASE_URL}/admin/manajemen-admin`)
      await waitForAnimations(page, 2000)

      const adminAddButtons = await page.locator('button').all()
      for (const btn of adminAddButtons) {
        const text = await btn.textContent()
        if (text && text.includes('Tambah')) {
          await btn.click()
          await waitForAnimations(page, 2000)
          await captureScreenshot(page, 'admin-form-add.png')
          await page.keyboard.press('Escape')
          await waitForAnimations(page, 500)
          break
        }
      }
    } catch (error) {
      console.log('⚠️  Admin management not accessible')
    }

    // 6. Admin Mobile Sidebar
    console.log('📸 6/6: Capturing admin mobile sidebar...')
    await page.setViewportSize({ width: 375, height: 812 })
    await page.goto(`${BASE_URL}/admin/dashboard`)
    await waitForAnimations(page, 2000)

    // Find menu button
    const allButtons = await page.locator('button').all()
    for (const btn of allButtons) {
      try {
        const ariaLabel = await btn.getAttribute('aria-label')
        if (ariaLabel && ariaLabel.toLowerCase().includes('menu')) {
          await btn.click()
          await waitForAnimations(page, 1500)
          await captureScreenshot(page, 'admin-mobile-sidebar.png')
          break
        }
      } catch (error) {
        // Try clicking first visible button in header
        const headerBtn = page.locator('header button, nav button').first()
        if (await headerBtn.isVisible()) {
          await headerBtn.click()
          await waitForAnimations(page, 1500)
          await captureScreenshot(page, 'admin-mobile-sidebar.png')
          break
        }
      }
    }

    console.log('\n✅ All final screenshots captured!')

  } catch (error) {
    console.error('❌ Error:', error)
  } finally {
    await browser.close()
  }
}

main().catch(console.error)
