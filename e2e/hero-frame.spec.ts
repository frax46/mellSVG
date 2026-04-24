import { test, expect } from '@playwright/test';

/**
 * Home page (template: Home Page) replaces the static hero image with a scroll-scrubbed
 * PNG sequence from images/hero_frame when those assets exist.
 */
test.describe('Home hero frame sequence', () => {
  test('hero frame layer exists and advances when scrolling', async ({ page }) => {
    await page.goto('/');
    await page.locator('#loading-overlay').waitFor({ state: 'hidden', timeout: 15000 }).catch(() => {});

    const frameRoot = page.locator('#hero .hero-frame');
    const count = await frameRoot.count();
    test.skip(
      count === 0,
      'No #hero .hero-frame — front page may not use the Home Page template or hero_frame PNGs are missing'
    );

    const active = await frameRoot.getAttribute('data-active-layer');
    expect(active === 'a' || active === 'b').toBeTruthy();
    const img = frameRoot.locator(`.hero-frame-layer--${active}`);
    await expect(img).toBeVisible();

    const srcBefore = await img.getAttribute('src');
    expect(srcBefore).toBeTruthy();
    expect(srcBefore).toMatch(/hero_frame\/Crystal_particle_effects_|Crystal_particle_effects_/);

    await page.evaluate(() => {
      window.scrollTo(0, Math.min(document.documentElement.scrollHeight, 3200));
    });

    await expect
      .poll(async () => {
        const layer = await frameRoot.getAttribute('data-active-layer');
        const el = frameRoot.locator(`.hero-frame-layer--${layer}`);
        return el.getAttribute('src');
      }, {
        timeout: 5000,
      })
      .not.toBe(srcBefore);
  });
});
