# Design system: Editorial

Chosen on 4 November 2026 from the [ui-ux-pro-max](https://github.com/nextlevelbuilder/ui-ux-pro-max-skill) catalogue (MIT licence). It replaces an earlier "Bold agency" (Brutalism) direction, which was tried and set aside the same day. All values live as CSS custom properties at the top of `theme/wpt-acf/assets/css/main.css`.

## Style

**Editorial Grid / Magazine**: print-inspired layout with lots of white space.

- **Masthead:** the site name sits centred in large serif type, with the navigation below it set in small, spaced-out capitals.
- **Asymmetric grids** (roughly 7:4 or 7:5): the headline goes in the wide column, the intro paragraph or image in the narrow one.
- **Numbered kickers** (01, 02, 03) sit above each section heading, on a thick top rule. They come from CSS counters, so editors don't need extra fields.
- **Drop cap:** the first paragraph of rich text opens with a large red initial.
- **Highlights and values:** shown as columns divided by thin rules rather than boxed cards.
- **Services:** set out as numbered features. **Process steps:** numbered with Roman numerals.
- **Team members:** set out like bylines, with the name in serif and the role in red capitals.
- **Call to action:** styled as a large italic pull quote on black.
- **Motion:** headings fade up gently on load, and sections reveal as you scroll. Both stay subtle (16 to 20px, 500 to 700ms).

## Colour

Based on the catalogue's Magazine/Blog palette (editorial black plus a single accent). The accent is the catalogue's news red, darkened one step so small text passes WCAG AA comfortably. The catalogue value `#DC2626` measures 4.63:1 on the background.

| Role | Value | Use | Contrast |
|---|---|---|---|
| Ink | `#18181B` | Text, thick rules, buttons, footer | 17:1 on paper |
| Ink soft | `#52525B` | Card text, labels | 7.4:1 on paper |
| Paper | `#FAFAFA` | Page background | |
| Line | `#D4D4D8` | Thin rules | |
| Accent | `#B91C1C` | Kickers, drop caps, links, button hover | 6.2:1 on paper; white text on it 6.5:1 |
| Accent on dark | `#F87171` | Quote marks and hovers in the footer and call to action | 6.4:1 on ink |

## Type

The catalogue's "Magazine Style" pairing:

- Headings, intro paragraphs and pull quotes: **Libre Bodoni** 400 and 500, with italics
- Body and labels: **Public Sans** 400 and 600

Both load from Google Fonts. Before going live, self-host them, because Google Fonts sends visitor IP addresses to Google (a UK GDPR consideration).

## Accessibility

- All motion sits inside `prefers-reduced-motion: no-preference`. Scroll reveals only run when JavaScript confirms the visitor hasn't asked for reduced motion, so content is never hidden without JavaScript.
- Focus ring: 2px red outline with offset. Buttons are at least 44px tall.
- On small screens, the masthead doesn't stick, and the asymmetric grids stack into a single column.
