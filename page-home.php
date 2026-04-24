<?php
/**
 * Template Name: Home Page
 * The template for displaying the Home page
 */

get_header();


$promo_title = function_exists('get_field') ? esc_html(get_field('promo_title')) : '';
$promo_text = function_exists('get_field') ? esc_html(get_field('promo_text')) : '';
$hero_text = function_exists('get_field') ? esc_html(get_field('hero_text')) : '';
$home_text_1 = function_exists('get_field') ? esc_html(get_field('home_text_1')) : '';
$home_text_2 = function_exists('get_field') ? esc_html(get_field('home_text_2')) : '';
$home_image_1_left = function_exists('get_field') ? esc_html(get_field('home_image_1_left')) : '';
$home_image_1_right = function_exists('get_field') ? esc_html(get_field('home_image_1_right')) : '';
$home_image_2 = function_exists('get_field') ? esc_html(get_field('home_image_2')) : '';
$home_image_21 = function_exists('get_field') ? esc_html(get_field('home_image_21')) : '';
$home_image_22 = function_exists('get_field') ? esc_html(get_field('home_image_22')) : '';
$home_image_23 = function_exists('get_field') ? esc_html(get_field('home_image_23')) : '';
$home_image_24 = function_exists('get_field') ? esc_html(get_field('home_image_24')) : '';
$our_best_text = function_exists('get_field') ? esc_html(get_field('our_best_text')) : '';
$our_best_image_1 = function_exists('get_field') ? esc_html(get_field('our_best_image_1')) : '';
$our_best_image_2 = function_exists('get_field') ? esc_html(get_field('our_best_image_2')) : '';
$our_best_image_3 = function_exists('get_field') ? esc_html(get_field('our_best_image_3')) : '';
$our_best_image_4 = function_exists('get_field') ? esc_html(get_field('our_best_image_4')) : '';
$our_best_image_5 = function_exists('get_field') ? esc_html(get_field('our_best_image_5')) : '';
$our_best_image_6 = function_exists('get_field') ? esc_html(get_field('our_best_image_6')) : '';
$our_best_image_7 = function_exists('get_field') ? esc_html(get_field('our_best_image_7')) : '';
$our_best_image_8 = function_exists('get_field') ? esc_html(get_field('our_best_image_8')) : '';
$our_best_image_9 = function_exists('get_field') ? esc_html(get_field('our_best_image_9')) : '';
$our_best_image_10 = function_exists('get_field') ? esc_html(get_field('our_best_image_10')) : '';
$our_best_image_1_link = function_exists('get_field') ? esc_html(get_field('our_best_image_1_link')) : '';
$our_best_image_2_link = function_exists('get_field') ? esc_html(get_field('our_best_image_2_link')) : '';
$our_best_image_3_link = function_exists('get_field') ? esc_html(get_field('our_best_image_3_link')) : '';
$our_best_image_4_link = function_exists('get_field') ? esc_html(get_field('our_best_image_4_link')) : '';
$our_best_image_5_link = function_exists('get_field') ? esc_html(get_field('our_best_image_5_link')) : '';
$our_best_image_6_link = function_exists('get_field') ? esc_html(get_field('our_best_image_6_link')) : '';
$our_best_image_7_link = function_exists('get_field') ? esc_html(get_field('our_best_image_7_link')) : '';
$our_best_image_8_link = function_exists('get_field') ? esc_html(get_field('our_best_image_8_link')) : '';
$our_best_image_9_link = function_exists('get_field') ? esc_html(get_field('our_best_image_9_link')) : '';
$our_best_image_10_link = function_exists('get_field') ? esc_html(get_field('our_best_image_10_link')) : '';
$hero_image2_link = function_exists('get_field') ? esc_html(get_field('hero_image2_link')) : '';
$home_image_1_left_link = function_exists('get_field') ? esc_html(get_field('home_image_1_left_link')) : '';
$home_image_1_right_link = function_exists('get_field') ? esc_html(get_field('home_image_1_right_link')) : '';
$home_image_1_bottom_link = function_exists('get_field') ? esc_html(get_field('home_image_1_bottom_link')) : '';
$home_image_1_bottom = function_exists('get_field') ? esc_html(get_field('home_image_1_bottom')) : '';

