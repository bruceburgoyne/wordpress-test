# wordpress-test

A test project for connecting Claude, WordPress and Advanced Custom Fields (ACF).

The aim is to plan page structure and layout with Claude, then push it into a local WordPress site. There's no page builder: Gutenberg and Elementor are not used. Every content area on every page is an ACF field, so the CMS gives editors clear, fixed controls for each section.

## How it works

```
Claude designs            Repo (Git)                           Local WordPress site
--------------            ----------                           --------------------
page structure   ──►  theme/wpt-acf/acf-json/*.json   ──►  ACF field groups (CMS controls)
layout           ──►  theme/wpt-acf/page-templates/   ──►  how each page renders
copy             ──►  content/pages/*.json            ──►  page content (via WP-CLI)
```

1. **Field groups** (`theme/wpt-acf/acf-json/`): one ACF field group per page template, saved as ACF local JSON. ACF loads them straight from the theme. If you edit a field group in WP Admin, ACF writes the change back to this folder so it can be committed.
2. **Page templates** (`theme/wpt-acf/page-templates/`): plain PHP templates that read the fields and output the HTML. No blocks or shortcodes for layout.
3. **Content** (`content/`): page titles, templates and field values as JSON. `scripts/seed.php` pushes them into WordPress. It's safe to run again: pages are matched by slug and updated.
4. **Theme link**: the theme folder is symlinked into the Local site, so changes in the repo show on the site straight away.

The block editor is switched off for the whole site, and the content box is removed from pages, so ACF fields are the only way to edit a page.

## Pages in this first test

| Page     | Template                         | Content areas (ACF)                                      |
|----------|----------------------------------|----------------------------------------------------------|
| Home     | `page-templates/home.php`        | Hero, Introduction, Highlights (repeater), Call to action |
| About    | `page-templates/about.php`       | Page header, Our story, Values, Team, Call to action      |
| Services | `page-templates/services.php`    | Page header, Services (repeater), Process steps, Call to action |
| Contact  | `page-templates/contact.php`     | Page header, Contact details, Opening hours, Form shortcode, Map |
| Other    | default (`page.php`)             | Page header, Body text                                    |

**Site Settings** (an ACF Pro options page in WP Admin) holds the logo, phone, email, address, social links and footer text used across the site.

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

   This links and activates the theme, sets permalinks to `/%postname%/`, creates the four pages with their content, sets Home as the front page and builds the Primary menu.
4. Open the site. To edit content, go to **Pages** or **Site Settings** in WP Admin.

To push content changes again after editing `content/`, run the same script.

## Changing the structure

- **Add or change fields:** edit the JSON in `acf-json/` (or edit in WP Admin and commit the JSON ACF writes). If ACF shows "Sync available" in **ACF > Field Groups**, sync it so the database matches the files.
- **Add a page type:** add a template in `page-templates/`, a field group whose location rule is that template, and a JSON file in `content/pages/`.
- Field values in `content/` overwrite what is in WordPress when the script runs. Once real editing starts in WP Admin, stop re-running the script for those pages, or remove them from `content/`.

## Not covered yet

- Images are not seeded. Add them in WP Admin.
- The contact form needs a form plugin. Paste its shortcode into the Contact page's Form tab.
- Deployment to a live server.
