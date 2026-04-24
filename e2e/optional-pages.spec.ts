import { test, expect } from '@playwright/test';

/**
 * Pages that exist in the theme (`page-cookie-policy.php`, etc.) but may use a different
 * WordPress slug or not be published yet. Passes when the URL returns 2xx; skips otherwise.
 */
test('cookie policy URL responds when the page is published', async ({ request }) => {
  const res = await request.get('/cookie-policy', { maxRedirects: 10 });
  if (res.status() === 404) {
    test.skip();
  }
  expect(res.ok()).toBeTruthy();
});
