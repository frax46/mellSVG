import { test, expect } from '@playwright/test';
import { INTERNAL_PATHS, expectPathOk } from './helpers';

test.describe.configure({ mode: 'parallel' });

test.describe('HTTP health — internal routes', () => {
  for (const path of INTERNAL_PATHS) {
    test(`GET ${path} returns 2xx`, async ({ request }) => {
      await expectPathOk(request, path);
    });
  }
});

test.describe('Header navigation and layout', () => {
  test('home loads with header, nav, and key links', async ({ page }) => {
    await page.goto('/');
    await page.locator('#loading-overlay').waitFor({ state: 'hidden', timeout: 15000 }).catch(() => {});
    const nav = page.locator('#site-navigation');
    await expect(nav).toBeVisible({ timeout: 15000 });
    await expect(nav.getByRole('link', { name: 'Home', exact: true })).toBeVisible();
    await expect(nav.getByRole('link', { name: 'Gift Sets', exact: true })).toBeVisible();
    await expect(nav.getByRole('link', { name: 'Botanics', exact: true })).toBeVisible();
    await expect(nav.getByRole('link', { name: 'About Us', exact: true })).toBeVisible();
    await expect(nav.getByRole('link', { name: 'Blog', exact: true })).toBeVisible();
  });

  test('product search form is present when WooCommerce is active', async ({ page }) => {
    await page.goto('/');
    const search = page.locator('#woocommerce-product-search-field, input.search-field[name="s"]').first();
    await expect(search).toBeVisible();
    await expect(search).toHaveAttribute('name', 's');
  });

  test('cart sidebar opens from header cart control', async ({ page }) => {
    await page.goto('/');
    const cartToggle = page.locator('#cart-toggle, a.cart-link').first();
    await cartToggle.click();
    await expect(page.locator('#cart-sidebar')).toBeVisible();
    await expect(page.getByRole('heading', { name: /shopping cart/i })).toBeVisible();
    await expect(page.getByRole('link', { name: /view cart/i })).toBeVisible();
    await expect(page.getByRole('link', { name: /^checkout$/i })).toBeVisible();
  });

  test('profile icon points to login or my account', async ({ page }) => {
    await page.goto('/');
    const profile = page.locator('a.nav-login-link').first();
    await expect(profile).toBeVisible();
    const href = await profile.getAttribute('href');
    expect(href).toBeTruthy();
    expect(href!.includes('login') || href!.includes('my-account')).toBeTruthy();
  });
});

test.describe('Footer', () => {
  test('footer quick links and legal link are present', async ({ page }) => {
    await page.goto('/');
    const footer = page.locator('footer.site-footer');
    await expect(footer).toBeVisible();
    await expect(footer.getByRole('link', { name: /about us/i }).first()).toBeVisible();
    await expect(footer.getByRole('link', { name: /blog/i }).first()).toBeVisible();
    await expect(footer.getByRole('link', { name: /faq/i }).first()).toBeVisible();
    await expect(footer.getByRole('link', { name: /terms and\s*privacy|terms and privacy/i }).first()).toBeVisible();
  });
});

test.describe('Login page', () => {
  test('login page shows welcome content and register link', async ({ page }) => {
    await page.goto('/login');
    await expect(page.getByRole('heading', { name: /welcome back/i })).toBeVisible();
    await expect(page.getByText(/sign in to your mell luxe account/i)).toBeVisible();
    const registerLink = page.locator('a[href*="register"]').first();
    await expect(registerLink).toBeVisible();
    const href = await registerLink.getAttribute('href');
    expect(href).toMatch(/register/i);
  });
});

test.describe('WooCommerce — shop, cart, checkout', () => {
  test('shop page loads', async ({ page }) => {
    await page.goto('/shop');
    await expect(page.locator('body')).toBeVisible();
    await expect(page).toHaveURL(/shop/);
    await expect(
      page.locator('.woocommerce, .products, .woocommerce-info, .woocommerce-no-products-found').first()
    ).toBeVisible({ timeout: 15000 });
  });

  test('cart page loads (empty or with items)', async ({ page }) => {
    await page.goto('/cart');
    await expect(page.locator('body')).toBeVisible();
    const emptyOrBag =
      page.getByRole('heading', { name: /shopping bag/i }).or(page.locator('.cart-empty-container'));
    await expect(emptyOrBag.first()).toBeVisible({ timeout: 15000 });
  });

  test('checkout page loads or redirects to cart when empty', async ({ page }) => {
    await page.goto('/checkout');
    await expect(page.locator('body')).toBeVisible();
    const url = page.url();
    if (url.includes('cart')) {
      await expect(page).toHaveURL(/cart/);
      return;
    }
    await expect(page.getByRole('heading', { name: /^checkout$/i })).toBeVisible({ timeout: 15000 });
    await expect(page.locator('.woocommerce-checkout, form.checkout, #checkout').first()).toBeVisible({
      timeout: 20000,
    });
  });
});

test.describe('Content pages', () => {
  test('gift card, botanics, about, blog pages render main content', async ({ page }) => {
    const pages: { path: string; check: RegExp }[] = [
      { path: '/gift-card', check: /gift|mell/i },
      { path: '/botanics', check: /botan|mell/i },
      { path: '/about', check: /about|mell/i },
      { path: '/blog', check: /blog|post|mell/i },
    ];
    for (const { path, check } of pages) {
      await page.goto(path);
      await expect(page.locator('#page').first()).toBeVisible();
      await expect(page.locator('body')).toContainText(check);
    }
  });
});

test.describe('Optional authenticated flow', () => {
  test('login with E2E credentials reaches account area', async ({ page }) => {
    const user = process.env.E2E_USER;
    const pass = process.env.E2E_PASSWORD;
    test.skip(!user || !pass, 'Set E2E_USER and E2E_PASSWORD to run login E2E');

    await page.goto('/login');
    // Ultimate Member: common field names
    const userField = page.locator('input[name="username"], input[name="user_login"], input[type="email"]').first();
    const passField = page.locator('input[name="user_password"], input[name="password"], input[type="password"]').first();
    await userField.fill(user!);
    await passField.fill(pass!);
    await page.locator('input[type="submit"], button[type="submit"]').first().click();
    await page.waitForURL(/my-account|account|um\//, { timeout: 30000 }).catch(() => {});
    const onAccount =
      page.url().includes('my-account') ||
      (await page.getByRole('heading', { name: /account|dashboard/i }).count()) > 0;
    expect(onAccount).toBeTruthy();
  });
});
