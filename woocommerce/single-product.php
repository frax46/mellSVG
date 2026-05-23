<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/single-product.php.
 *
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<div class="mellluxe-single-product">
    
    <?php
        /**
         * woocommerce_before_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         */
        do_action( 'woocommerce_before_main_content' );
    ?>

    <?php while ( have_posts() ) : ?>
        <?php the_post(); ?>

        <div class="container-fluid">
            <div class="product-hero-section">
                <div class="container">
                    <div class="product-layout">
                        
                        <!-- Product Images -->
                        <div class="product-images-section">
                            <div class="product-gallery">
                                <?php
                                global $product;
                                $attachment_ids = $product->get_gallery_image_ids();
                                $main_image_id = $product->get_image_id();
                                
                                // Main product image
                                if ($main_image_id) {
                                    echo '<div class="main-product-image">';
                                    echo '<div class="image-container">';
                                    echo wp_get_attachment_image($main_image_id, 'full', false, array('class' => 'product-main-img', 'data-zoom' => wp_get_attachment_image_url($main_image_id, 'full')));
                                    echo '<button class="zoom-btn" aria-label="Zoom image"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M15 11h-8M11 7v8"/></svg></button>';
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    echo '<div class="main-product-image">';
                                    echo '<div class="image-container">';
                                    echo '<img src="' . wc_placeholder_img_src() . '" alt="Product Image" class="product-main-img">';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                
                                // Gallery thumbnails
                                $all_images = array();
                                if ($main_image_id) {
                                    $all_images[] = $main_image_id;
                                }
                                if ($attachment_ids) {
                                    $all_images = array_merge($all_images, $attachment_ids);
                                }
                                
                                if (count($all_images) > 1) {
                                    echo '<div class="product-thumbnails">';
                                    foreach ($all_images as $index => $image_id) {
                                        $is_active = ($image_id == $main_image_id) ? 'active' : '';
                                        $full_image_url = wp_get_attachment_image_url($image_id, 'full');
                                        $srcset = wp_get_attachment_image_srcset($image_id, 'full');
                                        $sizes = wp_get_attachment_image_sizes($image_id, 'full');
                                        
                                        echo '<div class="thumbnail ' . $is_active . '" data-image="' . $full_image_url . '" data-srcset="' . esc_attr($srcset) . '" data-sizes="' . esc_attr($sizes) . '" data-index="' . $index . '">';
                                        echo wp_get_attachment_image($image_id, 'thumbnail');
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Product Information -->
                        <div class="product-info-section">
                            
                            <!-- Product Category -->
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'product_cat');
                            if ($categories && !is_wp_error($categories)) {
                                echo '<div class="product-category">';
                                echo '<span>' . esc_html($categories[0]->name) . '</span>';
                                echo '</div>';
                            }
                            ?>
                            
                            <!-- Product Title -->
                            <h1 class="product-title">
                                <?php 
                                $title = get_the_title();
                                $title = str_replace('_', ' ', $title);
                                $title = ucwords($title);
                                echo $title;
                                ?>
                            </h1>
                            
                            <!-- Product Rating -->
                            <div class="product-rating-wrapper">
                                <?php woocommerce_template_single_rating(); ?>
                                
                            </div>
                            
                            <!-- Product Price -->
                            <div class="product-price-section">
                                <?php woocommerce_template_single_price(); ?>
                            </div>
                            
                            <!-- Product Description -->
                            <div class="product-description">
                                <?php 
                                $short_description = $product->get_short_description();
                                if ($short_description) {
                                    echo '<p>' . $short_description . '</p>';
                                } else {
                                    echo '<p>Handcrafted with 100% natural, vegan, and cruelty-free ingredients. Made with love in the UK.</p>';
                                }
                                ?>
                            </div>
                            
                            <!-- Product Features -->
                            <div class="product-features">
                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/>
                                            <path d="M12 6v6l4 2"/>
                                        </svg>
                                    </div>
                                    <div class="feature-content">
                                        <span class="feature-title">100% Vegan</span>
                                        <span class="feature-desc">Plant-based ingredients</span>
                                    </div>
                                </div>
                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </div>
                                    <div class="feature-content">
                                        <span class="feature-title">Cruelty-Free</span>
                                        <span class="feature-desc">Never tested on animals</span>
                                    </div>
                                </div>
                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <div class="feature-content">
                                        <span class="feature-title">Made in UK</span>
                                        <span class="feature-desc">Locally crafted with care</span>
                                    </div>
                                </div>
                                <div class="feature">
                                    <div class="feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 6h18l-2 13H5L3 6z"/>
                                            <path d="M8 6V4a4 4 0 0 1 8 0v2"/>
                                            <circle cx="9" cy="13" r="1"/>
                                            <circle cx="15" cy="13" r="1"/>
                                        </svg>
                                    </div>
                                    <div class="feature-content">
                                        <span class="feature-title">Eco-Friendly</span>
                                        <span class="feature-desc">Sustainable packaging</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Add to Cart Form -->
                            <div class="add-to-cart-section">
                                <?php woocommerce_template_single_add_to_cart(); ?>
                            </div>
                            
                            <!-- Trust Badges -->
                            <div class="trust-badges">
                                <div class="trust-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4"/>
                                        <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"/>
                                        <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"/>
                                        <path d="M12 3c0 1-1 3-3 3s-3-2-3-3 1-3 3-3 3 2 3 3"/>
                                        <path d="M12 21c0-1 1-3 3-3s3 2 3 3-1 3-3 3-3-2-3-3"/>
                                    </svg>
                                    <span>Free shipping over £25</span>
                                </div>
                                <div class="trust-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"/>
                                        <path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                    </svg>
                                    <span>Secure payment</span>
                                </div>
                                <div class="trust-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 11H5a2 2 0 00-2 2v7a2 2 0 002 2h14a2 2 0 002-2v-7a2 2 0 00-2-2h-4"/>
                                        <path d="M9 11V7a3 3 0 016 0v4"/>
                                    </svg>
                                    <span>30-day return policy</span>
                                </div>
                            </div>
                            
                            <!-- Product Meta -->
                            <div class="product-meta">
                                <?php woocommerce_template_single_meta(); ?>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <?php
            /**
             * woocommerce_after_single_product_summary hook.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_after_single_product_summary' );
        ?>

    <?php endwhile; // end of the loop. ?>

    <?php
        /**
         * woocommerce_after_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );
    ?>

</div>

<!-- Image Lightbox Modal -->
<div id="imageModal" class="image-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <img class="modal-image" id="modalImage" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" alt="Expanded product image">
        <div class="modal-nav">
            <button class="prev-modal">❮</button>
            <button class="next-modal">❯</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.querySelector('.product-main-img');
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const closeModal = document.querySelector('.close-modal');
    const prevModal = document.querySelector('.prev-modal');
    const nextModal = document.querySelector('.next-modal');
    const zoomBtn = document.querySelector('.zoom-btn');
    
    let currentImageIndex = 0;
    const images = [];
    
    // Collect all images
    thumbnails.forEach((thumb, index) => {
        images.push(thumb.dataset.image);
        thumb.addEventListener('click', function() {
            const newImageSrc = this.dataset.image;
            const newIndex = parseInt(this.dataset.index);
            
            if (mainImage && newImageSrc) {
                mainImage.src = newImageSrc;
                mainImage.dataset.zoom = newImageSrc;
                currentImageIndex = newIndex;
                
                // Update active thumbnail
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
    
    // Zoom functionality
    if (zoomBtn) {
        zoomBtn.addEventListener('click', function() {
            modal.style.display = 'block';
            modalImage.src = mainImage.dataset.zoom || mainImage.src;
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Modal functionality
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });
    }
    
    if (prevModal) {
        prevModal.addEventListener('click', function() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            modalImage.src = images[currentImageIndex];
        });
    }
    
    if (nextModal) {
        nextModal.addEventListener('click', function() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            modalImage.src = images[currentImageIndex];
        });
    }
    
    // Close modal on click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (modal.style.display === 'block') {
            if (e.key === 'Escape') {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            } else if (e.key === 'ArrowLeft') {
                prevModal.click();
            } else if (e.key === 'ArrowRight') {
                nextModal.click();
            }
        }
    });
    
    // Enhanced quantity controls
    const qtyInputs = document.querySelectorAll('input[name="quantity"]');
    qtyInputs.forEach(input => {
        const wrapper = input.closest('.quantity');
        if (wrapper && !wrapper.querySelector('.qty-btn')) {
            // Create custom quantity controls
            const minusBtn = document.createElement('button');
            minusBtn.type = 'button';
            minusBtn.className = 'qty-btn minus';
            minusBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/></svg>';
            
            const plusBtn = document.createElement('button');
            plusBtn.type = 'button';
            plusBtn.className = 'qty-btn plus';
            plusBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>';
            
            // Style the wrapper
            wrapper.classList.add('enhanced-quantity');
            
            wrapper.insertBefore(minusBtn, input);
            wrapper.appendChild(plusBtn);
            
            // Add functionality
            minusBtn.addEventListener('click', function() {
                let currentVal = parseInt(input.value) || 1;
                if (currentVal > 1) {
                    input.value = currentVal - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
            
            plusBtn.addEventListener('click', function() {
                let currentVal = parseInt(input.value) || 1;
                let maxVal = parseInt(input.getAttribute('max')) || 999;
                if (currentVal < maxVal) {
                    input.value = currentVal + 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    });
    
    // Add to cart button enhancement
    const addToCartBtn = document.querySelector('.single_add_to_cart_button');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            this.classList.add('loading');
            this.innerHTML = '<div class="spinner"></div>Adding to Cart...';
            
            // Reset after 2 seconds (WooCommerce will handle the actual process)
            setTimeout(() => {
                this.classList.remove('loading');
                this.innerHTML = 'Add to Cart';
            }, 2000);
        });
    }
});
</script>

<style>
/* Single Product Page Styles */
.mellluxe-single-product {
    margin-top: 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    min-height: 100vh;
}

.container-fluid {
    padding: 0;
}

.product-hero-section {
    padding: 120px 0 80px 0;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Product Layout */
.product-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 100px;
    align-items: start;
}

/* Product Images Section */
.product-images-section {
    position: sticky;
    top: 120px;
}

.main-product-image {
    margin-bottom: 24px;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.image-container {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
}

.product-main-img {
    width: 100%;
    height: 600px;
    object-fit: cover;
    transition: transform 0.5s ease;
    cursor: zoom-in;
}

.product-main-img:hover {
    transform: scale(1.05);
}

.zoom-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--primary-color);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.zoom-btn:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.product-thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 16px;
    max-width: 520px;
}

.thumbnail {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    position: relative;
}

.thumbnail.active {
    border-color: var(--primary-color);
    box-shadow: 0 8px 25px rgba(37, 23, 70, 0.3);
}

.thumbnail:hover {
    border-color: var(--secondary-color);
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.thumbnail:hover img {
    transform: scale(1.1);
}

/* Product Info Section */
.product-info-section {
    padding: 40px 0;
}

.product-category {
    margin-bottom: 16px;
}

.product-category span {
    background: var(--secondary-color);
    color: var(--primary-color);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 800;
    color: var(--primary-color);
    margin: 0 0 24px 0;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

.product-rating-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}

.woocommerce-product-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.star-rating {
    color: #ffd700;
}

.rating-count {
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
}

.product-price-section {
    margin-bottom: 32px;
}

.product-price-section .price {
    font-size: 3rem;
    font-weight: 900;
    color: var(--primary-color);
    display: flex;
    align-items: baseline;
    gap: 12px;
}

.product-price-section .price del {
    color: #999;
    font-size: 2rem;
    font-weight: 600;
}

.product-price-section .price ins {
    text-decoration: none;
    color: #e74c3c;
}

.product-description {
    margin-bottom: 40px;
    font-size: 18px;
    line-height: 1.8;
    color: #4a5568;
}

.product-description p {
    margin: 0;
}

/* Product Features */
.product-features {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 48px;
    padding: 32px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.feature {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.feature-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--secondary-color), #f7d794);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    flex-shrink: 0;
}

.feature-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.feature-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary-color);
}

