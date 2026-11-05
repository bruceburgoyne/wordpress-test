#!/usr/bin/env bash
# Link the WPT ACF theme into a Local site, activate it and push the content.
#
# Run this from Local's "Open site shell" (right-click the site in Local),
# which puts you in the site's app/public folder with WP-CLI available:
#
#   bash ~/Documents/GitHub/wordpress-test/scripts/setup-site.sh
#
# Safe to run again whenever the content/ files change.

set -euo pipefail

REPO="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
THEME_SLUG="wpt-acf"
THEME_SRC="$REPO/theme/$THEME_SLUG"

fail() { echo "Error: $*" >&2; exit 1; }

command -v wp >/dev/null 2>&1 || fail "WP-CLI not found. Open this site's shell from the Local app and run the script there."
wp core is-installed 2>/dev/null || fail "No WordPress site here. Run this from the site shell, which starts in app/public."

THEMES_DIR="$(wp eval 'echo get_theme_root();')"
THEME_LINK="$THEMES_DIR/$THEME_SLUG"

# 1. Link the theme from the repo, so edits in Git show up on the site straight away.
if [ -L "$THEME_LINK" ]; then
  echo "Theme already linked: $THEME_LINK"
elif [ -e "$THEME_LINK" ]; then
  fail "$THEME_LINK already exists and is not a link. Move it aside and run again."
else
  ln -s "$THEME_SRC" "$THEME_LINK"
  echo "Linked theme: $THEME_LINK -> $THEME_SRC"
fi

# 2. ACF Pro must be installed by hand, because it needs a licence.
if ! wp plugin is-active advanced-custom-fields-pro 2>/dev/null; then
  fail "ACF Pro is not active. Upload the ACF Pro zip in WP Admin > Plugins > Add New, activate it, then run this again."
fi

# 3. Activate the theme and use readable URLs.
wp theme activate "$THEME_SLUG"
wp rewrite structure '/%postname%/' --quiet
wp rewrite flush --quiet

# 4. UK date format for article dates (for example, 3 November 2026).
wp option update date_format 'j F Y' --quiet

# 5. Push pages, fields, settings, the menu and the blog articles.
wp eval-file "$REPO/scripts/seed.php" "$REPO/content"

echo
echo "Done. Visit $(wp option get home)"
