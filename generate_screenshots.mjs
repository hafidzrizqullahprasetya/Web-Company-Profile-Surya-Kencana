import fs from "fs/promises";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// CONFIGURATION
const AUTOMATION_API = "http://localhost:3008/run";
const FRONTEND_URL = "http://localhost:5173";
const OUTPUT_DIR = path.join(__dirname, "user-manual/images");
const VIEWPORT_DESKTOP = { width: 1440, height: 900 };
const VIEWPORT_TABLET = { width: 768, height: 1024 };
const VIEWPORT_MOBILE = { width: 375, height: 667 };

// CREDENTIALS
const ADMIN_USER = "superadmin";
const ADMIN_PASS = "superadmin123";

// Utility function to create admin login steps
function getAdminSteps(targetPath, additionalSteps = []) {
  return [
    { action: "viewport", ...VIEWPORT_DESKTOP },
    { action: "goto", url: `${FRONTEND_URL}/login` },
    { action: "wait", ms: 1000 },
    { action: "fill", selector: "#username", value: ADMIN_USER },
    { action: "fill", selector: "#password", value: ADMIN_PASS },
    { action: "click", selector: 'button[type="submit"]' },
    { action: "wait", ms: 3000 },
    { action: "goto", url: `${FRONTEND_URL}${targetPath}` },
    { action: "wait", ms: 2000 },
    ...additionalSteps,
    { action: "screenshot" },
  ];
}

