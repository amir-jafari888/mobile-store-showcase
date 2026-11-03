# Mobile Media — Lilac Design System

## Design direction
A calm, premium digital showroom for a physical mobile and accessories store. The experience prioritizes clarity, product discovery and trustworthy contact paths over a high-pressure checkout funnel. The existing backend, dynamic store settings, catalog routes and menu behavior remain the source of truth.

## Color palette
| Token | Hex | Role |
| --- | --- | --- |
| Primary | #9D70B0 | Primary actions and interactive states |
| Primary dark | #704B82 | High-contrast accents and active states |
| Lilac | #B58BC6 | Brand highlight and decorative accents |
| Pale lilac | #EEE3F2 | Selected and soft-emphasis surfaces |
| Background | #F8F6F9 | Main canvas |
| Surface | #FFFFFF | Cards and content surfaces |
| Surface secondary | #F1EDF3 | Alternate section backgrounds |
| Ink | #261F2B | Primary text |
| Muted | #716878 | Secondary text |
| Border | #E8E1EB | Dividers and outlines |
| Dark plum | #2C2232 | Benefits, footer and dark panels |

## Typography
- Persian-first stack: Vazirmatn with Tahoma and Arial fallbacks.
- Editorial headlines use strong weight, controlled line length and fluid sizing.
- Body copy keeps comfortable line-height and readable contrast.
- English micro-labels are decorative metadata and never carry essential meaning alone.

## Layout and responsive behavior
- Content max-width: 1240px.
- Desktop, tablet and mobile styles remain separate.
- 4px base spacing with an 8px rhythm.
- Rounded cards and surfaces use a restrained 18–28px radius.
- Mobile navigation retains the existing drawer/backdrop interaction and minimum 44px controls.
- No horizontal overflow; grids collapse progressively for tablet and mobile.

## Accessibility and interaction
- Preserve semantic landmarks, skip link, descriptive navigation labels and visible keyboard focus.
- Respect `prefers-reduced-motion`.
- Keep touch targets at least 44px where practical.
- Preserve existing URL helpers, dynamic store settings, catalog filtering and hero slider behavior.
- Do not fabricate ratings, customer testimonials, inventory status, delivery promises, addresses or contact details.
- Product imagery and demo content remain illustrative unless replaced with the store's actual inventory.

## Component intent
- Hero: communicate the showroom purpose and provide clear catalogue navigation.
- Trust strip: explain the service honestly without invented proof points.
- Category cards: help visitors browse product families.
- Product cards: provide a concise summary and a route to the detail page.
- Contact CTA and footer: expose configured store contact information and clearly indicate when it has not been configured.
