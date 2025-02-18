<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/*
Plugin Name: Auto Tag Links for Posts
Description: Menambahkan link tag secara otomatis hanya pada satu instance per tag di postingan (baik default editor maupun Elementor). Jika link sudah ada, instance selanjutnya tidak akan di-link.
Version: 1.8
Author: Hakim Winahyu
*/

function auto_link_tags_dom_single_occurrence($content) {
    if (empty($content)) {
        return $content;
    }
    
    // Inisialisasi DOMDocument dan load konten
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    libxml_clear_errors();
    
    $xpath = new DOMXPath($doc);
    $tags = get_tags();
    
    // Array untuk melacak apakah tag sudah pernah di-link
    $linkedTags = array();
    
    // Inisialisasi: cek apakah sudah ada link untuk masing-masing tag di konten awal
    foreach ($tags as $tag) {
        $tag_link = esc_url(get_tag_link($tag->term_id));
        // Menggunakan contains() agar pencarian tidak harus persis sama
        $existingLinks = $xpath->query("//a[contains(@href, '$tag_link')]");
        $linkedTags[$tag->term_id] = ($existingLinks->length > 0);
    }
    
    // Proses setiap tag; hanya satu instance per tag yang akan di-link
    foreach ($tags as $tag) {
        // Jika tag sudah pernah di-link, lewati pemrosesan tag ini
        if ($linkedTags[$tag->term_id]) {
            continue;
        }
        
        $replaced = false;
        $tag_name = $tag->name;
        $tag_link = esc_url(get_tag_link($tag->term_id));
        
        // Dapatkan semua text node yang bukan merupakan bagian dari tag <a>
        $textNodes = $xpath->query("//text()[not(ancestor::a)]");
        foreach ($textNodes as $node) {
            if ($replaced) {
                break;
            }
            $originalText = $node->nodeValue;
            // Cek apakah terdapat kata tag dengan batasan kata yang tepat (case-insensitive)
            if (preg_match('/\b(' . preg_quote($tag_name, '/') . ')\b/i', $originalText)) {
                // Ganti hanya 1 instance saja
                $newText = preg_replace(
                    '/\b(' . preg_quote($tag_name, '/') . ')\b/i',
                    '<a href="' . $tag_link . '" style="text-decoration: none;">$1</a>',
                    $originalText,
                    1
                );
                if ($newText !== $originalText) {
                    $fragment = $doc->createDocumentFragment();
                    $fragment->appendXML($newText);
                    $node->parentNode->replaceChild($fragment, $node);
                    $replaced = true;
                    // Tandai tag sebagai sudah di-link sehingga tidak diproses lagi
                    $linkedTags[$tag->term_id] = true;
                    break;
                }
            }
        }
    }
    
    // Ambil konten yang telah dimodifikasi dari dalam <body>
    $body = $doc->getElementsByTagName('body')->item(0);
    $modifiedContent = '';
    foreach ($body->childNodes as $child) {
        $modifiedContent .= $doc->saveHTML($child);
    }
    return $modifiedContent;
}

/**
 * Filter untuk konten postingan dari default editor.
 */
function auto_tag_links_for_posts($content) {
    // Pastikan hanya diterapkan pada postingan
    if ('post' !== get_post_type()) {
        return $content;
    }
    // Jika postingan dibuat dengan Elementor, biarkan filter Elementor yang memproses
    if (defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID())) {
        return $content;
    }
    return auto_link_tags_dom_single_occurrence($content);
}
add_filter('the_content', 'auto_tag_links_for_posts');

/**
 * Filter untuk widget Elementor (misalnya text-editor).
 */
function auto_tag_links_for_elementor($content, $widget) {
    // Pastikan hanya diterapkan pada postingan
    if ('post' !== get_post_type(get_the_ID())) {
        return $content;
    }
    // Target hanya widget text-editor; jika ada widget lain yang perlu diproses, tambahkan kondisinya
    if ('text-editor' !== $widget->get_name()) {
        return $content;
    }
    return auto_link_tags_dom_single_occurrence($content);
}
add_filter('elementor/widget/render_content', 'auto_tag_links_for_elementor', 10, 2);
