<?php
/**
 * Mell Luxe Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function mellluxe_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mellluxe'),
        'footer' => __('Footer Menu', 'mellluxe'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
    
    // Favicon support is handled separately to avoid conflicts
}
add_action('after_setup_theme', 'mellluxe_setup');

/**
 * Enqueue scripts and styles
 */
function mellluxe_scripts() {
    // Theme stylesheet
    wp_enqueue_style('mellluxe-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Google Fonts
    wp_enqueue_style('mellluxe-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap', array(), null);
    
    // GSAP CDN
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array('gsap'), '3.12.2', true);
    
    // Theme JavaScript
    wp_enqueue_script('mellluxe-script', get_template_directory_uri() . '/js/theme.js', array('gsap', 'gsap-scrolltrigger'), '1.0.0', true);
    
    // Offer Modal JavaScript
    wp_enqueue_script('mellluxe-offer-modal', get_template_directory_uri() . '/js/offer-modal.js', array(), filemtime(get_template_directory() . '/js/offer-modal.js'), true);
    
    // Localize script for AJAX
    wp_localize_script('mellluxe-script', 'mellluxe_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mellluxe_nonce')
    ));
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mellluxe_scripts');

/**
 * Register widget area
 */
function mellluxe_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'mellluxe'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'mellluxe'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'mellluxe'),
        'id'            => 'footer-widgets',
        'description'   => __('Add widgets here to appear in the footer.', 'mellluxe'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'mellluxe_widgets_init');

/**
 * Custom logo setup
 */
function mellluxe_custom_logo_setup() {
    $defaults = array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'mellluxe_custom_logo_setup');

/**
 * Customize excerpt length
 */
function mellluxe_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mellluxe_excerpt_length');

/**
 * Customize excerpt more
 */
function mellluxe_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mellluxe_excerpt_more');

/**
 * WooCommerce customizations
 */
if (class_exists('WooCommerce')) {
    
    // Remove WooCommerce default styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Modify WooCommerce product loop
    function mellluxe_woocommerce_output_product_data_tabs() {
        wc_get_template('single-product/tabs/tabs.php');
    }
    
    // Custom WooCommerce cart link
    function mellluxe_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'mellluxe'); ?>">
            <span class="cart-icon">🛒</span>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
        <?php
    }
    
    // Update cart count via AJAX - Enhanced for cross-browser compatibility
    function mellluxe_add_to_cart_fragment($fragments) {
        ob_start();
        mellluxe_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();
        
        // Update cart count badge ONLY - don't replace the entire cart icon
        $cart_count = WC()->cart->get_cart_contents_count();
        ob_start();
        ?>
        <span class="cart-count" id="cart-count" style="<?php echo $cart_count > 0 ? '' : 'display: none;'; ?>"><?php echo esc_html($cart_count); ?></span>
        <?php
        $cart_count_html = ob_get_clean();
        
        // Add fragment ONLY for the cart count badge element (not the parent container)
        $fragments['#cart-count'] = $cart_count_html;
        
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'mellluxe_add_to_cart_fragment');
    
    // Also update on cart item removal
    add_filter('woocommerce_cart_item_removed', 'mellluxe_update_cart_fragments_on_remove', 10, 2);
    function mellluxe_update_cart_fragments_on_remove($cart_item_key, $cart) {
        // Trigger fragment refresh
        WC()->cart->calculate_totals();
    }
    
    // Customize WooCommerce columns
    function mellluxe_loop_columns() {
        return 5;
    }
    add_filter('loop_shop_columns', 'mellluxe_loop_columns');
    
    // Customize products per page
    function mellluxe_products_per_page() {
        return 12;
    }
    add_filter('loop_shop_per_page', 'mellluxe_products_per_page');
    
    // Override WooCommerce My Account template
    function mellluxe_override_my_account_template($template) {
        if (is_account_page()) {
            $custom_template = get_template_directory() . '/woocommerce/myaccount/my-account.php';
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
        return $template;
    }
    add_filter('template_include', 'mellluxe_override_my_account_template');
    
    // Prioritize in-stock products over out-of-stock products on catalog views
    function mellluxe_prioritize_in_stock_products($query) {
        if (is_admin()) return;
        if (!$query->is_main_query()) return;
        if (!(is_shop() || is_product_taxonomy())) return;

        // Ensure we're operating on product archives
        if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] !== 'product') return;

        // Join stock status and order by it while preserving the existing Woo orderby
        add_filter('posts_join', function($join, $q) {
            global $wpdb;
            if (!$q->is_main_query()) return $join;
            // Use a unique alias to avoid collisions with other joins
            if (strpos($join, 'stock_status_meta') === false) {
                $join .= " LEFT JOIN {$wpdb->postmeta} stock_status_meta ON ({$wpdb->posts}.ID = stock_status_meta.post_id AND stock_status_meta.meta_key = '_stock_status')";
            }
            return $join;
        }, 10, 2);

        add_filter('posts_orderby', function($orderby, $q) {
            if (!$q->is_main_query()) return $orderby;
            // Push instock first, then onbackorder, then outofstock
            $stockCase = "CASE 
                WHEN stock_status_meta.meta_value = 'instock' THEN 0 
                WHEN stock_status_meta.meta_value = 'onbackorder' THEN 1 
                WHEN stock_status_meta.meta_value = 'outofstock' THEN 2 
                ELSE 3 
            END ASC";
            // Prepend our CASE so WooCommerce's existing ordering remains after
            if (!empty($orderby)) {
                return $stockCase . ", " . $orderby;
            }
            return $stockCase;
        }, 10, 2);
    }
    add_action('pre_get_posts', 'mellluxe_prioritize_in_stock_products');
}

