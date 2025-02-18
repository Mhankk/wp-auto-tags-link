# Auto Tag Links for Posts

**Description:**  Automatically links tags within your WordPress posts, ensuring that only the *first* instance of each tag is linked. Works seamlessly with both the default WordPress editor and Elementor.

**Version:** 1.8

**Author:** Hakim Winahyu

**License:** GPL v2 or later

**License URI:** [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

## Overview

This plugin simplifies internal linking within your WordPress content.  It automatically detects tags associated with your posts and creates links to the corresponding tag archive pages. A key feature is that it only links the *first* occurrence of each tag within a post, preventing excessive and potentially distracting linking.  It's fully compatible with both the standard WordPress editor and the Elementor page builder.

## Features

*   **Automatic Tag Linking:**  Automatically identifies and links tags in your posts.
*   **Single Instance Linking:**  Links only the first occurrence of each tag, preventing over-linking.
*   **Elementor Compatibility:** Works seamlessly with Elementor's text-editor widget.
*   **Default Editor Compatibility:**  Functions correctly within the standard WordPress editor.
*   **Easy to Use:** Install and activate – no complex configuration required.

## Installation

1.  Upload the `auto-tag-links` folder to the `/wp-content/plugins/` directory.
2.  Activate the "Auto Tag Links for Posts" plugin through the 'Plugins' menu in WordPress.

## Usage

Once activated, the plugin automatically links tags in your posts.  No further configuration is needed.  Simply create or edit posts as usual, and the plugin will handle the linking in the frontend view.

## Frequently Asked Questions (FAQ)

*   **Does this plugin work with custom post types?**  No, this plugin is currently designed to work only with standard WordPress posts ('post' post type).
*   **Can I customize the appearance of the links?**  Yes, but you'll need to use CSS.  The plugin applies inline styling (`text-decoration: none;` to remove underlines), but you can override this (and add other styles) with CSS rules targeted at `<a>` tags within your post content. You may need to use a more specific CSS selector depending on your theme.
*   **Why only link the first instance of each tag?** Linking only the first instance improves readability and prevents over-linking, which can be distracting for readers.
*   **The links aren't working! What do I do?**
    *   Make sure you have tags properly assigned to your posts.
    *   Clear your browser cache and any caching plugins you are using.
    *   Deactivate and reactivate the plugin to ensure it's properly initialized.
    *   Check for conflicts with other plugins by temporarily deactivating them.

## Changelog

*   **1.8**
    *   Updated description in plugin header.
    *   Improved README.md file.

*   **1.7**
    *   Fixed an issue with Elementor compatibility.
    *   Improved performance.

## Contributing

Contributions are welcome!  Please submit pull requests on [your repository, if you have one].  If you don't have a repository, consider creating one on GitHub or GitLab.

## Support

For support or feature requests, please visit [your support page, if you have one. If not, remove this section or link to a contact form on your website].