// COMPREHENSIVE SCENARIOS
const SCENARIOS = [
  // ============================================
  // FRONTEND PUBLIC PAGES
  // ============================================
  {
    name: "01_frontend_home_desktop.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 3000 },
      { action: "screenshot", fullPage: true },
    ],
  },
  {
    name: "02_frontend_home_tablet.png",
    steps: [
      { action: "viewport", ...VIEWPORT_TABLET },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "screenshot", fullPage: true },
    ],
  },
  {
    name: "03_frontend_home_mobile.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "screenshot", fullPage: true },
    ],
  },
  {
    name: "04_frontend_navbar_desktop.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 1500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "05_frontend_navbar_mobile.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 1500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "06_frontend_hero_section.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "07_frontend_products_section.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "scroll", y: 800 },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "08_frontend_clients_section.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "scroll", y: 1600 },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "09_frontend_testimonials_section.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "scroll", y: 2400 },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "10_frontend_vision_mission_section.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "scroll", y: 3200 },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "11_frontend_history_section.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      { action: "scroll", y: 4000 },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "12_frontend_footer.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/` },
      { action: "wait", ms: 2000 },
      {
        action: "evaluate",
        script: "window.scrollTo(0, document.body.scrollHeight)",
      },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },

  // ============================================
  // LOGIN PAGE
  // ============================================
  {
    name: "13_login_page_desktop.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "14_login_page_mobile.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "15_login_form_empty.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "16_login_form_username_filled.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: "superadmin" },
      { action: "wait", ms: 500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "17_login_form_both_filled.png",
    steps: [
      { action: "viewport", ...VIEWPORT_DESKTOP },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: "superadmin" },
      { action: "fill", selector: "#password", value: "superadmin123" },
      { action: "wait", ms: 500 },
      { action: "screenshot" },
    ],
  },

  // ============================================
  // ADMIN DASHBOARD
  // ============================================
  {
    name: "18_admin_dashboard_overview.png",
    steps: getAdminSteps("/admin/dashboard"),
  },
  {
    name: "19_admin_dashboard_tablet.png",
    steps: [
      { action: "viewport", ...VIEWPORT_TABLET },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/dashboard` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "20_admin_dashboard_mobile.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/dashboard` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "21_admin_sidebar_desktop.png",
    steps: getAdminSteps("/admin/dashboard"),
  },

  // ============================================
  // MANAJEMEN PRODUK
  // ============================================
  {
    name: "22_admin_products_list_view.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "23_admin_products_empty_state.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "24_admin_products_search_bar.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "25_admin_products_add_button.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "26_admin_products_grid_view.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "27_admin_products_card_hover.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "28_admin_products_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/produk` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // Product Modal - Add Mode
  {
    name: "29_admin_products_modal_add_empty.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "30_admin_products_modal_add_name_field.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "31_admin_products_modal_add_price_field.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "32_admin_products_modal_add_description_field.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "33_admin_products_modal_add_image_upload.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "34_admin_products_modal_add_filled_form.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "35_admin_products_modal_add_submit_button.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },
  {
    name: "36_admin_products_modal_add_cancel_button.png",
    steps: getAdminSteps("/admin/produk", [
      { action: "click", selector: "button:has-text('Tambah Produk')" },
      { action: "wait", ms: 1000 },
    ]),
  },

  // Product Delete Confirmation
  {
    name: "37_admin_products_delete_confirm_modal.png",
    steps: getAdminSteps("/admin/produk"),
  },
  {
    name: "38_admin_products_delete_success_message.png",
    steps: getAdminSteps("/admin/produk"),
  },

  // ============================================
  // MANAJEMEN KLIEN
  // ============================================
  {
    name: "39_admin_clients_list_view.png",
    steps: getAdminSteps("/admin/our-client"),
  },
  {
    name: "41_admin_clients_grid_view.png",
    steps: getAdminSteps("/admin/our-client"),
  },
  {
    name: "42_admin_clients_add_button.png",
    steps: getAdminSteps("/admin/our-client"),
  },
  {
    name: "43_admin_clients_card_view.png",
    steps: getAdminSteps("/admin/our-client"),
  },
  {
    name: "44_admin_clients_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/our-client` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // Client Modal - Add/Edit
  {
    name: "45_admin_clients_add_form.png",
    steps: [
      ...getAdminSteps("/admin/our-client"),
      { action: "wait", ms: 1500 },
      { action: "click", selector: "button:has-text('Tambah Client')" },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "46_admin_clients_fill_name.png",
    steps: [
      ...getAdminSteps("/admin/our-client"),
      { action: "wait", ms: 1500 },
      { action: "click", selector: "button:has-text('Tambah Client')" },
      { action: "wait", ms: 1000 },
      {
        action: "fill",
        selector: "input[name='name']",
        value: "PT. Mitra Sejahtera",
      },
      { action: "wait", ms: 500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "47_admin_clients_upload_logo.png",
    steps: [
      ...getAdminSteps("/admin/our-client"),
      { action: "wait", ms: 1500 },
      { action: "click", selector: "button:has-text('Tambah Client')" },
      { action: "wait", ms: 1000 },
      { action: "screenshot", selector: ".upload-area" },
    ],
  },
  {
    name: "48_admin_clients_preview_logo.png",
    steps: [
      ...getAdminSteps("/admin/our-client"),
      { action: "wait", ms: 1500 },
      { action: "click", selector: "button:has-text('Tambah Client')" },
      { action: "wait", ms: 1000 },
      {
        action: "fill",
        selector: "input[name='name']",
        value: "PT. Mitra Sejahtera",
      },
      { action: "wait", ms: 500 },
      { action: "screenshot" },
    ],
  },
  {
    name: "49_admin_clients_submit_add.png",
    steps: [
      ...getAdminSteps("/admin/our-client"),
      { action: "wait", ms: 1500 },
      { action: "click", selector: "button:has-text('Tambah Client')" },
      { action: "wait", ms: 1000 },
      {
        action: "fill",
        selector: "input[name='name']",
        value: "PT. Mitra Sejahtera",
      },
      { action: "wait", ms: 500 },
      { action: "screenshot", selector: "button[type='submit']" },
    ],
  },

  // ============================================
  // MANAJEMEN TESTIMONI
  // ============================================
  {
    name: "50_admin_testimonials_list_view.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "51_admin_testimonials_table_desktop.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "52_admin_testimonials_card_mobile.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/testimoni` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "53_admin_testimonials_search_bar.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "54_admin_testimonials_add_button.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "55_admin_testimonials_empty_state.png",
    steps: getAdminSteps("/admin/testimoni"),
  },

  // Testimonial Modal
  {
    name: "56_admin_testimonials_modal_add.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "57_admin_testimonials_modal_client_name.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "58_admin_testimonials_modal_company.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "59_admin_testimonials_modal_feedback.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "60_admin_testimonials_modal_rating.png",
    steps: getAdminSteps("/admin/testimoni"),
  },
  {
    name: "61_admin_testimonials_preview_section.png",
    steps: getAdminSteps("/admin/testimoni", [
      { action: "scroll", y: 800 },
      { action: "wait", ms: 1000 },
    ]),
  },

  // ============================================
  // VISI & MISI
  // ============================================
  {
    name: "62_admin_vision_mission_page.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "63_admin_vision_mission_split_view.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "64_admin_vision_mission_vision_field.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "65_admin_vision_mission_mission_list.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "66_admin_vision_mission_add_mission_button.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "67_admin_vision_mission_delete_mission_button.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "68_admin_vision_mission_preview_section.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "69_admin_vision_mission_save_button.png",
    steps: getAdminSteps("/admin/visi-misi"),
  },
  {
    name: "70_admin_vision_mission_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/visi-misi` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // ============================================
  // KONTAK
  // ============================================
  {
    name: "71_admin_contact_page.png",
    steps: getAdminSteps("/admin/kontak"),
  },
  {
    name: "72_admin_contact_address_field.png",
    steps: getAdminSteps("/admin/kontak"),
  },
  {
    name: "73_admin_contact_phone_field.png",
    steps: getAdminSteps("/admin/kontak"),
  },
  {
    name: "74_admin_contact_email_field.png",
    steps: getAdminSteps("/admin/kontak"),
  },
  {
    name: "75_admin_contact_maps_field.png",
    steps: getAdminSteps("/admin/kontak"),
  },
  {
    name: "76_admin_contact_save_button.png",
    steps: getAdminSteps("/admin/kontak"),
  },
  {
    name: "77_admin_contact_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/kontak` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // ============================================
  // COMPANY HISTORY
  // ============================================
  {
    name: "78_admin_history_list_view.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "79_admin_history_table_view.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "80_admin_history_add_button.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "81_admin_history_empty_state.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "82_admin_history_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/company-history` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // History Modal
  {
    name: "83_admin_history_modal_add.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "84_admin_history_modal_year_field.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "85_admin_history_modal_title_field.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "86_admin_history_modal_description_field.png",
    steps: getAdminSteps("/admin/company-history"),
  },
  {
    name: "87_admin_history_delete_confirm.png",
    steps: getAdminSteps("/admin/company-history"),
  },

  // ============================================
  // HERO SECTION
  // ============================================
  {
    name: "88_admin_hero_page.png",
    steps: getAdminSteps("/admin/hero"),
  },
  {
    name: "89_admin_hero_backgrounds_grid.png",
    steps: getAdminSteps("/admin/hero"),
  },
  {
    name: "90_admin_hero_upload_section.png",
    steps: getAdminSteps("/admin/hero"),
  },
  {
    name: "91_admin_hero_image_preview.png",
    steps: getAdminSteps("/admin/hero"),
  },
  {
    name: "92_admin_hero_delete_button.png",
    steps: getAdminSteps("/admin/hero"),
  },
  {
    name: "93_admin_hero_save_button.png",
    steps: getAdminSteps("/admin/hero"),
  },
  {
    name: "94_admin_hero_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/hero` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // ============================================
  // SITE SETTINGS
  // ============================================
  {
    name: "95_admin_settings_page.png",
    steps: getAdminSteps("/admin/settings"),
  },
  {
    name: "96_admin_settings_sections_list.png",
    steps: getAdminSteps("/admin/settings"),
  },
  {
    name: "97_admin_settings_products_section.png",
    steps: getAdminSteps("/admin/settings"),
  },
  {
    name: "98_admin_settings_clients_section.png",
    steps: getAdminSteps("/admin/settings"),
  },
  {
    name: "99_admin_settings_testimonials_section.png",
    steps: getAdminSteps("/admin/settings"),
  },
  {
    name: "100_admin_settings_save_button.png",
    steps: getAdminSteps("/admin/settings"),
  },
  {
    name: "101_admin_settings_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/settings` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // ============================================
  // ADMIN MANAGEMENT (Super Admin Only)
  // ============================================
  {
    name: "102_admin_users_list_view.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "103_admin_users_table_view.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "104_admin_users_add_button.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "105_admin_users_empty_state.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "106_admin_users_mobile_view.png",
    steps: [
      { action: "viewport", ...VIEWPORT_MOBILE },
      { action: "goto", url: `${FRONTEND_URL}/login` },
      { action: "wait", ms: 1000 },
      { action: "fill", selector: "#username", value: ADMIN_USER },
      { action: "fill", selector: "#password", value: ADMIN_PASS },
      { action: "click", selector: 'button[type="submit"]' },
      { action: "wait", ms: 3000 },
      { action: "goto", url: `${FRONTEND_URL}/admin/riwayat` },
      { action: "wait", ms: 2000 },
      { action: "screenshot" },
    ],
  },

  // User Modal
  {
    name: "107_admin_users_modal_add.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "108_admin_users_modal_username_field.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "109_admin_users_modal_password_field.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "110_admin_users_modal_role_field.png",
    steps: getAdminSteps("/admin/riwayat"),
  },
  {
    name: "111_admin_users_delete_confirm.png",
    steps: getAdminSteps("/admin/riwayat"),
  },

  // ============================================
  // PLACEHOLDER IMAGES
  // ============================================
  {
    name: "placeholder_logo_company.png",
    steps: [
      { action: "viewport", width: 400, height: 300 },
      {
        action: "goto",
        url: "https://via.placeholder.com/400x300/195957/FFFFFF?text=Logo+Perusahaan",
      },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
  {
    name: "placeholder_architecture_diagram.png",
    steps: [
      { action: "viewport", width: 1200, height: 800 },
      {
        action: "goto",
        url: "https://via.placeholder.com/1200x800/195957/FFFFFF?text=Architecture+Diagram",
      },
      { action: "wait", ms: 1000 },
      { action: "screenshot" },
    ],
  },
];

// Capture function
async function capture(scenario) {
  console.log(`📸 Capturing ${scenario.name}...`);

  try {
    const response = await fetch(AUTOMATION_API, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        steps: scenario.steps,
        globalWait: 300,
      }),
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`API returned ${response.status}: ${errorText}`);
    }

    const arrayBuffer = await response.arrayBuffer();
    const buffer = Buffer.from(arrayBuffer);

    const filePath = path.join(OUTPUT_DIR, scenario.name);
    await fs.writeFile(filePath, buffer);
    console.log(`✅ Saved to ${filePath}`);
  } catch (error) {
    console.error(`❌ Failed to capture ${scenario.name}:`, error.message);
  }
}

// Main function
async function main() {
  console.log("🚀 Starting Comprehensive Documentation Screenshot Generator");
  console.log(`Target: ${FRONTEND_URL}`);
  console.log(`Automation Service: ${AUTOMATION_API}`);
  console.log(`Output: ${OUTPUT_DIR}`);
  console.log(`Total Scenarios: ${SCENARIOS.length}\n`);

  try {
    await fs.mkdir(OUTPUT_DIR, { recursive: true });
  } catch (err) {
    console.error(`Error creating directory: ${err.message}`);
  }

  let successCount = 0;
  let failCount = 0;

  for (const scenario of SCENARIOS) {
    try {
      await capture(scenario);
      successCount++;
    } catch (error) {
      failCount++;
    }
  }

  console.log("\n✨ Screenshot generation completed!");
  console.log(`✅ Success: ${successCount}`);
  console.log(`❌ Failed: ${failCount}`);
  console.log(`📊 Total: ${SCENARIOS.length}`);
}

main();