/**
 * AJAX handlers
 */
function mellluxe_load_more_products() {
    check_ajax_referer('mellluxe_nonce', 'nonce');
    
    $page = intval($_POST['page']);
    $posts_per_page = intval($_POST['posts_per_page']);
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'post_status' => 'publish'
    );
    
    $products = new WP_Query($args);
    
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }
    }
    
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_products', 'mellluxe_load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'mellluxe_load_more_products');

/**
 * Contact form handler
 */
function mellluxe_contact_form_handler() {
    check_ajax_referer('mellluxe_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);
    
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error('Please fill all fields.');
    }
    
    if (!is_email($email)) {
        wp_send_json_error('Please enter a valid email address.');
    }
    
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission - ' . get_bloginfo('name');
    $body = "Name: {$name}\nEmail: {$email}\nMessage: {$message}";
    $headers = array('Content-Type: text/plain; charset=UTF-8', "From: {$email}");
    
    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success('Thank you for your message! We will get back to you soon.');
    } else {
        wp_send_json_error('Sorry, there was an error sending your message. Please try again.');
    }
}
add_action('wp_ajax_contact_form', 'mellluxe_contact_form_handler');
add_action('wp_ajax_nopriv_contact_form', 'mellluxe_contact_form_handler');

/**
 * Add custom body classes
 */
function mellluxe_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page-template';
    }
    
    if (class_exists('WooCommerce') && is_woocommerce()) {
        $classes[] = 'woocommerce-page';
    }
    
    return $classes;
}
add_filter('body_class', 'mellluxe_body_classes');

/**
 * Customizer settings
 */
function mellluxe_customize_register($wp_customize) {
    // Hero section
    $wp_customize->add_section('mellluxe_hero', array(
        'title' => __('Hero Section', 'mellluxe'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default' => 'At Mell Luxe...',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'mellluxe'),
        'section' => 'mellluxe_hero',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_description', array(
        'default' => '... nature meets luxury in every handcrafted product.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label' => __('Hero Description', 'mellluxe'),
        'section' => 'mellluxe_hero',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label' => __('Hero Image', 'mellluxe'),
        'section' => 'mellluxe_hero',
    )));
    
    // Contact section
    $wp_customize->add_section('mellluxe_contact', array(
        'title' => __('Contact Information', 'mellluxe'),
        'priority' => 35,
    ));
    
    $wp_customize->add_setting('contact_email', array(
        'default' => 'mellluxe.info@gmail.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label' => __('Contact Email', 'mellluxe'),
        'section' => 'mellluxe_contact',
        'type' => 'email',
    ));

    // Favicon section
    $wp_customize->add_section('mellluxe_favicon', array(
        'title' => __('Favicon', 'mellluxe'),
        'priority' => 30,
    ));
    
    // Favicon setting
    $wp_customize->add_setting('mellluxe_favicon', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    // Favicon control
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mellluxe_favicon', array(
        'label' => __('Upload Favicon', 'mellluxe'),
        'section' => 'mellluxe_favicon',
        'settings' => 'mellluxe_favicon',
    )));
}
add_action('customize_register', 'mellluxe_customize_register');