/** Ordered PNG sequence for scroll-driven hero (images/hero_frame). */
$hero_frame_urls = array();
$hero_frame_dir = get_template_directory() . '/images/hero_frame';
if (is_dir($hero_frame_dir)) {
    $hero_frame_files = glob($hero_frame_dir . '/Crystal_particle_effects_*.png');
    if (!empty($hero_frame_files)) {
        natsort($hero_frame_files);
        foreach (array_values($hero_frame_files) as $hero_frame_path) {
            $hero_frame_urls[] = get_template_directory_uri() . '/images/hero_frame/' . basename($hero_frame_path);
        }
    }
}




?>

<div class="snap-container">
    <section class="mobile-hero-section">
        <div class="mobile-hero-container">
            <div class="mobile-hero-text">
                <h1>At Mell Luxe...</h1>
                <h2>... nature meets luxury in every handcrafted product.</h2>
                <div class="text2">
                    <p><?php echo $hero_text; ?></p>
                </div>
                <a href="<?php echo  esc_url(home_url('/product-category/all-products/')); ?>" class="hero-cta-button">
                    SHOP <span>→</span>
                </a>
            </div>
        </div>
        <div class="section-2">
            <div class="container">

                <div class="img-container">
                    <a href="<?php echo $hero_image2_link ?>">
                        <img src="<?php $hero_image = function_exists('get_field') ? esc_html(get_field('hero_image2')) : '';
                        echo $hero_image; ?>" alt="Bath Products" class="">
                    </a>
                </div>

                <div class="text-content">

                    <p> <?php $hero_text = function_exists('get_field') ? esc_html(get_field('hero_text2')) : '';
                    echo $hero_text; ?>
                    </p>
                    <a href="<?php echo  esc_url(home_url('/product-category/all-products/')); ?>" class="hero-cta-button">
                        SHOP <span>→</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="section-3">
            <div class="container">

                <div class="text-container">
                    <p><?php echo $home_text_1; ?></p>
                    <a href="<?php echo $home_image_1_bottom_link; ?>">
                        <img src="<?php echo $home_image_1_bottom; ?>" alt="Luxury Body Oil" class="brand-product-img">
                    </a>
                </div>
                <div class="img-container">
                    <div class="img-1">
                        <a href="<?php echo $home_image_1_left_link; ?>">
                            <img src="<?php echo $home_image_1_left; ?>" alt="Luxury Body Oil"
                                class="brand-product-img">
                        </a>
                    </div>
                    <div class="img-2">
                        <a href="<?php echo $home_image_1_right_link; ?>">
                            <img src="<?php echo $home_image_1_right; ?>" alt="Facial Cleansing Dough"
                                class="brand-product-img">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-4">
            <div class="container">
                <div class="text-container">
                    <p><?php echo $home_text_2; ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section -->
    <section class="snap-section hero-section<?php echo !empty($hero_frame_urls) ? ' hero-section--frames' : ''; ?>"
        id="hero">
        <?php

        if (!empty($promo_title)): ?>
            <!-- Special Offer Banner -->
            <div class="offer-banner" aria-label="Special offer">
                <div class="offer-marquee">
                    <div class="offer-track">
                        <div class="offer-group">
                            <?php for ($i = 0; $i < 6; $i++): ?>
                                <span class="offer-item"><?php echo $promo_title; ?> — <?php echo $promo_text; ?></span>
                            <?php endfor; ?>
                        </div>
                        <div class="offer-group" aria-hidden="true">
                            <?php for ($i = 0; $i < 6; $i++): ?>
                                <span class="offer-item"><?php echo $promo_title; ?> — <?php echo $promo_text; ?></span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Hero Content: full-bleed frame + constrained copy -->
        <div class="hero-stage">
            <?php if (!empty($hero_frame_urls)) : ?>
                <div class="hero-frame" data-hero-frames="<?php echo esc_attr(wp_json_encode($hero_frame_urls)); ?>"
                    data-active-layer="a" aria-hidden="true">
                    <?php $hero_first = esc_url($hero_frame_urls[0]); ?>
                    <img src="<?php echo $hero_first; ?>" alt="" class="hero-frame-layer hero-frame-layer--a"
                        id="hero-frame-display" width="1920" height="1080" loading="eager" decoding="async"
                        fetchpriority="high">
                    <img src="<?php echo $hero_first; ?>" alt="" class="hero-frame-layer hero-frame-layer--b"
                        width="1920" height="1080" loading="eager" decoding="async" aria-hidden="true">
                </div>
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/assets/hero.png" alt="Mell Luxe"
                    class="hero-image">
            <?php endif; ?>
            <div class="hero-content hero">
                <div class="hero-text">
                    <div class="hero-text-container">
                        <h1 class="hero-text-sr-only">At Mell Luxe...</h1>
                        <h2 class="hero-text-sr-only">... nature meets luxury in every handcrafted product.</h2>
                        <svg class="hero-svg-text" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true"
                            viewBox="0 0 1200 300" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <g class="hero-svg-line hero-svg-line--1">
                                <text class="hero-svg-tline hero-svg-tline--1" x="0" y="108"
                                    font-family="Montserrat, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif"
                                    font-weight="300" fill="currentColor"><?php echo esc_html('At Mell Luxe...'); ?></text>
                            </g>
                            <g class="hero-svg-line hero-svg-line--2">
                                <text class="hero-svg-tline hero-svg-tline--2" x="0" y="198"
                                    font-family="Montserrat, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif"
                                    font-weight="300" fill="currentColor"><?php echo esc_html('... nature meets luxury in every handcrafted product.'); ?></text>
                            </g>
                        </svg>
                    </div>
                </div>
                <a href="<?php echo esc_url(home_url('/product-category/all-products/')) ; ?>" class="hero-cta-button">
                    SHOP <span>→</span>
                </a>
            </div>
        </div>
    </section>
    <section class="info-1">
        <div class="container">
            <div class="box1" style="grid-area: box1">
                <div class="text-container">
                    <h2>Rituals for Mind, Body & Soul</h2>
                    <p>At Mell Luxe, self-care isn’t just a routine—it’s a sacred pause. Our bath salts, body oils and
                        scrubs are infused with natural botanicals and calming aromatherapy to relax your mind, nourish
                        your skin and uplift your spirit. Each blend transforms ordinary moments into luxurious rituals
                        of peace, grounding and renewal.</p>

                </div>
            </div>
            <div class="box2" style="grid-area: box2">

            </div>
            <div class="box3" style="grid-area: box3">
                <h2>Where Nature Becomes Science</h2>
            </div>
            <div class="box4" style="grid-area: box4">
                <div class="text-container">

                    <p>True beauty is harmony. Our serums and facial oils unite plant-powered ingredients with
                        clinically tested formulations to deliver visible, lasting results. Each product works in rhythm
                        with your skin’s natural balance restoring hydration, boosting radiance and revealing a
                        healthier, more confident glow with every application.
                    </p>

                </div>
            </div>
        </div>
    </section>

    <section class="info-2">
        <div class="container">
            <!-- Our Story Section -->
            <section class="our-story-section">
                <div class="story-content">
                    <div class="story-header">
                        <h2 class="story-title">Our Story</h2>
                        <div class="title-underline"></div>
                    </div>

                    <div class="story-main">
                        <div class="story-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/System Images/IMG_0972_edited_edited.jpg"
                                alt="Our workshop where we create natural beauty products" class="workshop-image">
                        </div>

                        <div class="story-text">
                            <div class="text-block">
                                <p>We started with a <span class="highlight">simple belief</span>. Luxury shouldn't come
                                    at the earth or <span class="highlight">planet's expense</span>. True care for the
                                    planet itself means caring for our world.</p>
                            </div>

                            <div class="text-block">
                                <p>Sometimes the greatest luxury is taking time for yourself. Our wellness collection
                                    helps you create meaningful moments of self-care, whether it's a five-minute
                                    meditation or an hour-long pampering session.</p>
                            </div>
                        </div>
                    </div>

                    <div class="story-cta">
                        <a href="<?php echo esc_url(home_url('/about/')); ?>">
                            <div class="cta-box">
                                <p class="cta-text">EXPERIENCE THE DIFFERENCE</p>
                                <p class="cta-subtext">YOUR SKIN DESERVES</p>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </section>
    
    <section class="snap-section about-section" id="best">
        <div class="best-container">
            <!-- Left Side - Product Slider -->
            <div class="product-slider-section">
                <!-- Main Product Display -->
                <div class="main-product-display">
                    <!-- Navigation Arrows -->
                    <button class="slider-nav prev-btn" id="prevBtn">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <!-- Main Product Image -->
                    <div class="main-product-container">
                        <div class="main-product-image">
                            <a href="<?php echo $our_best_image_1_link; ?>">
                                <img id="mainProductImg" src="<?php echo $our_best_image_1; ?>" alt="Beauty Serum"
                                    class="main-img">
                            </a>
                        </div>
                    </div>

                    <button class="slider-nav next-btn" id="nextBtn">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <!-- Thumbnail Slider -->
                <div class="thumbnail-slider">
                    <div class="thumbnail-container" id="thumbnailContainer">
                        <div class="thumbnail-item active" data-img="<?php echo $our_best_image_1; ?>">
                            <img src="<?php echo $our_best_image_1; ?>" alt="Beauty Serum">
                            <a href="<?php echo $our_best_image_1_link; ?>" class="thumbnail-link"></a>
                        </div>
                        <div class="thumbnail-item" data-img="<?php echo $our_best_image_2; ?>">
                            <img src="<?php echo $our_best_image_2; ?>" alt="24k Gold Elixir">
                            <a href="<?php echo $our_best_image_2_link; ?>" class="thumbnail-link"></a>
                        </div>
                        <div class="thumbnail-item" data-img="<?php echo $our_best_image_3; ?>">
                            <img src="<?php echo $our_best_image_3; ?>" alt="Bath Salts">
                            <a href="<?php echo $our_best_image_3_link; ?>" class="thumbnail-link"></a>
                        </div>
                        <div class="thumbnail-item" data-img="<?php echo $our_best_image_4; ?>">
                            <img src="<?php echo $our_best_image_4; ?>" alt="Body Oil">
                            <a href="<?php echo $our_best_image_4_link; ?>" class="thumbnail-link"></a>
                        </div>
                        <div class="thumbnail-item" data-img="<?php echo $our_best_image_5; ?>">
                            <img src="<?php echo $our_best_image_5; ?>" alt="Facial Oil">
                            <a href="<?php echo $our_best_image_5_link; ?>" class="thumbnail-link"></a>
                        </div>
                        <?php if (!empty($our_best_image_6)): ?>
                            <div class="thumbnail-item" data-img="<?php echo $our_best_image_6; ?>">
                                <img src="<?php echo $our_best_image_6; ?>" alt="Best Pick 6">
                                <a href="<?php echo $our_best_image_6_link; ?>" class="thumbnail-link"></a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($our_best_image_7)): ?>
                            <div class="thumbnail-item" data-img="<?php echo $our_best_image_7; ?>">
                                <img src="<?php echo $our_best_image_7; ?>" alt="Best Pick 7">
                                <a href="<?php echo $our_best_image_7_link; ?>" class="thumbnail-link"></a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($our_best_image_8)): ?>
                            <div class="thumbnail-item" data-img="<?php echo $our_best_image_8; ?>">
                                <img src="<?php echo $our_best_image_8; ?>" alt="Best Pick 8">
                                <a href="<?php echo $our_best_image_8_link; ?>" class="thumbnail-link"></a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($our_best_image_9)): ?>
                            <div class="thumbnail-item" data-img="<?php echo $our_best_image_9; ?>">
                                <img src="<?php echo $our_best_image_9; ?>" alt="Best Pick 9">
                                <a href="<?php echo $our_best_image_9_link; ?>" class="thumbnail-link"></a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($our_best_image_10)): ?>
                            <div class="thumbnail-item" data-img="<?php echo $our_best_image_10; ?>">
                                <img src="<?php echo $our_best_image_10; ?>" alt="Best Pick 10">
                                <a href="<?php echo $our_best_image_10_link; ?>" class="thumbnail-link"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Side - Content -->
            <div class="best-content-section">
                <!-- "Our" Text -->
                <div class="our-text">
                    <h2>Our</h2>
                    <div class="best-text">Best</div>
                </div>
                <!-- Description Container -->
                <div class="best-description">
                    <p>... Each item is thoughtfully packaged in recyclable, eco-friendly materials, reflecting Mell's commitment to sustainability and the environment. Our formulations harness the power of nature's best, like hyaluronic acid, vegan squalane, blue spirulina, and essential oils, to deliver visible results and unparalleled care.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="info-3">
        <h1>What We Create</h1>
        <div class="circle"></div>
        <div class="container">
            <img src="<?php echo get_template_directory_uri(); ?>/images/assets/bottle-1.png" style="grid-area: img1"
                alt="Mell Luxe" class="bottle-img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/assets/bottle-2.png" style="grid-area: img2"
                alt="Mell Luxe" class="bottle-img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/assets/bottle-3.png" style="grid-area: img3"
                alt="Mell Luxe" class="bottle-img">
            <div class="box1" style="grid-area: box1">
                <h2>Bath & Body</h2>
                <p>Indulge in moments of pure relaxation. Our bath salts and body oils transform ordinary evenings into
                    spa-like experiences, leaving your skin silky smooth and your mind completely at ease.</p>
            </div>
            <div class="box2" style="grid-area: box2">
                <h2>Facial Care</h2>
                <p>Your skin tells a story, and we're here to help you write the best chapters. From gentle cleansers to
                    powerful serums, each product works in harmony to reveal your most radiant self.</p>
            </div>
            <div class="box3" style="grid-area: box3">
                <h2>Wellness Rituals</h2>
                <p>Sometimes the greatest luxury is taking time for yourself. Our wellness collection helps you create
                    meaningful moments of self-care, whether it's a five-minute meditation or an hour-long pampering
                    session.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="snap-section testimonials-section" id="testimonials">
        <div class="testimonials-container">
            <!-- Section Header -->
            <div class="testimonials-header" data-gsap="fade-in">
                <h2>What Our Customers Say</h2>
                <p>Discover why thousands trust Mell Luxe for their luxury skincare needs</p>
            </div>

            <!-- Testimonials Grid -->
            <div class="testimonials-grid">
                <!-- Testimonial 1 -->
                <div class="testimonial-card" data-gsap="slide-left">
                    <div class="testimonial-content">
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <blockquote>
                            "I've tried countless vegan creams over the years, but nothing comes close to this one! It's
                            incredibly smooth, absorbs quickly, and leaves my skin feeling hydrated all day. Plus,
                            knowing it's cruelty-free and made with natural ingredients makes it even better."
                        </blockquote>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <span>BG</span>
                            </div>
                            <div class="author-info">
                                <h4>Bethany Gilford</h4>
                                <p>Verified Customer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card" data-gsap="slide-up">
                    <div class="testimonial-content">
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <blockquote>
                            "The 24k Gold Facial Elixir is pure luxury! My skin has never looked better. The packaging
                            is beautiful and the results are immediate. Worth every penny for this premium skincare
                            experience."
                        </blockquote>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <span>SM</span>
                            </div>
                            <div class="author-info">
                                <h4>Sarah Mitchell</h4>
                                <p>Verified Customer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card" data-gsap="slide-right">
                    <div class="testimonial-content">
                        <div class="stars">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <blockquote>
                            "Absolutely love the bath salts! They transform my evening routine into a spa-like
                            experience. The scent is divine and my skin feels so soft afterwards. Highly recommend for
                            anyone looking to treat themselves."
                        </blockquote>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <span>EM</span>
                            </div>
                            <div class="author-info">
                                <h4>Emma Robinson</h4>
                                <p>Verified Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="trust-indicators" data-gsap="fade-in">
                <div class="trust-stats">
                    <div class="stat-item">
                        <h3>100%</h3>
                        <p>Natural Ingredients</p>
                    </div>
                    <div class="stat-item">
                        <h3>Vegan</h3>
                        <p>& Cruelty-Free</p>
                    </div>
                    <div class="stat-item">
                        <h3>Eco</h3>
                        <p>Friendly Packaging</p>
                    </div>
                </div>
            </div>

            <!-- Special Offer Banner -->
            <div class="special-offer-banner" data-gsap="fade-in">
                <div class="offer-content">
                    <h3><?php echo $promo_title; ?></h3>
                    <p><?php echo $promo_text; ?></p>
                    <a href="<?php echo  esc_url(home_url('/product-category/all-products/')); ?>" class="offer-cta">
                        Shop Now <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top" aria-label="Back to top">
    <div class="btn-content">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 14L12 9L17 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <span class="btn-text">TOP</span>
    </div>
    <div class="btn-bg"></div>
</button>
<style>
    .story-cta{
        a{
            text-decoration: none;
        }
    }
</style>

<?php get_footer(); ?>