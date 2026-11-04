# Design system: Bold agency

Chosen on 4 November 2026 from the [ui-ux-pro-max](https://github.com/nextlevelbuilder/ui-ux-pro-max-skill) catalogue (MIT licence), using its "Marketing Agency" profile. All values live as CSS custom properties at the top of `theme/wpt-acf/assets/css/main.css`.

## Style

- **Brutalism** (structure): square corners, 3px black borders, hard offset shadows, heavy uppercase headings, instant hover states on buttons and cards.
- **Motion-Driven** (movement): entrance animation on page headings, a scrolling marquee of highlight titles on the home page, and scroll reveals with a short stagger (350ms).

The catalogue lists Brutalism as unsuited to conservative or corporate audiences. That's acceptable for this test, but worth revisiting for a real client site.

## Colour

| Role | Value | Use | Contrast |
|---|---|---|---|
| Primary | `#EC4899` | Hero, buttons, link hover | Black text 6.0:1 |
| Accent | `#0891B2` | Page headers, call to action band, focus ring | Black text 5.7:1 |
| Background | `#FDF2F8` | Page background | |
| Ink | `#000000` | Text, borders, shadows, footer | |
| Ink soft | `#831843` | Supporting text | 8.8:1 on background |
| Muted | `#F1EEF5` | Alternate sections | |

Text on pink or cyan is always black. White text on either fails contrast checks.

## Type

- Headings: **Space Grotesk** 700
- Body: **Archivo** 400 and 700

Both load from Google Fonts. Before going live, self-host them, because Google Fonts sends visitor IP addresses to Google (a UK GDPR consideration).

## Accessibility

- All motion sits inside `prefers-reduced-motion: no-preference`. Scroll reveals only run when JavaScript confirms the visitor hasn't asked for reduced motion, so content is never hidden without JavaScript.
- The marquee is decorative and hidden from screen readers. It pauses on hover.
- Focus ring: 3px cyan outline. Buttons are at least 44px tall.