.feature-desc {
    font-size: 14px;
    color: #6c757d;
}

/* Add to Cart Section */
.add-to-cart-section {
    margin-bottom: 40px;
}

.add-to-cart-section form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.enhanced-quantity {
    display: flex;
    align-items: center;
    border: 2px solid #e9ecef;
    border-radius: 50px;
    overflow: hidden;
    width: fit-content;
    background: white;
}

.qty-btn {
    width: 48px;
    height: 48px;
    border: none;
    background: transparent;
    color: var(--primary-color);
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:hover {
    background: var(--primary-color);
    color: white;
}

.enhanced-quantity input[type="number"] {
    border: none;
    text-align: center;
    width: 60px;
    height: 48px;
    font-weight: 600;
    font-size: 16px;
    background: transparent;
    color: var(--primary-color);
}

.enhanced-quantity input[type="number"]:focus {
    outline: none;
}

.single_add_to_cart_button {
    width: 100%;
    padding: 20px 32px;
    background: linear-gradient(135deg, var(--primary-color), #1a0f3a);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.single_add_to_cart_button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.single_add_to_cart_button:hover::before {
    left: 100%;
}

.single_add_to_cart_button:hover {
    background: linear-gradient(135deg, var(--secondary-color), #f7d794);
    color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(253, 226, 141, 0.4);
}

.single_add_to_cart_button.loading {
    pointer-events: none;
    opacity: 0.8;
}

.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Trust Badges */
.trust-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 40px;
    padding: 24px;
    background: #f8f9fa;
    border-radius: 16px;
}

.trust-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #4a5568;
    font-size: 14px;
    font-weight: 500;
}

.trust-badge svg {
    color: #28a745;
    flex-shrink: 0;
}

/* Product Meta */
.product-meta {
    padding: 24px 0;
    border-top: 1px solid #e9ecef;
}

.product_meta {
    font-size: 14px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.product_meta > span {
    color: #6c757d;
}

.product_meta a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.product_meta a:hover {
    color: var(--secondary-color);
}

/* Image Modal */
.image-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(5px);
}

.modal-content {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    position: relative;
}

.modal-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    border-radius: 10px;
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10001;
}

