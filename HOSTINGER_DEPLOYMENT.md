# Hostinger GitHub Deployment

This repository includes a GitHub Actions workflow that deploys the WordPress theme to Hostinger whenever `main` is pushed.

## Required GitHub Secrets

Add these in GitHub:

`Settings` > `Secrets and variables` > `Actions` > `New repository secret`

| Secret | Example | Notes |
| --- | --- | --- |
| `HOSTINGER_SSH_HOST` | `123.123.123.123` or `your-domain.com` | Hostinger SSH hostname. |
| `HOSTINGER_SSH_PORT` | `65002` | Hostinger often uses a custom SSH port. Check hPanel. |
| `HOSTINGER_SSH_USER` | `u123456789` | Your Hostinger SSH username. |
| `HOSTINGER_SSH_PRIVATE_KEY` | `-----BEGIN OPENSSH PRIVATE KEY-----...` | Private key for the deploy user. Do not use a passphrase for GitHub Actions. |
| `HOSTINGER_THEME_PATH` | `/home/u123456789/domains/example.com/public_html/wp-content/themes/mellluxeSVG` | Full remote path to this active theme folder. |

## Hostinger Setup

1. In Hostinger hPanel, enable SSH access for the site.
2. Add a new SSH public key for deployment.
3. Copy the matching private key into the GitHub secret `HOSTINGER_SSH_PRIVATE_KEY`.
4. Confirm the remote theme path in Hostinger File Manager.
5. Push to `main`, or run the workflow manually from GitHub Actions.

## Generated Deploy Key

A deploy key pair has been generated locally and is ignored by Git:

- Public key for Hostinger: `.deploy/hostinger_deploy_key.pub`
- Private key for GitHub secret `HOSTINGER_SSH_PRIVATE_KEY`: `.deploy/hostinger_deploy_key`

Only paste the public key into Hostinger. Only paste the private key into GitHub Actions secrets.

## What Gets Deployed

The workflow syncs this theme repository into the Hostinger theme directory with `rsync --delete`.

It excludes local/dev files:

- `.git/`
- `.github/`
- `node_modules/`
- Playwright reports and test results

Because `--delete` is enabled, files removed from GitHub are also removed from the live theme folder on Hostinger. This is usually what you want for a theme deployment.