/**
 * Add theme options page
 */
function mellluxe_add_admin_page() {
    add_theme_page(
        'Mell Luxe Theme Options',
        'Theme Options',
        'manage_options',
        'mellluxe-options',
        'mellluxe_admin_page'
    );
}
add_action('admin_menu', 'mellluxe_add_admin_page');

function mellluxe_admin_page() {
    ?>
    <div class="wrap">
        <h1>Mell Luxe Theme Options</h1>
        <p>Welcome to the Mell Luxe theme! This theme includes GSAP animations, scroll snapping, and full WooCommerce integration.</p>
        <h2>Features:</h2>
        <ul>
            <li>✅ GSAP ScrollTrigger animations</li>
            <li>✅ Snap-to-section scrolling</li>
            <li>✅ Responsive design</li>
            <li>✅ WooCommerce ready</li>
            <li>✅ Contact form with AJAX</li>
            <li>✅ Customizer integration</li>
        </ul>
        <p>Customize your site using the <a href="<?php echo admin_url('customize.php'); ?>">WordPress Customizer</a>.</p>
    </div>
    <?php
}

/**
 * Security enhancements
 */
function mellluxe_remove_version() {
    return '';
}
add_filter('the_generator', 'mellluxe_remove_version');

// Remove WordPress version from scripts and styles
function mellluxe_remove_wp_version_strings($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'mellluxe_remove_wp_version_strings', 15, 1);
add_filter('style_loader_src', 'mellluxe_remove_wp_version_strings', 15, 1);

/**
 * Cart AJAX handlers
 */
// Get cart contents for sidebar
function mellluxe_get_cart_contents() {
    // Enhanced nonce verification with fallback for live sites
    $nonce_verified = false;
    if (isset($_POST['nonce'])) {
        $nonce_verified = wp_verify_nonce($_POST['nonce'], 'mellluxe_nonce');
    }
    
    // For better compatibility on live sites, allow request if referer is valid
    if (!$nonce_verified) {
        if (!isset($_SERVER['HTTP_REFERER']) || 
            strpos($_SERVER['HTTP_REFERER'], home_url()) === false) {
            wp_send_json_error('Invalid request');
            return;
        }
    }
    
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }
    
    $cart = WC()->cart;
    $cart_items = $cart->get_cart();
    
    if (empty($cart_items)) {
        wp_send_json_success([
            'html' => '<div class="cart-empty">
                        <div class="cart-empty-icon">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h4>Your cart is empty</h4>
                        <p>Add some products to get started!</p>
                       </div>',
            'total' => wc_price(0),
            'cart_count' => 0
        ]);
        return;
    }
    
    $html = '';
    foreach ($cart_items as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        
        $product_name = $product->get_name();
        $product_price = WC()->cart->get_product_price($product);
        $product_permalink = $product->get_permalink($cart_item);
        $thumbnail = $product->get_image('thumbnail');
        
        $html .= '<div class="cart-item">';
        $html .= '<div class="cart-item-image">';
        $html .= '<a href="' . esc_url($product_permalink) . '">' . $thumbnail . '</a>';
        $html .= '</div>';
        $html .= '<div class="cart-item-details">';
        $html .= '<h4 class="cart-item-name"><a href="' . esc_url($product_permalink) . '">' . esc_html($product_name) . '</a></h4>';
        $html .= '<div class="cart-item-price">' . $product_price . '</div>';
        $html .= '<div class="cart-item-quantity">Qty: ' . $quantity . '</div>';
        $html .= '<div class="quantity-controls">';
        $html .= '<button class="quantity-btn" data-cart-key="' . $cart_item_key . '" data-action="decrease">-</button>';
        $html .= '<input type="number" class="quantity-input" value="' . $quantity . '" min="1" readonly>';
        $html .= '<button class="quantity-btn" data-cart-key="' . $cart_item_key . '" data-action="increase">+</button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<button class="cart-item-remove" data-cart-key="' . $cart_item_key . '">';
        $html .= '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $html .= '<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $html .= '</svg>';
        $html .= '</button>';
        $html .= '</div>';
    }
    
    wp_send_json_success([
        'html' => $html,
        'total' => $cart->get_cart_subtotal(),
        'cart_count' => $cart->get_cart_contents_count()
    ]);
}
add_action('wp_ajax_get_cart_contents', 'mellluxe_get_cart_contents');
add_action('wp_ajax_nopriv_get_cart_contents', 'mellluxe_get_cart_contents');

