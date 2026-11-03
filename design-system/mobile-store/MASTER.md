# Mobile Store — Lilac Design System

## Direction
A premium, editorial digital showroom for a physical mobile and accessories store. The interface should feel calm, clear and dependable rather than like a high-pressure checkout funnel. The product imagery is illustrative until the store's real inventory photography is connected.

## Palette
| Token | Hex | Role |
| --- | --- | --- |
| Primary | #9D70B0 | Primary actions and key interactive states |
| Primary dark | #704B82 | High-contrast accents and active states |
| Lilac | #B58BC6 | Brand highlight |
| Pale lilac | #EEE3F2 | Soft emphasis and selected surfaces |
| Background | #F8F6F9 | Main canvas |
| Surface | #FFFFFF | Cards and content surfaces |
| Surface secondary | #F1EDF3 | Alternate section backgrounds |
| Ink | #261F2B | Primary text |
| Muted | #716878 | Secondary text |
| Border | #E8E1EB | Dividers and outlines |
| Dark plum | #2C2232 | Hero, footer and dark panels |

## Typography
- Existing Persian-safe system stack: Tahoma, Arial, sans-serif.
- Strong editorial headlines with tight tracking and fluid sizing.
- Body copy remains comfortably readable and uses generous line-height.
- Small uppercase English labels are metadata only, never the only source of meaning.

## Layout and spacing
- Desktop content max-width: 1240px.
- Responsive gutters: 24px desktop, 28px tablet, 16px mobile.
- Spacing rhythm follows a 4px base and an 8px cadence.
- Card radii: 18–24px; larger feature imagery may use asymmetric 28–90px corners.
- Separate desktop, tablet and mobile CSS layers; no horizontal overflow.

## Interaction and accessibility
- Visible keyboard focus, semantic navigation and descriptive image alternatives.
- Interactive targets maintain at least 44px touch height on mobile.
- Motion is limited to short hover/feedback transitions and respects prefers-reduced-motion.
- Do not invent store ratings, customer quotes, stock levels, delivery promises, addresses or contact details.
- Label demo products and imagery as illustrative until real catalogue data is connected.

## Component intent
- Hero: one clear statement, short explanation and a single primary route into the catalogue.
- Category cards: help visitors narrow the showroom by product family.
- Product cards: present the category and direct visitors to ask the store for current availability.
- Trust strip: communicate the site's real purpose without fabricated proof.
- Footer/contact: provide navigation and clearly distinguish missing sample contact data.
