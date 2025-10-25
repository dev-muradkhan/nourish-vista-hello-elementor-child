<?php
function mytheme_move_jquery_to_footer() {
    wp_scripts()->add_data( 'jquery', 'group', 1 );
    wp_scripts()->add_data( 'jquery-core', 'group', 1 );
    wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'mytheme_move_jquery_to_footer' );

add_theme_support( 'post-thumbnails' );

// Remove Feed Link
function disable_feed_links() {
     remove_action('wp_head', 'feed_links', 2);
     remove_action('wp_head', 'feed_links_extra', 3);
     }
     add_action('init', 'disable_feed_links');


/**
 * Enqueue JavaScript for Child Theme
 */
function child_theme_enqueue_scripts() {

    // Enqueue parent theme stylesheet.
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // Enqueue child theme stylesheet.
    wp_enqueue_style( 'child-theme-style', get_stylesheet_directory_uri() . '/style.css' );
	
	// Enqueue parent theme stylesheet.
    wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', array('child-theme-style'), '1.0', 'all' );

    // Enqueue custom JavaScript file from child theme.
    wp_enqueue_script( 'child-theme-script', get_stylesheet_directory_uri() . '/assets/js/theme.js', array('jquery'), '1.0', true ); 

}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_scripts' );

// This NEW hook loads the exact same styles and scripts inside the Elementor editor
add_action( 'elementor/editor/before_enqueue_scripts', 'child_theme_enqueue_scripts' );