// Remove cart item
function mellluxe_remove_cart_item() {
    check_ajax_referer('mellluxe_nonce', 'nonce');
    
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }
    
    $cart_key = sanitize_text_field($_POST['cart_key']);
    
    if (WC()->cart->remove_cart_item($cart_key)) {
        wp_send_json_success([
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'total' => WC()->cart->get_cart_subtotal()
        ]);
    } else {
        wp_send_json_error('Failed to remove item');
    }
}
add_action('wp_ajax_remove_cart_item', 'mellluxe_remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'mellluxe_remove_cart_item');

// Update cart item quantity
function mellluxe_update_cart_item_quantity() {
    check_ajax_referer('mellluxe_nonce', 'nonce');
    
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }
    
    $cart_key = sanitize_text_field($_POST['cart_key']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity <= 0) {
        wp_send_json_error('Invalid quantity');
        return;
    }
    
    if (WC()->cart->set_quantity($cart_key, $quantity)) {
        wp_send_json_success([
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'total' => WC()->cart->get_cart_subtotal()
        ]);
    } else {
        wp_send_json_error('Failed to update quantity');
    }
}
add_action('wp_ajax_update_cart_item_quantity', 'mellluxe_update_cart_item_quantity');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'mellluxe_update_cart_item_quantity');

// Get cart count - Enhanced for Mac/Safari compatibility and security
function mellluxe_get_cart_count() {
    // For Mac/Safari, we need to ensure the cart is properly loaded
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }
    
    // Verify nonce with better error handling for live sites
    $nonce_verified = false;
    if (isset($_POST['nonce'])) {
        $nonce_verified = wp_verify_nonce($_POST['nonce'], 'mellluxe_nonce');
    }
    
    // For logged-out users or if nonce fails, try alternative verification
    if (!$nonce_verified) {
        // Check if it's a valid request (not a bot)
        if (!isset($_SERVER['HTTP_REFERER']) || 
            strpos($_SERVER['HTTP_REFERER'], home_url()) === false) {
            // Still allow for better UX, but log it
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('Cart count request without valid nonce or referer');
            }
        }
    }
    
    // Ensure cart is initialized (important for Safari/Mac)
    if (!WC()->cart) {
        wc_load_cart();
    }
    
    // Force cart calculation to ensure accurate count
    WC()->cart->calculate_totals();
    
    $cart_count = WC()->cart->get_cart_contents_count();
    
    // Return additional data for debugging on Mac
    wp_send_json_success([
        'cart_count' => $cart_count,
        'cart_hash' => WC()->cart->get_cart_hash(),
        'is_empty' => WC()->cart->is_empty()
    ]);
}
add_action('wp_ajax_get_cart_count', 'mellluxe_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'mellluxe_get_cart_count'); 

/**
 * AJAX Product Search Handler
 */
function mellluxe_search_products() {
    check_ajax_referer('mellluxe_nonce', 'nonce');
    
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }
    
    $query = sanitize_text_field($_POST['query']);
    
    if (empty($query) || strlen($query) < 2) {
        wp_send_json_error('Query too short');
        return;
    }
    
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        's' => $query,
        'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock',
                'compare' => '='
            )
        )
    );
    
    $products = new WP_Query($args);
    $results = array();
    
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());
            
            $results[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'url' => $product->get_permalink(),
                'price' => $product->get_price_html(),
                'image' => wp_get_attachment_image_url($product->get_image_id(), 'thumbnail') ?: wc_placeholder_img_src('thumbnail'),
                'short_description' => wp_trim_words($product->get_short_description(), 10, '...')
            );
        }
    }
    
    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_mellluxe_search_products', 'mellluxe_search_products');
add_action('wp_ajax_nopriv_mellluxe_search_products', 'mellluxe_search_products');

/**
 * Reading Time Shortcode
 */
function mellluxe_reading_time_shortcode() {
    global $post;
    if (empty($post)) return '';
    $content = $post->post_content;
    $word_count = str_word_count(strip_tags($content));
    $words_per_minute = 200; // Average reading speed
    $minutes = ceil($word_count / $words_per_minute);
    if ($minutes < 1) $minutes = 1;
    return $minutes;
}
add_shortcode('reading_time', 'mellluxe_reading_time_shortcode'); 



/**
 * Cookie Consent Functions
 */
