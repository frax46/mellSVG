<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <header class="site-header" id="masthead">
            <div class="header-container">
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" aria-label="Toggle mobile menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
                <img class="header-logo" src="<?php echo esc_url(get_template_directory_uri() . '/images/System Images/new-logo.png'); ?>"
                    alt="<?php echo esc_attr__('Mell Luxe luxury vegan skincare', 'mellluxe'); ?>">
                <!-- Mobile Search Toggle -->
                <button class="mobile-search-toggle" aria-label="Toggle search" aria-expanded="false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <nav class="main-navigation" id="site-navigation">
                    <div class="site-branding">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            ?>
                            <div class="site-logo">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/System Images/new-logo.png'); ?>"
                                        alt="<?php echo esc_attr__('Mell Luxe luxury vegan skincare', 'mellluxe'); ?>">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="links">
                        <ul>
                            <li><a href="/">Home</a></li>
                            <?php if (class_exists('WooCommerce')): ?>
                            <li class="menu-item-has-children categories-menu">
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="categories-toggle">Shop</a>
                                <div class="categories-dropdown">
                                    <div class="categories-content">
                                        <?php
                                        $product_categories = get_terms(array(
                                            'taxonomy' => 'product_cat',
                                            'hide_empty' => true,
                                            'orderby' => 'name',
                                            'order' => 'ASC'
                                        ));
                                        
                                        if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                            echo '<div class="categories-grid">';
                                            foreach ($product_categories as $category) {
                                                // Omit specific categories from the dropdown
                                                if (isset($category->slug) && ($category->slug === 'gift-card' || $category->slug === 'uncategorized')) {
                                                    continue;
                                                }
                                                $category_link = get_term_link($category);
                                                $category_count = $category->count;
                                                echo '<div class="category-item">';
                                                echo '<a href="' . esc_url($category_link) . '" class="category-link">';
                                                echo '<span class="category-name">' . esc_html($category->name) . '</span>';
                                                echo '<span class="category-count">(' . $category_count . ')</span>';
                                                echo '</a>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        } else {
                                            echo '<div class="no-categories">No categories available</div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <?php endif; ?>
                            <li><a href="/gift-card">Gift Sets</a></li>
                            <li><a href="/botanics">Botanics</a></li>
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/blog">Blog</a></li>
                            <li>
                                
                            </li>
                        </ul>
                    </div>
                    <div class="header-tools">
                        <!-- Product Search -->
                        <div class="header-search">
                            <?php if (class_exists('WooCommerce')): ?>
                                <form role="search" method="get" class="woocommerce-product-search"
                                    action="<?php echo esc_url(home_url('/')); ?>">
                                    <input type="search" id="woocommerce-product-search-field" class="search-field"
                                        placeholder="<?php echo esc_attr__('Search products...', 'mellluxe'); ?>"
                                        value="<?php echo get_search_query(); ?>" name="s" />
                                    <input type="hidden" name="post_type" value="product" />
                                    <button type="submit" class="search-submit">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <!-- Shopping Cart -->
                        <div class="header-cart">
                            <?php if (class_exists('WooCommerce')): ?>
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-link" id="cart-toggle" aria-label="<?php echo esc_attr__('Open shopping cart', 'mellluxe'); ?>">
                                    <div class="cart-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <?php
                                        $cart_count = WC()->cart->get_cart_contents_count();
                                        ?>
                                        <span class="cart-count" id="cart-count" data-cart-count="<?php echo esc_attr($cart_count); ?>" style="<?php echo $cart_count > 0 ? '' : 'display: none;'; ?>"><?php echo esc_html($cart_count); ?></span>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="header-profile">
                            <a href="<?php echo is_user_logged_in() ? '/my-account' : '/login'; ?>" aria-label="<?php echo is_user_logged_in() ? 'My Account' : 'Login'; ?>" class="nav-login-link">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                                    <path d="M4 20c0-2.21 3.582-4 8-4s8 1.79 8 4" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Mobile Overlay -->
                <div class="mobile-menu-overlay"></div>
            </div>
        </header>

        <!-- Cart Sidebar -->
        <?php if (class_exists('WooCommerce')): ?>
            <div class="cart-sidebar" id="cart-sidebar">
                <div class="cart-sidebar-overlay" id="cart-sidebar-overlay"></div>
                <div class="cart-sidebar-content">
                    <div class="cart-sidebar-header">
                        <h3>Shopping Cart</h3>
                        <button class="cart-sidebar-close" id="cart-sidebar-close">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="cart-sidebar-body" id="cart-sidebar-body">
                        <!-- Cart content will be loaded here -->
                        <div class="cart-loading">
                            <p>Loading cart...</p>
                        </div>
                    </div>
                    <div class="cart-sidebar-footer">
                        <div class="cart-sidebar-total">
                            <span class="cart-total-label">Subtotal:</span>
                            <span class="cart-total-amount"
                                id="cart-total-amount"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                        </div>
                        <div class="cart-sidebar-actions">
                            <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-outline">View Cart</a>
                            <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-primary">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Mobile Search Modal -->
        <div class="mobile-search-modal" id="mobile-search-modal">
            <div class="mobile-search-overlay" id="mobile-search-overlay"></div>
            <div class="mobile-search-content">
                <div class="mobile-search-header">
                    <form role="search" method="get" class="mobile-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <input type="search" id="mobile-search-field" class="mobile-search-field" placeholder="Search products..." value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                            <input type="hidden" name="post_type" value="product" />
                        </div>
                        <button type="button" class="mobile-search-cancel" id="mobile-search-cancel">Cancel</button>
                    </form>
                </div>
                <div class="mobile-search-body">
                    <div class="popular-search-terms">
                        <h3>Popular Search Terms</h3>
                        <div class="search-tags">
                            <button class="search-tag" data-search="bath bombs">Bath Bombs</button>
                            <button class="search-tag" data-search="body oils">Body Oils</button>
                            <button class="search-tag" data-search="facial polish">Facial Polish</button>
                            <button class="search-tag" data-search="lip butters">Lip Butters</button>
                            <button class="search-tag" data-search="bath salts">Bath Salts</button>
                            <button class="search-tag" data-search="gift sets">Gift Sets</button>
                            <button class="search-tag" data-search="natural">Natural</button>
                            <button class="search-tag" data-search="luxury">Luxury</button>
                        </div>
                    </div>
                    <div class="search-results" id="mobile-search-results">
                        <!-- Search results will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Special Offer Modal -->
        <div class="offer-modal" id="offer-modal">
            <div class="offer-modal-overlay" id="offer-modal-overlay"></div>
            <div class="offer-modal-content">
                <button class="offer-modal-close" id="offer-modal-close" aria-label="Close modal">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="offer-modal-body">
                    <!-- <div class="offer-modal-icon">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div> -->
                    <h2 class="offer-modal-title">Are you ready to begin a ritual that restores the balance between nature and beauty?</h2>
                    <p class="offer-modal-message">Discover Mell Luxe!</p>
                    
                   
                    <a href="<?php echo esc_url(home_url('/product-category/all-products/')); ?>" class="offer-modal-button">
                        Shop Now<span>→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- <div id="content" class="site-content"> -->

        <?php
        /**
         * Fallback menu if no menu is assigned
         */
        function mellluxe_fallback_menu()
        {
            echo '<ul class="nav-menu">';
            echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'mellluxe') . '</a></li>';

            if (class_exists('WooCommerce')) {
                echo '<li class="menu-item-has-children">';
                echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . __('Shop', 'mellluxe') . '</a>';

                // Mega Menu Structure
                echo '<div class="mega-menu">';
                echo '<div class="mega-menu-content">';

                // Bath & Body Section
                echo '<div class="mega-menu-section">';
                echo '<div class="mega-menu-title">Bath & Body</div>';
                echo '<div class="mega-menu-links">';
                echo '<a href="' . esc_url(home_url('/product-category/bath-bombs/')) . '">Bath Bombs</a>';
                echo '<a href="' . esc_url(home_url('/product-category/body-oils/')) . '">Body Oils</a>';
                echo '<a href="' . esc_url(home_url('/product-category/body-scrubs/')) . '">Body Scrubs</a>';
                echo '<a href="' . esc_url(home_url('/product-category/bath-salts/')) . '">Bath Salts</a>';
                echo '<a href="' . esc_url(home_url('/product-category/shower-gels/')) . '">Shower Gels</a>';
                echo '<a href="' . esc_url(home_url('/product-category/body-butters/')) . '">Body Butters</a>';
                echo '</div>';
                echo '</div>';

                // Face Care Section
                echo '<div class="mega-menu-section">';
                echo '<div class="mega-menu-title">Face Care</div>';
                echo '<div class="mega-menu-links">';
                echo '<a href="' . esc_url(home_url('/product-category/facial-polish/')) . '">Facial Polish</a>';
                echo '<a href="' . esc_url(home_url('/product-category/face-serums/')) . '">Face Serums</a>';
                echo '<a href="' . esc_url(home_url('/product-category/face-oils/')) . '">Face Oils</a>';
                echo '<a href="' . esc_url(home_url('/product-category/cleansers/')) . '">Cleansers</a>';
                echo '<a href="' . esc_url(home_url('/product-category/moisturizers/')) . '">Moisturizers</a>';
                echo '<a href="' . esc_url(home_url('/product-category/face-masks/')) . '">Face Masks</a>';
                echo '</div>';
                echo '</div>';

                // Lip Care Section
                echo '<div class="mega-menu-section">';
                echo '<div class="mega-menu-title">Lip Care</div>';
                echo '<div class="mega-menu-links">';
                echo '<a href="' . esc_url(home_url('/product-category/lip-butters/')) . '">Lip Butters</a>';
                echo '<a href="' . esc_url(home_url('/product-category/lip-balms/')) . '">Lip Balms</a>';
                echo '<a href="' . esc_url(home_url('/product-category/lip-scrubs/')) . '">Lip Scrubs</a>';
                echo '<a href="' . esc_url(home_url('/product-category/lip-oils/')) . '">Lip Oils</a>';
                echo '</div>';
                echo '</div>';

                // Collections Section
                echo '<div class="mega-menu-section">';
                echo '<div class="mega-menu-title">Collections</div>';
                echo '<div class="mega-menu-links">';
                echo '<a href="' . esc_url(home_url('/product-category/gift-sets/')) . '">Gift Sets</a>';
                echo '<a href="' . esc_url(home_url('/product-category/travel-size/')) . '">Travel Size</a>';
                echo '<a href="' . esc_url(home_url('/product-category/seasonal/')) . '">Seasonal</a>';
                echo '<a href="' . esc_url(home_url('/product-category/limited-edition/')) . '">Limited Edition</a>';
                echo '<a href="' . esc_url(home_url('/product-category/best-sellers/')) . '">Best Sellers</a>';
                echo '</div>';
                echo '</div>';

                // Featured Section
                echo '<div class="mega-menu-featured">';
                echo '<div class="mega-menu-featured-title">Featured Products</div>';
                echo '<div class="mega-menu-featured-grid">';

                echo '<div class="mega-menu-featured-item">';
                echo '<img src="' . get_template_directory_uri() . '/images/Singles/Bath Bombs/bath-bomb-1.jpg" alt="Bath Bombs">';
                echo '<h4>NEW Bath Bombs</h4>';
                echo '<p>Luxurious aromatherapy</p>';
                echo '</div>';

                echo '<div class="mega-menu-featured-item">';
                echo '<img src="' . get_template_directory_uri() . '/images/Singles/Polish/polish-1.jpg" alt="Facial Polish">';
                echo '<h4>Facial Polish</h4>';
                echo '<p>Gentle exfoliation</p>';
                echo '</div>';

                echo '<div class="mega-menu-featured-item">';
                echo '<img src="' . get_template_directory_uri() . '/images/Singles/Lip Butters/lip-butter-1.jpg" alt="Lip Butters">';
                echo '<h4>Lip Butters</h4>';
                echo '<p>Nourishing care</p>';
                echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo '</div>';
                echo '</li>';

                // Gift Card page
                $gift_card_page = get_page_by_title('Gift Card');
                if ($gift_card_page) {
                    echo '<li><a href="' . esc_url(get_permalink($gift_card_page->ID)) . '">' . __('Gift Card', 'mellluxe') . '</a></li>';
                }
            }

            // About Us page
            $about_page = get_page_by_title('About Us');
            if ($about_page) {
                echo '<li><a href="' . esc_url(get_permalink($about_page->ID)) . '">' . __('About Us', 'mellluxe') . '</a></li>';
            }

            // Blog page
            if (get_option('page_for_posts')) {
                echo '<li><a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . __('Blog', 'mellluxe') . '</a></li>';
            } else {
                echo '<li><a href="' . esc_url(home_url('/blog')) . '">' . __('Blog', 'mellluxe') . '</a></li>';
            }

            echo '</ul>';
        }
        ?>