// theme widget
function my_theme_register_sidebars() {

    register_sidebar( array(
        'name'          => __( 'My Custom Sidebar', 'your-theme-textdomain' ),
        'id'            => 'my-custom-sidebar',
        'description'   => __( 'Widgets in this area will be shown on all pages.', 'your-theme-textdomain' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // You can register more sidebars here, just duplicate the above block and change the values.
    register_sidebar( array(
        'name'          => __( 'Another Sidebar', 'your-theme-textdomain' ),
        'id'            => 'another-sidebar',
        'description'   => __( 'Widgets for the footer.', 'your-theme-textdomain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
	
	
	// You can register more sidebars here, just duplicate the above block and change the values.
    // register_sidebar( array(
    //     'name'          => __( 'Case Result Sidebar', 'your-theme-textdomain' ),
    //     'id'            => 'case-result-sidebar',
    //     'description'   => __( 'Widgets for the Sidebar.', 'your-theme-textdomain' ),
    //     'before_widget' => '<div id="%1$s" class="widget %2$s">',
    //     'after_widget'  => '</div>',
    //     'before_title'  => '<h3 class="widget-title">',
    //     'after_title'   => '</h3>',
    // ) );

}
add_action( 'widgets_init', 'my_theme_register_sidebars' );

/**
 * Function to display a custom sidebar.
 *
 * @param string $sidebar_id The ID of the sidebar to display.
 */
function my_theme_display_sidebar( $sidebar_id ) {
    if ( is_active_sidebar( $sidebar_id ) ) {
        dynamic_sidebar( $sidebar_id );
    } else {
        // Optional: Display a message if the sidebar is empty.
        // echo '<p>No widgets added to this sidebar.</p>';
    }
}

// Example usage within your theme's template files (e.g., sidebar.php, single.php):
// my_theme_display_sidebar( 'my-custom-sidebar' );
// my_theme_display_sidebar( 'another-sidebar' );




//Title attribute solution for posts widget

function add_title_attribute_to_elementor_posts( $content, $widget ) {
    if ( 'posts' === $widget->get_name() ) {
        $dom = new DOMDocument();
        @$dom->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
        $xpath = new DOMXPath( $dom );

		// Add title attributes to post titles
        $Post_Thumbnail_links = $xpath->query( '//a[contains(@class, "elementor-post__thumbnail__link")]' );
        if ($Post_Thumbnail_links->length > 0) {
            foreach ( $Post_Thumbnail_links as $link ) {
                $href = $link->getAttribute( 'href' );
                if ( $href ) {
                    $post_id = url_to_postid( $href );
                    if ( $post_id ) {
                        $post_title = get_the_title( $post_id );
                        $link->setAttribute( 'title', esc_attr( $post_title ) );
                    }
                }
            }
        }

        // Add title attributes to post titles
        $title_links = $xpath->query( '//h3[@class="elementor-post__title"]/a' );
        if ($title_links->length > 0) {
            foreach ( $title_links as $link ) {
                $href = $link->getAttribute( 'href' );
                if ( $href ) {
                    $post_id = url_to_postid( $href );
                    if ( $post_id ) {
                        $post_title = get_the_title( $post_id );
                        $link->setAttribute( 'title', esc_attr( $post_title ) );
                    }
                }
            }
        }
		
		// Add title attributes to post titles
        $title_links = $xpath->query( '//h2[@class="elementor-post__title"]/a' );
        if ($title_links->length > 0) {
            foreach ( $title_links as $link ) {
                $href = $link->getAttribute( 'href' );
                if ( $href ) {
                    $post_id = url_to_postid( $href );
                    if ( $post_id ) {
                        $post_title = get_the_title( $post_id );
                        $link->setAttribute( 'title', esc_attr( $post_title ) );
                    }
                }
            }
        }

		// Add title attributes to "Read More" buttons
        // **Replace 'elementor-post__read-more' with the correct class if needed**
        $read_more_links = $xpath->query( '//a[contains(@class, "elementor-post__read-more")]' );
        if ($read_more_links->length > 0) {
            foreach ( $read_more_links as $link ) {
                $href = $link->getAttribute( 'href' );
                if ( $href ) {
                    $post_id = url_to_postid( $href );
                    if ( $post_id ) {
                        $post_title = get_the_title( $post_id );
                        $link->setAttribute( 'title', esc_attr( $post_title ) );
                    }
                }
            }
        }



        $content = $dom->saveHTML();
        $content = preg_replace( '~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $content );

        return $content;
    }
    return $content;
}
add_filter( 'elementor/widget/render_content', 'add_title_attribute_to_elementor_posts', 10, 2 );

// Title Attribute  for img in elementor Posts Widget

function add_alt_as_title_to_elementor_posts_thumbnails($content) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8')); // Handle encoding issues
    $xpath = new DOMXPath($dom);

    $thumbnails = $xpath->query('//div[contains(@class, "elementor-post__thumbnail")]/img');

    if ($thumbnails->length > 0) {
        foreach ($thumbnails as $thumbnail) {
            $alt = $thumbnail->getAttribute('alt');
            if ($alt) {
                $thumbnail->setAttribute('title', $alt);
            }
        }
        $content = $dom->saveHTML($dom->documentElement);
    }
    return $content;
}

add_filter('elementor/widget/render_content', 'add_alt_as_title_to_elementor_posts_thumbnails', 10, 2);



// Title Attribute for img in elementor Featured Image Widget
function add_alt_as_title_to_all_elementor_images($content) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($dom);

    $images = $xpath->query('//img'); // Select all <img> tags

    if ($images->length > 0) {
        foreach ($images as $image) {
            $alt = $image->getAttribute('alt');
            if ($alt) {
                $image->setAttribute('title', $alt);
            }
        }
        $content = $dom->saveHTML($dom->documentElement);
    }

    return $content;
}
add_filter('elementor/widget/render_content', 'add_alt_as_title_to_all_elementor_images', 10, 2);

// common image title tag
//img tag
function add_title_to_images($content) {
    $content = preg_replace_callback('/<img[^>]+alt="([^"]+)"[^>]+>/i', function($matches) {
        $alt = $matches[1];
        return str_replace('>', ' title="' . esc_attr($alt) . '">', $matches[0]);
    }, $content);
    return $content;
}
add_filter('the_content', 'add_title_to_images');


//Post title widget for "Post title" widget

function add_title_attributes_to_blog_card() {
    // Target the appropriate elements using JavaScript and jQuery (if available)

    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Check if jQuery is available
            if (typeof jQuery !== 'undefined') {
                jQuery('.BlogCard .elementor-heading-title a, .BlogCard .elementor-widget-button a, .BlogCard .elementor-widget-theme-post-featured-image a').each(function() {
                    var titleText = jQuery(this).closest('.BlogCard').find('.elementor-heading-title a').text().trim(); // Get the title from .elementor-heading-title a
                    if (titleText) {
                        jQuery(this).attr('title', titleText);
                    }
                });
            } else {
                // Vanilla JavaScript fallback if jQuery is not available.
                var blogCards = document.querySelectorAll('.BlogCard');

                blogCards.forEach(function(card) {
                    var titleElement = card.querySelector('.elementor-heading-title a');
                    if (titleElement) {
                        var titleText = titleElement.textContent.trim();

                        if (titleText) {
                            var targetElements = card.querySelectorAll('.elementor-heading-title a, .elementor-widget-button a, .elementor-widget-theme-post-featured-image a');

                            targetElements.forEach(function(element) {
                                element.setAttribute('title', titleText);
                            });
                        }
                    }
                });
            }
        });
    </script>
    <?php
}

add_action('wp_footer', 'add_title_attributes_to_blog_card');
