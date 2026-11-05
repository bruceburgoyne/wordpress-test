# wordpress-test

A test project for connecting Claude, WordPress and Advanced Custom Fields (ACF).

The aim is to plan page structure and layout with Claude, then push it into a local WordPress site. Pages use no page builder: Gutenberg and Elementor are not used on them. Every content area on every page is an ACF field, so the CMS gives editors clear, fixed controls for each section.

The blog is the one exception. Articles are written in the block editor (Gutenberg), because long-form writing needs free-flowing text, images and quotes. The editor is cut down to writing tools only, and the design stays in the theme. See [Blog](#blog) below.

## How it works

```
Claude designs            Repo (Git)                           Local WordPress site
--------------            ----------                           --------------------
page structure   ──►  theme/wpt-acf/acf-json/*.json   ──►  ACF field groups (CMS controls)
layout           ──►  theme/wpt-acf/page-templates/   ──►  how each page renders
copy             ──►  content/pages/*.json            ──►  page content (via WP-CLI)
articles         ──►  content/posts/*.json + *.html   ──►  blog articles (via WP-CLI)
```

1. **Field groups** (`theme/wpt-acf/acf-json/`): one ACF field group per page template, saved as ACF local JSON. ACF loads them straight from the theme. If you edit a field group in WP Admin, ACF writes the change back to this folder so it can be committed.
2. **Page templates** (`theme/wpt-acf/page-templates/`): plain PHP templates that read the fields and output the HTML. No blocks or shortcodes for layout.
3. **Content** (`content/`): page titles, templates and field values as JSON. `scripts/seed.php` pushes them into WordPress. It's safe to run again: pages are matched by slug and updated.
4. **Theme link**: the theme folder is symlinked into the Local site, so changes in the repo show on the site straight away.

The content box is removed from pages, so ACF fields are the only way to edit a page. The block editor is switched on for blog articles (posts) only.

## Pages in this first test

| Page     | Template                         | Content areas (ACF)                                      |
|----------|----------------------------------|----------------------------------------------------------|
| Home     | `page-templates/home.php`        | Hero (label, heading with highlighted ending, image), Introduction, Highlights (repeater), Call to action |
| About    | `page-templates/about.php`       | Page header, Our story, Values, Team, Call to action      |
| Services | `page-templates/services.php`    | Page header, Services (repeater), Process steps, Call to action |
| Contact  | `page-templates/contact.php`     | Page header, Contact details, Opening hours, Form shortcode, Map |
| Blog     | `home.php` (the Posts page)      | Blog header, Call to action (also used under every article) |
| Other    | default (`page.php`)             | Page header, Body text                                    |

**Site Settings** (an ACF Pro options page in WP Admin) holds the logo, header button, phone, email, address, social links and footer text used across the site.

## Blog

The blog has an archive (the **Blog** page, plus a page for each topic and tag) and a single article page.

| Template | Shows |
|---|---|
| `home.php` | The Blog page: header from ACF, topic filter, the newest article as a large lead story, then a grid of cards and page numbers. Set as the Posts page in **Settings > Reading**. |
| `archive.php` | Topic (category), tag, author and date archives, in the same layout without the lead story. |
| `single.php` | An article: topic, title, standfirst, byline with reading time, featured image, the block content, tags, then three more articles and the call to action. |

How the block editor fits in:

- **Posts only.** `inc/editor.php` turns the block editor on for posts and leaves pages on ACF. Block CSS loads on single articles only, so the ACF pages are untouched.
- **Writing tools, not design tools.** `theme.json` switches off colour, font size, spacing, border and typography controls. Writers get a short list of blocks: paragraph, heading (H2 to H4), list, quote, pull quote, image, gallery, video, embed, table, separator, buttons and footnotes.
- **What you see is what you get.** `assets/css/article.css` styles the blocks. The same file is loaded into the editor and onto the site, so articles look the same in both.
- **ACF alongside blocks.** An "Article details" panel in the editor's sidebar holds the **Standfirst**, the short summary shown under the title and on the blog cards. It replaces the standard excerpt. The Blog page's own ACF fields hold the blog header and the call to action used under every article.
- **Featured image** is the standard WordPress one, shown on cards and at the top of the article.

To push only the blog (the Blog page, the menu and the articles in `content/posts/`) without touching the other pages or Site Settings, run this from the site shell:

```bash
wp eval-file ~/Documents/GitHub/wordpress-test/scripts/seed.php ~/Documents/GitHub/wordpress-test/content blog
```

Each article in `content/posts/` is a pair of files with the same name: a `.json` file (title, date, topics, tags and ACF fields) and a `.html` file holding the body as block editor markup. The four articles there are sample content.

## Set-up

You need:

- [Local](https://localwp.com/)
- An ACF Pro licence and the plugin zip
- This repo cloned to `~/Documents/GitHub/wordpress-test`

Steps:

1. In Local, create a new site (for example `wordpress-test`) with the preferred environment.
2. Open WP Admin, go to **Plugins > Add New > Upload Plugin**, upload the ACF Pro zip and activate it.
3. In Local, right-click the site and choose **Open site shell**. Then run:

   ```bash
   bash ~/Documents/GitHub/wordpress-test/scripts/setup-site.sh
   ```

   This links and activates the theme, sets permalinks to `/%postname%/` and a UK date format, creates the pages with their content, sets Home as the front page and Blog as the posts page, adds the sample articles and builds the Primary menu.
4. Open the site. To edit content, go to **Pages** or **Site Settings** in WP Admin.

To push content changes again after editing `content/`, run the same script.

## Changing the structure

- **Add or change fields:** edit the JSON in `acf-json/` (or edit in WP Admin and commit the JSON ACF writes). If ACF shows "Sync available" in **ACF > Field Groups**, sync it so the database matches the files.
- **Add a page type:** add a template in `page-templates/`, a field group whose location rule is that template, and a JSON file in `content/pages/`.
- Field values in `content/` overwrite what is in WordPress when the script runs. Once real editing starts in WP Admin, stop re-running the script for those pages, or remove them from `content/`. The `blog` option above leaves the other pages alone.

## Not covered yet

- Images are not seeded. Add them in WP Admin, including featured images for articles.
- Comments are switched off for articles.
- The contact form needs a form plugin. Paste its shortcode into the Contact page's Form tab.
- Deployment to a live server.
