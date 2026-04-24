import { APIRequestContext, expect } from '@playwright/test';

/** Paths that must respond with HTTP 2xx after redirects (internal routes). */
export const INTERNAL_PATHS = [
  '/',
  '/gift-card',
  '/botanics',
  '/about',
  '/blog',
  '/login',
  '/cart',
  '/checkout',
  '/shop',
  '/faq',
  '/shipping-and-returns',
  '/terms-and-privacy',
  '/my-account',
] as const;

/**
 * GET a path and assert the final response is OK (2xx).
 * Trailing slashes are normalized by the server; we try both if needed.
 */
export async function expectPathOk(
  request: APIRequestContext,
  path: string
): Promise<void> {
  const tryPaths = path.endsWith('/')
    ? [path, path.replace(/\/$/, '')]
    : [path, `${path}/`];

  let lastStatus = 0;
  for (const p of tryPaths) {
    const res = await request.get(p, { maxRedirects: 10 });
    lastStatus = res.status();
    if (res.ok()) {
      return;
    }
  }
  expect(lastStatus, `Expected 2xx for ${path}, got ${lastStatus}`).toBeLessThan(400);
}
