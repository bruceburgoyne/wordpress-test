# Design system: Editorial

Chosen on 4 November 2026 from the [ui-ux-pro-max](https://github.com/nextlevelbuilder/ui-ux-pro-max-skill) catalogue (MIT licence). It replaces an earlier "Bold agency" (Brutalism) direction, which was tried and set aside the same day. All values live as CSS custom properties in `theme/wpt-acf/assets/css/tokens.css`, which the site and the block editor both load.

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
- **Motion:** none on page content. There are no fade-ins on load, scroll reveals or image zooms, so everything is visible straight away. Only links and buttons change on hover (colour, underline, the button arrow), plus the mobile menu below.

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

## Service pages

- **Header:** "Services" in rust capitals above the title, linking back to the Services page.
- **Sections:** an optional wide image (21:9, 4:3 on phones), then the overview, what's included (rule-divided columns, like the values), common questions and other services, all with the numbered section kickers.
- **Common questions:** each question opens and closes in place, with a rust + or − on the right and rules between them. There's no animation.
- **Services page:** each service title links to its page, with a "Find out more" text link under the description.
- **Service tiles** (Home page and "Other services"): cream cards with a thin border and a rust top rule, an optional 3:2 image, a large rust serif number (01, 02, 03), a serif title, the service's introduction and "Find out more" with a rust arrow. The whole tile is clickable. On hover the border and title turn rust, and nothing moves.

## Blog

Articles reuse the same palette, type and rules, with a few additions.

- **Blog page:** the newest article leads, with the image on the left (7:5) and a large serif title. The rest sit in a grid of cards, each with a thick rule on top, an optional 3:2 image, the topic in rust capitals with the date, a serif title and the standfirst. A row of topic links sits above, with the current one underlined in rust.
- **Article header:** topic in rust capitals, a large serif title, the standfirst in italic serif, and a byline (author, date, reading time) under a thin rule.
- **Article layout:** text sits in a 42rem column on the left of a 64rem frame, the same asymmetric idea as the page grids. Wide images fill the frame, full-width images fill the screen, and right-aligned images sit in the margin on wide screens.
- **Blocks:** the opening paragraph has the drop cap. Pull quotes are large italic serif with rust quote marks between a thick and a thin rule, like the call to action band. Quotes have a rust rule on the left. Lists have rust markers. Separators are a short rust rule. Tables use rules only. Buttons match the site's rust button.
- **Editor:** the block editor shows the same fonts, colours and block styles (`tokens.css`, `editor.css` and `article.css`), so writers see roughly what readers will see. Colour, size and spacing controls are switched off in `theme.json`.

## Accessibility

- Page content never moves or hides, with or without JavaScript. The mobile menu opens and closes instantly for visitors who prefer reduced motion.
- Focus ring: 2px red outline with offset. Buttons, tags and page numbers are at least 44px tall.
- Articles have one H1 (the title). Headings in the editor are limited to H2 to H4 so the outline stays in order.
- On small screens, the masthead doesn't stick, and the asymmetric grids stack into a single column.
