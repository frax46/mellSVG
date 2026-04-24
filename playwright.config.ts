import { defineConfig, devices } from '@playwright/test';

/**
 * E2E tests for the Mell Luxe theme. Set PLAYWRIGHT_BASE_URL to your local or staging site.
 * Example: PLAYWRIGHT_BASE_URL=http://radi-web.local npx playwright test
 */
export default defineConfig({
  testDir: './e2e',
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,
  reporter: process.env.CI ? 'github' : [['list'], ['html', { open: 'never' }]],
  use: {
    baseURL: process.env.PLAYWRIGHT_BASE_URL || 'http://radi-web.local',
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },
  ],
});
