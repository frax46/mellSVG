<?php
/**
 * The template for displaying the cart page.
 *
 * This template uses a custom layout based on the design system,
 * replacing the default [woocommerce_cart] shortcode for a more
 * integrated and styled experience.
 *
 * @package Mellluxe
 */

get_header(); ?>

<div id="primary" class="content-area cart-page-container">
    <main id="main" class="site-main" role="main">

        <?php if ( ! WC()->cart->is_empty() ) : ?>

            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                
                <div class="cart-layout-grid">

                    <!-- Left Column: Cart Items -->
                    <div class="cart-items-column">
                    <h1 class="cart-title"><?php esc_html_e( 'Shopping Bag', 'mellluxe' ); ?></h1>
                    <p class="cart-count-info">
                        <?php
                        /* translators: %d: number of items in cart */
                        echo sprintf( esc_html__( 'You have %d items in your bag.', 'mellluxe' ), esc_html( WC()->cart->get_cart_contents_count() ) );
                        ?>
                    </p>

                    <div class="cart-items-list">
                        <div class="cart-header">
                            <span class="header-product"><?php esc_html_e( 'Product', 'mellluxe' ); ?></span>
                            <span class="header-price"><?php esc_html_e( 'Price', 'mellluxe' ); ?></span>
                            <span class="header-quantity"><?php esc_html_e( 'Quantity', 'mellluxe' ); ?></span>
                            <span class="header-total"><?php esc_html_e( 'Total Price', 'mellluxe' ); ?></span>
                        </div>

                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                ?>
                                <div class="cart-item-card" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>">
                                    <div class="product-info">
                                        <div class="product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                            if ( ! $product_permalink ) {
                                                echo $thumbnail;
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                            }
                                            ?>
                                        </div>
                                        <div class="product-details">
                                            <span class="product-category"><?php echo wc_get_product_category_list( $product_id ); ?></span>
                                            <h3 class="product-name">
                                                <?php
                                                if ( ! $product_permalink ) {
                                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                                } else {
                                                    echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) );
                                                }
                                                // Meta data
                                                echo wc_get_formatted_cart_item_data( $cart_item );
                                                ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                    </div>
                                    <div class="product-quantity">
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            echo '1 <input type="hidden" name="cart[' . $cart_item_key . '][qty]" value="1" />';
                                        } else {
                                            $max_value = $_product->get_max_purchase_quantity();
                                            $min_value = 0;
                                            $current_qty = $cart_item['quantity'];
                                            ?>
                                            <div class="quantity">
                                                <button type="button" class="qty-btn minus" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>" <?php echo ($current_qty <= 1) ? 'disabled' : ''; ?>>-</button>
                                                <input type="number" 
                                                       name="cart[<?php echo $cart_item_key; ?>][qty]" 
                                                       value="<?php echo esc_attr( $current_qty ); ?>" 
                                                       min="1" 
                                                       <?php if ( $max_value > 0 ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?>
                                                       step="1" 
                                                       class="qty" 
                                                       data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>" />
                                                <button type="button" class="qty-btn plus" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>" <?php echo ($max_value > 0 && $current_qty >= $max_value) ? 'disabled' : ''; ?>>+</button>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                         <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove-item" title="<?php esc_attr_e( 'Remove this item', 'mellluxe' ); ?>">&times;</a>
                                    </div>
                                    <div class="product-total">
                                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>


                </div>

                <!-- Right Column: Cart Summary -->
                <div class="cart-summary-column">
                    <div class="summary-card">
                        <?php if ( wc_coupons_enabled() ) { ?>
                            <div class="coupon-code-section">
                                <h2><?php esc_html_e( 'Coupon Code', 'mellluxe' ); ?></h2>
                                <p><?php esc_html_e( 'Enter your coupon code if you have one.', 'mellluxe' ); ?></p>
                                <form class="woocommerce-coupon-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                                    <div class="coupon">
                                        <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
                                        <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply', 'mellluxe' ); ?></button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>

                        <div class="cart-total-section">
                            <h2><?php esc_html_e( 'Cart Total', 'mellluxe' ); ?></h2>
                            
                            <?php 
                            // Display cart totals table
                            woocommerce_cart_totals(); 
                            ?>
                            
                            <div class="shipping-info">
                                <p><?php esc_html_e( 'Includes £2.99 for standard shipping. (You can choose a different delivery method at checkout.)', 'mellluxe' ); ?></p>
                            </div>
                            
                            <?php
                            // Use the standard WooCommerce proceed to checkout wrapper
                            // This is where payment buttons (Google Pay, Apple Pay) are typically displayed
                            ?>
                            <div class="wc-proceed-to-checkout">
                                <?php
                                // This hook is critical for payment buttons - payment gateways hook into this
                                do_action( 'woocommerce_proceed_to_checkout' );
                                ?>
                                
                                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
                                    <?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
                                </a>
                            </div>
                            
                            <?php
                            // Additional hook for payment buttons after cart totals
                            do_action( 'woocommerce_after_cart_totals' );
                            ?>
                        </div>
                        <button type="submit" class="button update-cart-button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" disabled><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                    </div>
                </div>

            </div>
            </form>

        <?php else : ?>

            <div class="cart-empty-container">
                <?php wc_get_template( 'cart/cart-empty.php' ); ?>
            </div>

        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity buttons
    const qtyButtons = document.querySelectorAll('.qty-btn');
    const updateButton = document.querySelector('.update-cart-button');
    
    qtyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const input = this.parentNode.querySelector('.qty');
            if (!input) return;
            
            const currentValue = parseInt(input.value) || 1;
            const min = parseInt(input.getAttribute('min')) || 1;
            const maxAttr = input.getAttribute('max');
            const max = maxAttr ? parseInt(maxAttr) : null;
            
            let newValue = currentValue;
            
            if (this.classList.contains('minus')) {
                if (currentValue > min) {
                    newValue = currentValue - 1;
                    if (newValue < min) newValue = min;
                }
            } else if (this.classList.contains('plus')) {
                if (max === null || currentValue < max) {
                    newValue = currentValue + 1;
                    if (max !== null && newValue > max) newValue = max;
                }
            }
            
            // Only update if value actually changed
            if (newValue !== currentValue) {
                input.value = newValue;
                
                // Update button states
                const minusBtn = this.parentNode.querySelector('.minus');
                const plusBtn = this.parentNode.querySelector('.plus');
                
                if (minusBtn) {
                    minusBtn.disabled = (newValue <= min);
                }
                if (plusBtn) {
                    plusBtn.disabled = (max !== null && newValue >= max);
                }
                
                // Enable update cart button
                if (updateButton) {
                    updateButton.disabled = false;
                }
                
                // Trigger change event
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });
    
    // Handle direct input changes
    const qtyInputs = document.querySelectorAll('.qty');
    qtyInputs.forEach(input => {
        input.addEventListener('change', function() {
            const min = parseInt(this.getAttribute('min')) || 1;
            const maxAttr = this.getAttribute('max');
            const max = maxAttr ? parseInt(maxAttr) : null;
            const value = parseInt(this.value) || 1;
            
            // Clamp value to min/max
            if (value < min) {
                this.value = min;
            } else if (max !== null && value > max) {
                this.value = max;
            }
            
            // Update button states
            const minusBtn = this.parentNode.querySelector('.minus');
            const plusBtn = this.parentNode.querySelector('.plus');
            
            if (minusBtn) {
                minusBtn.disabled = (parseInt(this.value) <= min);
            }
            if (plusBtn) {
                plusBtn.disabled = (max !== null && parseInt(this.value) >= max);
            }
            
            // Enable update cart button
            if (updateButton) {
                updateButton.disabled = false;
            }
        });
    });
});
</script>

<?php get_footer(); 