function mellluxe_cookie_consent() {
	// Only load banner and script if no prior consent choice
	if (!isset($_COOKIE['mellluxe_cookie_consent'])) {
		add_action('wp_footer', 'mellluxe_cookie_banner_html');
		add_action('wp_enqueue_scripts', 'mellluxe_cookie_consent_scripts');
	}
}
add_action('init', 'mellluxe_cookie_consent');

/**
 * Enqueue cookie consent scripts
 */
function mellluxe_cookie_consent_scripts() {
	// Use ad-block safe filename
	wp_enqueue_script('mellluxe-site-prefs', get_template_directory_uri() . '/js/site-prefs.js', array(), '1.0.0', true);
	wp_localize_script('mellluxe-site-prefs', 'mellluxe_cookie_ajax', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('mellluxe_cookie_nonce')
	));
}

/**
 * Cookie banner HTML
 */
function mellluxe_cookie_banner_html() {
	?>
	<div id="cookie-consent-banner" class="cookie-consent-banner" style="display: none;">
		<div class="cookie-consent-content">
			<div class="cookie-consent-text">
				<h3>🍪 We use cookies</h3>
				<p>We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.</p>
				<div class="cookie-consent-links">
					<a href="/terms-and-privacy/" target="_blank">Privacy Policy</a>
					<!-- <a href="/cookie-policy" target="_blank">Cookie Policy</a> -->
				</div>
			</div>
			<div class="cookie-consent-buttons">
				<button type="button" class="cookie-consent-btn cookie-consent-reject" data-action="reject">
					Reject All
				</button>
				<button type="button" class="cookie-consent-btn cookie-consent-accept" data-action="accept">
					Accept All
				</button>
			</div>
		</div>
	</div>
	<?php
}

/**
 * AJAX handler for cookie consent
 */
function mellluxe_handle_cookie_consent() {
	// Verify nonce
	if (!wp_verify_nonce($_POST['nonce'], 'mellluxe_cookie_nonce')) {
		wp_die('Security check failed');
	}
	
	$consent_action = sanitize_text_field($_POST['consent_action']);
	$expiry = 365 * 24 * 60 * 60; // 1 year
	
	if ($consent_action === 'accept') {
		setcookie('mellluxe_cookie_consent', 'accepted', time() + $expiry, '/', '', is_ssl(), true);
		setcookie('mellluxe_analytics_cookies', 'enabled', time() + $expiry, '/', '', is_ssl(), true);
		setcookie('mellluxe_marketing_cookies', 'enabled', time() + $expiry, '/', '', is_ssl(), true);
	} elseif ($consent_action === 'reject') {
		setcookie('mellluxe_cookie_consent', 'rejected', time() + $expiry, '/', '', is_ssl(), true);
		setcookie('mellluxe_analytics_cookies', 'disabled', time() + $expiry, '/', '', is_ssl(), true);
		setcookie('mellluxe_marketing_cookies', 'disabled', time() + $expiry, '/', '', is_ssl(), true);
	}
	
	wp_send_json_success(array('message' => 'Cookie preference saved'));
}
add_action('wp_ajax_mellluxe_cookie_consent', 'mellluxe_handle_cookie_consent');
add_action('wp_ajax_nopriv_mellluxe_cookie_consent', 'mellluxe_handle_cookie_consent');

/**
 * Check if analytics cookies are enabled
 */
function mellluxe_analytics_cookies_enabled() {
    return isset($_COOKIE['mellluxe_analytics_cookies']) && $_COOKIE['mellluxe_analytics_cookies'] === 'enabled';
}

/**
 * Check if marketing cookies are enabled
 */
function mellluxe_marketing_cookies_enabled() {
    return isset($_COOKIE['mellluxe_marketing_cookies']) && $_COOKIE['mellluxe_marketing_cookies'] === 'enabled';
} 

/**
 * SEO helpers and structured data.
 */
function mellluxe_seo_site_name() {
    return 'Mell Luxe';
}

function mellluxe_seo_default_description() {
    return 'Discover Mell Luxe luxury vegan skincare, bath and body care, botanicals, facial oils and self-care gifts handcrafted with natural ingredients in the UK.';
}

