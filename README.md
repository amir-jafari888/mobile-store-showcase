# Mobile Store Showcase

A lightweight, responsive catalogue website for a mobile phone and accessories store.

## Stack
- PHP 8.1+
- HTML5, CSS3 and vanilla JavaScript
- JSON files for content storage (no database, no e-commerce)

## Scope
Product and category showcase, store information, homepage content, and a small admin foundation. No cart, checkout, payments, orders, or customer accounts.

## Structure
- `pages/`: standalone page views
- `partials/`: reusable homepage sections
- `assets/css/`: shared, mobile, tablet and desktop styles
- `assets/js/`: entry point and modules
- `admin/`: administration entry point
- `app/`: configuration, core, services, middleware and helpers
- `data/`: JSON content; must not be publicly accessible

## Run locally
Use PHP 8.1+ and run from the project root:

```bash
php -S localhost:8000
```

Open http://localhost:8000.

## Security notes
- Keep `data/` outside the public document root in production where possible. The included Apache rules deny direct access as a fallback.
- Set a strong `APP_KEY` environment variable before enabling authenticated admin actions.
- Configure HTTPS in production.
- Uploaded files require server-side MIME, extension, size and image validation before being accepted.
- Admin authentication and write endpoints are intentionally not enabled in this scaffold.

## Status
Initial application scaffold. Product management and authenticated admin workflows are the next implementation phase.