.close-modal:hover {
    color: var(--secondary-color);
}

.modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    pointer-events: none;
}

.prev-modal,
.next-modal {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    font-size: 24px;
    padding: 12px 16px;
    cursor: pointer;
    border-radius: 50%;
    transition: all 0.3s ease;
    pointer-events: auto;
    backdrop-filter: blur(10px);
}

.prev-modal:hover,
.next-modal:hover {
    background: rgba(255, 255, 255, 0.2);
    color: var(--secondary-color);
}

/* WooCommerce Tabs Enhancement */
.woocommerce-tabs {
    margin-top: 80px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.woocommerce-tabs .tabs {
    display: flex;
    background: var(--primary-color);
    margin: 0;
    padding: 0;
    list-style: none;
}

.woocommerce-tabs .tabs li {
    flex: 1;
    margin: 0;
}

.woocommerce-tabs .tabs li a {
    display: block;
    padding: 24px 20px;
    text-align: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 16px;
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.woocommerce-tabs .tabs li:last-child a {
    border-right: none;
}

.woocommerce-tabs .tabs li.active a,
.woocommerce-tabs .tabs li a:hover {
    background: var(--secondary-color);
    color: var(--primary-color);
}

.woocommerce-tabs .panel {
    padding: 48px;
    background: white;
    min-height: 200px;
}

.woocommerce-tabs .panel h2 {
    color: var(--primary-color);
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 24px;
}

/* Related Products Enhancement */
.single-product-related {
    margin-top: 100px;
    padding: 80px 0;
    background: #f8f9fa;
}

.related.products h2 {
    font-size: 3rem;
    font-weight: 800;
    color: var(--primary-color);
    text-align: center;
    margin-bottom: 60px;
}

.related.products .products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 32px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.related.products .product {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
}

.related.products .product:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.related.products .product img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.related.products .product:hover img {
    transform: scale(1.05);
}

.related.products .product h2 {
    padding: 20px 24px 8px 24px;
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
    text-align: left;
}

.related.products .product .price {
    padding: 0 24px 24px 24px;
    font-size: 20px;
    font-weight: 800;
    color: var(--primary-color);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .product-layout {
        gap: 60px;
    }
    
    .product-hero-section {
        padding: 100px 0 60px 0;
    }
}

@media (max-width: 992px) {
    .product-layout {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .product-images-section {
        position: static;
    }
    
    .product-main-img {
        height: 500px;
    }
    
    .product-features {
        grid-template-columns: 1fr;
    }
    
    .woocommerce-tabs .tabs {
        flex-direction: column;
    }
    
    .woocommerce-tabs .tabs li a {
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .woocommerce-tabs .tabs li:last-child a {
        border-bottom: none;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 16px;
    }
    
    .product-hero-section {
        padding: 80px 0 40px 0;
    }
    
    .product-main-img {
        height: 400px;
    }
    
    .product-thumbnails {
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        max-width: 100%;
    }
    
    .thumbnail {
        width: 80px;
        height: 80px;
    }
    
    .product-title {
        font-size: 2rem;
    }
    
    .product-price-section .price {
        font-size: 2.5rem;
    }
    
    .product-features {
        padding: 24px;
    }
    
    .trust-badges {
        flex-direction: column;
        gap: 12px;
    }
    
    .woocommerce-tabs .panel {
        padding: 32px 24px;
    }
    
    .related.products h2 {
        font-size: 2rem;
    }
    
    .related.products .products {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }
}

@media (max-width: 480px) {
    .product-features {
        grid-template-columns: 1fr;
        padding: 20px;
    }
    
    .feature {
        flex-direction: column;
        text-align: center;
        align-items: center;
    }
    
    .trust-badges {
        padding: 20px;
    }
    
    .single_add_to_cart_button {
        font-size: 16px;
        padding: 16px 24px;
    }
    
    .enhanced-quantity {
        width: 100%;
        justify-content: center;
    }
    
    .close-modal {
        font-size: 30px;
        top: 15px;
        right: 20px;
    }
    
    .modal-nav {
        padding: 0 10px;
    }
    
    .prev-modal,
    .next-modal {
        font-size: 18px;
        padding: 10px 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product Gallery Functionality
    const mainImage = document.querySelector('.product-main-img');
    const thumbnails = document.querySelectorAll('.product-thumbnails .thumbnail');
    const zoomBtn = document.querySelector('.zoom-btn');
    
    if (!mainImage || !thumbnails.length) return;
    
    // Thumbnail click functionality
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            
            // Add active class to clicked thumbnail
            this.classList.add('active');
            
            // Get the new image data
            const newImageUrl = this.getAttribute('data-image');
            const newSrcset = this.getAttribute('data-srcset');
            const newSizes = this.getAttribute('data-sizes');
            
            if (newImageUrl) {
                // Add fade out effect
                mainImage.style.opacity = '0.5';
                
                // Change the main image source and responsive attributes
                setTimeout(() => {
                    mainImage.src = newImageUrl;
                    mainImage.setAttribute('data-zoom', newImageUrl);
                    
                    // Update srcset and sizes for responsive images
                    if (newSrcset) {
                        mainImage.setAttribute('srcset', newSrcset);
                    }
                    if (newSizes) {
                        mainImage.setAttribute('sizes', newSizes);
                    }
                    
                    // Fade back in
                    mainImage.style.opacity = '1';
                }, 150);
            }
        });
    });
    
    // Note: Zoom functionality is handled by the existing modal system above
    
    // Keyboard navigation for thumbnails
    document.addEventListener('keydown', function(e) {
        if (document.querySelector('.product-gallery:hover')) {
            const activeThumbnail = document.querySelector('.thumbnail.active');
            const currentIndex = Array.from(thumbnails).indexOf(activeThumbnail);
            
            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                thumbnails[currentIndex - 1].click();
            } else if (e.key === 'ArrowRight' && currentIndex < thumbnails.length - 1) {
                thumbnails[currentIndex + 1].click();
            }
        }
    });
});
</script>

<style>
/* Duplicate modal styles removed - using existing .image-modal system */

/* Improved thumbnail active state */
.product-thumbnails .thumbnail.active {
    border: 3px solid var(--primary-color);
    transform: scale(1.05);
}

.product-thumbnails .thumbnail {
    transition: all 0.3s ease;
    cursor: pointer;
}

.product-thumbnails .thumbnail:hover {
    transform: scale(1.02);
    opacity: 0.8;
}

/* Main image transition */
.product-main-img {
    transition: opacity 0.3s ease;
}
</style>

<?php get_footer(); ?> 
