<?php
/**
 * The template for displaying the checkout page.
 *
 * This template uses a custom layout based on the design system,
 * replacing the default [woocommerce_checkout] shortcode for a more
 * integrated and styled experience.
 *
 * @package Mellluxe
 */

get_header(); ?>

<div id="primary" class="content-area checkout-page-container">
    <main id="main" class="site-main" role="main">

        <div class="checkout-layout-grid">
            <div class="checkout-main-column">
                <h1 class="checkout-title"><?php esc_html_e( 'Checkout', 'mellluxe' ); ?></h1>
                <p class="checkout-desc"><?php esc_html_e( 'Complete your order below. All fields are required unless marked optional.', 'mellluxe' ); ?></p>

                <div class="checkout-form-wrapper">
                    <?php
                    if ( class_exists( 'WooCommerce' ) ) {
                        // Hook for payment buttons before checkout form (Google Pay, Apple Pay, etc.)
                        do_action( 'woocommerce_checkout_before_customer_details' );
                        do_action( 'woocommerce_checkout_before_order_review' );
                        
                        // Display express checkout buttons before the checkout form
                        do_action( 'woocommerce_review_order_before_payment' );
                        
                        echo do_shortcode('[woocommerce_checkout]');
                        
                        // Hook for payment buttons after checkout form
                        do_action( 'woocommerce_checkout_after_order_review' );
                    } else {
                        echo '<p style="color:red;">WooCommerce is not active. Please activate WooCommerce to use the checkout page.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?> 