function mellluxe_seo_page_description() {
    if (is_front_page() || is_home()) {
        return mellluxe_seo_default_description();
    }

    if (function_exists('is_shop') && is_shop()) {
        return 'Shop Mell Luxe luxury vegan skincare, botanical bath and body products, facial oils, bath salts and self-care gift sets.';
    }

    if (function_exists('is_product') && is_product()) {
        global $post;
        $excerpt = $post ? ($post->post_excerpt ?: $post->post_content) : '';
        return wp_trim_words(wp_strip_all_tags($excerpt), 28, '');
    }

    if (is_page('gift-card')) {
        return 'Explore Mell Luxe gift sets and thoughtful self-care presents for luxury vegan skincare, bath rituals and botanical beauty lovers.';
    }

    if (is_page('botanics')) {
        return 'Learn about the natural botanicals, vegan ingredients and plant-powered care behind Mell Luxe skincare and wellness rituals.';
    }

    if (is_page('about')) {
        return 'Meet Mell Luxe, a UK luxury vegan beauty brand creating natural skincare, bath and body products with sustainable care.';
    }

    if (is_page('blog') || is_archive()) {
        return 'Read Mell Luxe skincare tips, botanical beauty guidance and wellness rituals for natural vegan self-care.';
    }

    if (is_singular()) {
        global $post;
        $source = has_excerpt($post) ? get_the_excerpt($post) : get_post_field('post_content', $post);
        return wp_trim_words(wp_strip_all_tags($source), 28, '');
    }

    return mellluxe_seo_default_description();
}

function mellluxe_get_current_product() {
    if (!function_exists('is_product') || !is_product() || !function_exists('wc_get_product')) {
        return null;
    }

    global $product;

    if ($product instanceof WC_Product) {
        return $product;
    }

    $product_id = get_queried_object_id();
    if (!$product_id) {
        $product_id = get_the_ID();
    }

    $current_product = $product_id ? wc_get_product($product_id) : null;

    return $current_product instanceof WC_Product ? $current_product : null;
}

function mellluxe_seo_image_url() {
    if (is_singular() && has_post_thumbnail()) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
        if (!empty($image[0])) {
            return $image[0];
        }
    }

    if (function_exists('is_product') && is_product()) {
        $product = mellluxe_get_current_product();
        if ($product && $product->get_image_id()) {
            $image = wp_get_attachment_image_src($product->get_image_id(), 'large');
            if (!empty($image[0])) {
                return $image[0];
            }
        }
    }

    return get_template_directory_uri() . '/images/System Images/new-logo.png';
}

function mellluxe_seo_canonical_url() {
    if (function_exists('is_shop') && is_shop()) {
        return wc_get_page_permalink('shop');
    }

    if (is_singular()) {
        return get_permalink();
    }

    if (is_front_page() || is_home()) {
        return home_url('/');
    }

    if (is_tax() || is_category() || is_tag()) {
        $term_link = get_term_link(get_queried_object());
        return is_wp_error($term_link) ? home_url('/') : $term_link;
    }

    return home_url(add_query_arg(array(), $GLOBALS['wp']->request ?? ''));
}

function mellluxe_document_title_parts($title) {
    $site = mellluxe_seo_site_name();

    if (is_front_page() || is_home()) {
        $title['title'] = 'Luxury Vegan Skincare, Botanicals & Self-Care Gifts';
        $title['site'] = $site;
        return $title;
    }

    if (function_exists('is_shop') && is_shop()) {
        $title['title'] = 'Shop Luxury Vegan Skincare & Bath Rituals';
        $title['site'] = $site;
        return $title;
    }

    $title['site'] = $site;
    return $title;
}
add_filter('document_title_parts', 'mellluxe_document_title_parts');

function mellluxe_output_seo_meta() {
    if (is_admin()) {
        return;
    }

    $site_name = mellluxe_seo_site_name();
    $title = wp_get_document_title();
    $description = mellluxe_seo_page_description();
    $canonical = mellluxe_seo_canonical_url();
    $image = mellluxe_seo_image_url();
    $type = is_singular('post') ? 'article' : 'website';
    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>">
    <link rel="canonical" href="<?php echo esc_url($canonical); ?>">
    <meta property="og:locale" content="<?php echo esc_attr(str_replace('-', '_', get_bloginfo('language'))); ?>">
    <meta property="og:type" content="<?php echo esc_attr($type); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($description); ?>">
    <meta property="og:url" content="<?php echo esc_url($canonical); ?>">
    <meta property="og:image" content="<?php echo esc_url($image); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <?php
}
add_action('wp_head', 'mellluxe_output_seo_meta', 5);

