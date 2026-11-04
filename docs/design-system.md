# Design system: Editorial

Chosen on 4 November 2026 from the [ui-ux-pro-max](https://github.com/nextlevelbuilder/ui-ux-pro-max-skill) catalogue (MIT licence). It replaces an earlier "Bold agency" (Brutalism) direction, which was tried and set aside the same day. All values live as CSS custom properties at the top of `theme/wpt-acf/assets/css/main.css`.

Later the same day, the palette was softened to warm creams and browns. The header and home hero were also rebuilt to follow a reference mock-up supplied by Bruce.

## Style

**Editorial Grid / Magazine**: print-inspired layout with lots of white space.

- **Header:** the logo or site name sits on the left. On the right are the navigation links in sentence case (the current page underlined in rust) and an optional rust button, set in **Site Settings > Header**. That button is hidden on phones, because the hero and the Contact link already cover it.
- **Home hero:** a split layout. On the left: a rust capitals label, a large serif headline with an optional italic rust ending, an intro paragraph, then a rust button with an arrow and an underlined text link. On the right: the hero image, filling the half to the edge of the screen. On phones the text comes first, with the image below it in a 4:3 crop.
- **Side margins:** these grow with screen width (from 1rem up to 4rem), and the logo and hero text always line up.
- **Asymmetric grids** (roughly 7:4 or 7:5): the headline goes in the wide column, the intro paragraph or image in the narrow one.
- **Numbered kickers** (01, 02, 03) sit above each section heading, on a thick top rule. They come from CSS counters, so editors don't need extra fields.
- **Drop cap:** the first paragraph of rich text opens with a large red initial.
- **Highlights and values:** shown as columns divided by thin rules rather than boxed cards.
- **Services:** set out as numbered features. **Process steps:** numbered with Roman numerals.
- **Team members:** set out like bylines, with the name in serif and the role in red capitals.
- **Call to action:** styled as a large italic pull quote on a sand background.
- **Motion:** headings fade up gently on load, and sections reveal as you scroll. Both stay subtle (16 to 20px, 500 to 700ms).

## Colour

A warm, soft palette with no pure blacks or greys. The values are sampled from the reference mock-up, keeping the catalogue's "one accent" editorial approach.

| Role | Value | Use | Contrast |
|---|---|---|---|
| Ink | `#2B211B` | Headings (warm dark brown) | 14.1:1 on paper |
| Ink soft | `#5E5249` | Body text, nav links, thick rules | 6.8:1 on paper |
| Paper | `#F7F2E9` | Page background (cream) | |
| Card | `#FDFAF4` | Alternate sections | |
| Muted | `#EFE7DA` | Sand, call to action band | |
| Line | `#E2D8C8` | Thin rules, text-link underline | |
| Accent | `#9A3412` | Rust: buttons, kickers, drop caps, italic headline ending | 6.6:1 on paper; white text on it 7.3:1 |
| Accent hover | `#7C2D12` | Button hover | |
| Dark | `#3A2B22` | Footer (deep warm brown) | Cream text on it 12.2:1 |
| Accent on dark | `#F0A37F` | Footer link hover | 6.6:1 on dark |

## Type

The catalogue's "Magazine Style" pairing:

- Headings, intro paragraphs and pull quotes: **Libre Bodoni** 400 and 500, with italics
- Body and labels: **Public Sans** 400 and 600

Both load from Google Fonts. Before going live, self-host them, because Google Fonts sends visitor IP addresses to Google (a UK GDPR consideration).

## Mobile menu

Below 48rem (768px), a burger button replaces the header navigation.

- **Panel:** slides in from the left, using the sand background. It's 84% of the screen width, up to a maximum of 22rem, and pushes the whole page across by the same amount. A soft brown wash dims the pushed page.
- **Timing:** the panel takes 450ms. Once it's about 70% in, the links and the header button fade up one after another, 80ms apart.
- **Links:** centred, in large Libre Bodoni. On hover or keyboard focus a rust underline grows out from the centre (350ms), and the text turns rust. The current page keeps its underline.
- **Closing:** the × button, Escape, tapping the pushed page, choosing a link, or widening the screen past the breakpoint all close the menu.
- **Accessibility:** the panel is a labelled dialog. While it's open, the page behind is inert, so keyboard focus can't leave the panel. Focus moves to the first link on open and back to the burger on close.
- **Without JavaScript:** the normal header links stay visible, and there's no burger.
- Files: `header.php` (markup), `assets/js/menu.js` (behaviour), and the "Mobile menu" section at the end of `main.css`.

## Accessibility

- All motion sits inside `prefers-reduced-motion: no-preference`, and the mobile menu opens and closes instantly for visitors who prefer reduced motion. Scroll reveals only run when JavaScript confirms the visitor hasn't asked for reduced motion, so content is never hidden without JavaScript.
- Focus ring: 2px red outline with offset. Buttons are at least 44px tall.
- On small screens, the masthead doesn't stick, and the asymmetric grids stack into a single column.