function mellluxe_output_structured_data() {
    if (is_admin()) {
        return;
    }

    $site_name = mellluxe_seo_site_name();
    $home = home_url('/');
    $logo = get_template_directory_uri() . '/images/System Images/new-logo.png';
    $schema = array(
        array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => trailingslashit($home) . '#organization',
            'name' => $site_name,
            'url' => $home,
            'logo' => $logo,
            'description' => mellluxe_seo_default_description(),
            'sameAs' => array(
                'https://www.instagram.com/mell_luxe/',
                'https://facebook.com/61563792317066',
                'https://www.tiktok.com/@mell.luxe',
                'https://mellluxe.etsy.com'
            )
        ),
        array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => trailingslashit($home) . '#website',
            'name' => $site_name,
            'url' => $home,
            'publisher' => array('@id' => trailingslashit($home) . '#organization'),
            'potentialAction' => array(
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}&post_type=product'),
                'query-input' => 'required name=search_term_string'
            )
        )
    );

    if (!is_front_page()) {
        $items = array(
            array(
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $home
            ),
            array(
                '@type' => 'ListItem',
                'position' => 2,
                'name' => wp_strip_all_tags(get_the_title() ?: wp_get_document_title()),
                'item' => mellluxe_seo_canonical_url()
            )
        );

        $schema[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        );
    }

    if (function_exists('is_product') && is_product()) {
        $product = mellluxe_get_current_product();
        if ($product) {
            $product_schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->get_name(),
                'description' => mellluxe_seo_page_description(),
                'image' => mellluxe_seo_image_url(),
                'sku' => $product->get_sku() ?: $product->get_id(),
                'brand' => array(
                    '@type' => 'Brand',
                    'name' => $site_name
                )
            );

            if ($product->get_price() !== '') {
                $product_schema['offers'] = array(
                    '@type' => 'Offer',
                    'url' => get_permalink($product->get_id()),
                    'priceCurrency' => get_woocommerce_currency(),
                    'price' => $product->get_price(),
                    'availability' => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                    'itemCondition' => 'https://schema.org/NewCondition'
                );
            }

            $schema[] = $product_schema;
        }
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'mellluxe_output_structured_data', 20);

function mellluxe_robots_directives($robots) {
    $robots['max-image-preview'] = 'large';
    $robots['max-snippet'] = -1;
    $robots['max-video-preview'] = -1;

    if (is_search()) {
        $robots['noindex'] = true;
    }

    return $robots;
}
add_filter('wp_robots', 'mellluxe_robots_directives');

/**
 * Output favicon in head - improved version with Edge support
 */
function mellluxe_favicon_output() {
    // Get the favicon from WordPress customizer
    $favicon = get_theme_mod('mellluxe_favicon');
    
    if ($favicon) {
        $favicon_id = attachment_url_to_postid($favicon);
        $cache_buster = $favicon_id ? '?v=' . get_post_modified_time('U', true, $favicon_id) : '';

        // Output the custom favicon from WordPress settings with multiple formats for Edge
        echo '<link rel="icon" type="image/x-icon" href="' . esc_url($favicon) . $cache_buster . '">' . "\n";
        echo '<link rel="icon" type="image/png" href="' . esc_url($favicon) . $cache_buster . '">' . "\n";
        
        // Edge-specific favicon tags
        echo '<link rel="shortcut icon" href="' . esc_url($favicon) . $cache_buster . '">' . "\n";
        echo '<link rel="icon" href="' . esc_url($favicon) . $cache_buster . '">' . "\n";
        
        // Add Apple touch icon if it's a PNG
        $file_extension = pathinfo($favicon, PATHINFO_EXTENSION);
        if ($file_extension === 'png') {
            echo '<link rel="apple-touch-icon" href="' . esc_url($favicon) . $cache_buster . '">' . "\n";
        }
        
    } else {
        // Fallback to default favicon if none is set
        $default_favicon = get_template_directory_uri() . '/images/favicon.ico';
        $default_favicon_path = get_template_directory() . '/images/favicon.ico';
        $cache_buster = file_exists($default_favicon_path) ? '?v=' . filemtime($default_favicon_path) : '';
        echo '<link rel="icon" type="image/x-icon" href="' . esc_url($default_favicon) . $cache_buster . '">' . "\n";
        echo '<link rel="shortcut icon" href="' . esc_url($default_favicon) . $cache_buster . '">' . "\n";
    }
}
add_action('wp_head', 'mellluxe_favicon_output'); 
