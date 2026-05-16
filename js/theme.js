/**
 * Mell Luxe Theme JavaScript
 * GSAP Animations and Interactive Features
 */

document.addEventListener('DOMContentLoaded', function () {

    // Register GSAP ScrollTrigger plugin
    gsap.registerPlugin(ScrollTrigger);

    // Initialize theme functions
    initMobileMenu();
    initScrollAnimations();
    initSnapScrolling();
    initHeroFrameSequence();
    initHeroSvgText();
    initContactForm();
    initBackToTop();
    initFloatingElements();
    initProductAnimations();
    initHeaderScroll();
    initProductShowcaseAnimations();
    initBestSectionSlider();
    initCartSidebar();
    initShopPageAnimations();
    initViewCartFix();
    initCartPage();
    initGetInTouchScroll();
    initMobileSearch();
    initCategoriesMenu();
    
    // Initialize cart count - call early and multiple times for Mac/Safari
    initCartCount();
    
    // Additional initialization for shop page and product category pages
    function initShopAndCategoryCartCount() {
        const isShopPage = document.querySelector('.woocommerce-shop, .woocommerce-page, .shop-page-container, .woocommerce');
        const isProductCategory = window.location.pathname.includes('/product-category/');
        
        if (isShopPage || isProductCategory) {
            // Multiple attempts to ensure cart count loads on shop/category pages
            const updateAttempts = [500, 1000, 2000, 3000, 5000];
            
            updateAttempts.forEach(function(delay) {
                setTimeout(function() {
                    if (typeof updateCartCountFromServer === 'function') {
                        updateCartCountFromServer();
                    }
                }, delay);
            });
            
            // Periodic refresh every 10 seconds for shop/category pages (ensures cart stays updated)
            const periodicRefresh = setInterval(function() {
                if (typeof updateCartCountFromServer === 'function') {
                    updateCartCountFromServer();
                }
            }, 10000);
            
            // Clear interval when user leaves the page
            window.addEventListener('beforeunload', function() {
                clearInterval(periodicRefresh);
            });
            
            // Also update when page becomes visible (user switches tabs)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden && (isShopPage || isProductCategory)) {
                    setTimeout(function() {
                        if (typeof updateCartCountFromServer === 'function') {
                            updateCartCountFromServer();
                        }
                    }, 500);
                }
            });
            
            // Update on scroll (some lazy loading scenarios)
            let scrollUpdateTimeout;
            window.addEventListener('scroll', function() {
                clearTimeout(scrollUpdateTimeout);
                scrollUpdateTimeout = setTimeout(function() {
                    if (typeof updateCartCountFromServer === 'function') {
                        updateCartCountFromServer();
                    }
                }, 1000);
            }, { once: false, passive: true });
            
            // Update when add to cart buttons are clicked (even if event doesn't fire)
            document.addEventListener('click', function(e) {
                const addToCartBtn = e.target.closest('.add_to_cart_button, .single_add_to_cart_button, button[type="submit"][name="add-to-cart"]');
                if (addToCartBtn && !addToCartBtn.classList.contains('disabled')) {
                    // Update cart count after add to cart (with multiple delays)
                    setTimeout(function() {
                        if (typeof updateCartCountFromServer === 'function') {
                            updateCartCountFromServer();
                        }
                    }, 800);
                    setTimeout(function() {
                        if (typeof updateCartCountFromServer === 'function') {
                            updateCartCountFromServer();
                        }
                    }, 2000);
                    setTimeout(function() {
                        if (typeof updateCartCountFromServer === 'function') {
                            updateCartCountFromServer();
                        }
                    }, 4000);
                }
            }, true);
        }
    }
    
    // Initialize shop/category cart count
    initShopAndCategoryCartCount();

    function initGetInTouchScroll() {
        const getInTouchButton = document.querySelector('.btn-secondary-about');
        const contactForm = document.querySelector('.contact-form-container');

        if (getInTouchButton && contactForm) {
            getInTouchButton.addEventListener('click', function (e) {
                e.preventDefault();
                contactForm.scrollIntoView({ behavior: 'smooth' });
            });
        }
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const overlay = document.querySelector('.mobile-menu-overlay');
        const menuLinks = document.querySelectorAll('.main-navigation .links a');

        if (menuToggle && navigation && overlay) {
            // Toggle mobile menu
            menuToggle.addEventListener('click', function () {
                const isActive = navigation.classList.contains('active');

                if (isActive) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });

            // Close menu when clicking overlay
            overlay.addEventListener('click', function () {
                closeMobileMenu();
            });

            // Close menu when clicking on menu links (except Categories)
            menuLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    // Don't close menu if clicking on Categories link
                    if (this.classList.contains('categories-toggle') || this.closest('.categories-menu')) {
                        return; // Let the categories menu handle its own behavior
                    }
                    closeMobileMenu();
                });
            });

            // Close menu on escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && navigation.classList.contains('active')) {
                    closeMobileMenu();
                }
            });

            // Handle window resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 992) {
                    closeMobileMenu();
                }
            });

            function openMobileMenu() {
                navigation.classList.add('active');
                menuToggle.classList.add('active');
                overlay.classList.add('active');
                menuToggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';

                // Focus trap
                const focusableElements = navigation.querySelectorAll('a, button, input, textarea, select');
                if (focusableElements.length > 0) {
                    focusableElements[0].focus();
                }
            }

            function closeMobileMenu() {
                navigation.classList.remove('active');
                menuToggle.classList.remove('active');
                overlay.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        }
    }

    /**
     * GSAP Scroll Animations
     */
    function initScrollAnimations() {
        
            gsap.utils.toArray('.fade-in').forEach(element => {
                gsap.from(element, {
                    opacity: 0,
                    duration: 1,
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });


            // Slide animations
            gsap.utils.toArray('.slide-up').forEach(element => {
                gsap.from(element, {
                    y: 50,
                    opacity: 0,
                    duration: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Slide left animations
            gsap.utils.toArray('.slide-left').forEach(element => {
                gsap.from(element, {
                    x: -50,
                    opacity: 0,
                    duration: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Slide right animations
            gsap.utils.toArray('.slide-right').forEach(element => {
                gsap.from(element, {
                    x: 50,
                    opacity: 0,
                    duration: 1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Scale in animations
            gsap.utils.toArray('.scale-in').forEach((element, index) => {
                const delay = element.dataset.delay || 0;

                gsap.from(element, {
                    scale: 0.8,
                    opacity: 0,
                    duration: 0.8,
                    delay: parseFloat(delay),
                    ease: 'back.out(1.7)',
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        end: 'bottom 20%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });
        
    }

    /**
     * Enhanced ScrollTrigger Animations
     */
    function initSnapScrolling() {
        // Simple scroll effects without problematic snap
        const snapSections = document.querySelectorAll('.snap-section');

        if (snapSections.length > 0) {
            snapSections.forEach((section, index) => {
                ScrollTrigger.create({
                    trigger: section,
                    start: 'top 80%',
                    end: 'bottom 20%',
                    onEnter: () => section.classList.add('in-view'),
                    onLeave: () => section.classList.remove('in-view')
                });
            });
        }
    }

    /**
     * Home page hero: full-width frame sequence, pinned until scrub completes (no ghosting — double buffer).
     */
    function initHeroFrameSequence() {
        var wrap = document.querySelector('#hero.hero-section--frames .hero-frame');
        if (!wrap) {
            return;
        }
        var raw = wrap.getAttribute('data-hero-frames');
        if (!raw) {
            return;
        }
        var frames;
        try {
            frames = JSON.parse(raw);
        } catch (e) {
            return;
        }
        if (!frames.length) {
            return;
        }
        var layers = wrap.querySelectorAll('.hero-frame-layer');
        if (layers.length < 2) {
            return;
        }
        var layerA = layers[0];
        var layerB = layers[1];
        var frontIsA = true;

        var current = -1;
        var swapGen = 0;

        function applyActiveLayer(showA) {
            wrap.setAttribute('data-active-layer', showA ? 'a' : 'b');
            frontIsA = showA;
        }

        function setFrame(index) {
            var idx = Math.max(0, Math.min(frames.length - 1, index));
            if (idx === current) {
                return;
            }
            if (current < 0 && idx === 0) {
                current = 0;
                applyActiveLayer(true);
                return;
            }
            var gen = ++swapGen;
            var url = frames[idx];
            var visibleEl = frontIsA ? layerA : layerB;
            var hiddenEl = frontIsA ? layerB : layerA;

            function swapIn() {
                if (gen !== swapGen) {
                    return;
                }
                current = idx;
                applyActiveLayer(hiddenEl === layerA);
            }

            function afterBitmapReady() {
                if (gen !== swapGen) {
                    return;
                }
                if (typeof hiddenEl.decode === 'function') {
                    hiddenEl.decode().then(swapIn).catch(swapIn);
                } else {
                    swapIn();
                }
            }

            hiddenEl.onload = null;
            hiddenEl.src = url;
            if (hiddenEl.complete && hiddenEl.naturalWidth > 0) {
                requestAnimationFrame(afterBitmapReady);
            } else {
                hiddenEl.onload = function () {
                    hiddenEl.onload = null;
                    afterBitmapReady();
                };
            }
        }

        var header = document.querySelector('.site-header');
        var headerOffset = header ? Math.round(header.getBoundingClientRect().height) : 80;
        var pinScrollVh = 5.5;

        function mountScroll() {
            ScrollTrigger.create({
                id: 'hero-frame-scrub',
                trigger: '#hero',
                start: function () {
                    return 'top ' + headerOffset + 'px';
                },
                end: function () {
                    return '+=' + window.innerHeight * pinScrollVh;
                },
                pin: true,
                pinSpacing: true,
                anticipatePin: 1,
                scrub: 1.15,
                invalidateOnRefresh: true,
                onUpdate: function (self) {
                    var max = frames.length - 1;
                    var idx = Math.round(self.progress * max);
                    setFrame(idx);
                }
            });
        }

        var pending = frames.length;
        frames.forEach(function (src) {
            var im = new Image();
            function done() {
                pending -= 1;
                if (pending === 0) {
                    mountScroll();
                    ScrollTrigger.refresh();
                }
            }
            im.onload = done;
            im.onerror = done;
            im.src = src;
        });
    }

    /**
     * Hero SVG headline: fade/slide with the same scroll range as the pinned frame scrub (when present).
     */
    function initHeroSvgText() {
        var svgRoot = document.querySelector('#hero .hero-svg-text');
        if (!svgRoot) {
            return;
        }
        var line1 = svgRoot.querySelector('.hero-svg-line--1');
        var line2 = svgRoot.querySelector('.hero-svg-line--2');
        if (!line1 || !line2) {
            return;
        }

        var header = document.querySelector('.site-header');
        var headerOffset = header ? Math.round(header.getBoundingClientRect().height) : 80;
        var pinScrollVh = 5.5;
        var hero = document.getElementById('hero');
        var hasFrames = hero && hero.classList.contains('hero-section--frames');

        gsap.set(line1, { opacity: 1, y: 0 });
        gsap.set(line2, { opacity: 1, y: 0 });

        gsap.timeline({
            scrollTrigger: {
                trigger: '#hero',
                start: 'top ' + headerOffset + 'px',
                end: function () {
                    if (hasFrames) {
                        return '+=' + window.innerHeight * pinScrollVh;
                    }
                    return 'bottom 75%';
                },
                scrub: 1.15,
                invalidateOnRefresh: true
            }
        })
            .to(line1, { opacity: 1, y: 0, duration: 0.45, ease: 'none' }, 0)
            .to(line2, { opacity: 1, y: 0, duration: 0.45, ease: 'none' }, 0.14);
    }

    /**
     * Contact Form AJAX
     */
    function initContactForm() {
        const contactForm = document.getElementById('contact-form');
        const responseDiv = document.getElementById('contact-response');

        if (contactForm && responseDiv) {
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(contactForm);
                formData.append('action', 'contact_form');
                formData.append('nonce', mellluxe_ajax.nonce);

                responseDiv.innerHTML = '<p>Sending message...</p>';

                fetch(mellluxe_ajax.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            responseDiv.innerHTML = '<p style="color: green;">' + data.data + '</p>';
                            contactForm.reset();
                        } else {
                            responseDiv.innerHTML = '<p style="color: red;">' + data.data + '</p>';
                        }
                    });
            });
        }
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTop = document.getElementById('back-to-top');

        if (backToTop) {
            // Show/hide button based on scroll position
            window.addEventListener('scroll', function () {
                if (window.scrollY > 400) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });

            // Smooth scroll to top when clicked
            backToTop.addEventListener('click', function (e) {
                e.preventDefault();

                // Add click animation
                backToTop.style.transform = 'translateY(0) scale(0.9)';

                // Smooth scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                // Reset animation after a short delay
                setTimeout(() => {
                    backToTop.style.transform = '';
                }, 200);
            });

            // Add keyboard accessibility
            backToTop.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    backToTop.click();
                }
            });
        }
    }

    /**
     * Floating Elements Animation
     */
    function initFloatingElements() {
        const floatingElements = document.querySelectorAll('.leaf-pattern');

        floatingElements.forEach((element, index) => {
            // Create floating animation
            gsap.to(element, {
                y: -20,
                rotation: 360,
                duration: 3 + index,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
                delay: index * 0.5
            });

            // Parallax effect on scroll
            gsap.to(element, {
                y: -100,
                ease: 'none',
                scrollTrigger: {
                    trigger: element,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        });
    }

    /**
     * Product Card Animations
     */
    function initProductAnimations() {
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            // Hover animations
            card.addEventListener('mouseenter', function () {
                gsap.to(this, {
                    y: -10,
                    scale: 1.02,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                gsap.to(this.querySelector('.product-image img'), {
                    scale: 1.1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            card.addEventListener('mouseleave', function () {
                gsap.to(this, {
                    y: 0,
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                gsap.to(this.querySelector('.product-image img'), {
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });
    }

    /**
     * Header Scroll Effects
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');

        if (header) {
            ScrollTrigger.create({
                start: 'top -100px',
                end: 99999,
                toggleClass: {
                    targets: header,
                    className: 'scrolled'
                }
            });
        }
    }

    /**
     * Smooth anchor scrolling
     */
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');

        anchorLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Validate href - must be a valid selector and not just "#"
                if (!href || href === '#' || !href.startsWith('#')) {
                    return; // Allow default behavior for invalid selectors
                }
                
                // Extract the selector (remove # if present)
                const selector = href.startsWith('#') ? href : '#' + href;
                
                // Validate selector is not just "#"
                if (selector === '#') {
                    return; // Allow default behavior
                }
                
                const target = document.querySelector(selector);

                if (target) {
                    e.preventDefault();

                    gsap.to(window, {
                        scrollTo: {
                            y: target,
                            offsetY: 80
                        },
                        duration: 1,
                        ease: 'power2.inOut'
                    });
                }
            });
        });
    }

    // Initialize smooth scrolling
    initSmoothScrolling();

    /**
     * WooCommerce AJAX Add to Cart
     */
    if (typeof wc_add_to_cart_params !== 'undefined') {
        document.body.addEventListener('added_to_cart', function (e) {
            // Add animation when product is added to cart
            const cartButton = e.target;
            if (cartButton) {
                gsap.to(cartButton, {
                    scale: 1.1,
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.inOut'
                });
            }
        });
    }

    /**
     * Intersection Observer for Performance
     */
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
            }
        });
    }, observerOptions);

    // Observe elements for animations
    const elementsToObserve = document.querySelectorAll('.fade-in, .slide-left, .slide-right, .gsap-animated');
    elementsToObserve.forEach(el => observer.observe(el));

    /**
     * Product Showcase Animations with GSAP
     */
    function initProductShowcaseAnimations() {

        // Check if GSAP is loaded
        if (typeof gsap === 'undefined') {
            console.log('GSAP not loaded, elements will remain visible');
            return;
        }

        // Animate description text
        const showcaseDescription = document.querySelector('.showcase-description');
        if (showcaseDescription) {
            showcaseDescription.classList.add('gsap-animated');
            gsap.fromTo(showcaseDescription, {
                opacity: 0,
                y: 50
            }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: showcaseDescription,
                    start: 'top 80%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                }
            });
        }

        // Enhanced animation handling for all GSAP elements
        const gsapElements = document.querySelectorAll('[data-gsap]');

        gsapElements.forEach((element, index) => {
            element.classList.add('gsap-animated');
            const animationType = element.getAttribute('data-gsap');
            let fromProps = { opacity: 0 };
            let toProps = {
                opacity: 1,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 85%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                }
            };

            // Set different animation properties based on data-gsap attribute
            switch (animationType) {
                case 'slide-left':
                    fromProps.x = -100;
                    toProps.x = 0;
                    toProps.delay = 0.1;
                    break;
                case 'slide-right':
                    fromProps.x = 100;
                    toProps.x = 0;
                    toProps.delay = 0.1;
                    break;
                case 'slide-up':
                    fromProps.y = 80;
                    toProps.y = 0;
                    toProps.delay = 0.2;
                    break;
                case 'fade-in':
                    fromProps.y = 30;
                    toProps.y = 0;
                    toProps.delay = 0.3;
                    break;
                case 'slide-bottom':
                    fromProps.y = 150;
                    toProps.y = 0;
                    toProps.duration = 1.2;
                    toProps.delay = 0.4;
                    break;
                case 'slide-left-delay':
                    fromProps.x = -100;
                    toProps.x = 0;
                    toProps.delay = 0.5;
                    break;
                case 'slide-right-delay':
                    fromProps.x = 100;
                    toProps.x = 0;
                    toProps.delay = 0.5;
                    break;
                case 'slide-up-delay':
                    fromProps.y = 80;
                    toProps.y = 0;
                    toProps.delay = 0.6;
                    break;
            }

            gsap.fromTo(element, fromProps, toProps);
        });

        // Add hover animations for product items
        const showcaseProducts = document.querySelectorAll('.showcase-product-item');
        showcaseProducts.forEach(product => {
            const image = product.querySelector('.showcase-product-image');

            product.addEventListener('mouseenter', function () {
                gsap.to(this, {
                    y: -15,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                if (image) {
                    gsap.to(image, {
                        scale: 1.1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                }
            });

            product.addEventListener('mouseleave', function () {
                gsap.to(this, {
                    y: 0,
                    duration: 0.3,
                    ease: 'power2.out'
                });

                if (image) {
                    gsap.to(image, {
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                }
            });
        });

        // Animate the shop button with bounce effect
        const shopButton = document.querySelector('.showcase-shop-button');
        if (shopButton) {
            shopButton.addEventListener('mouseenter', function () {
                gsap.to(this, {
                    scale: 1.05,
                    y: -3,
                    duration: 0.3,
                    ease: 'back.out(1.7)'
                });
            });

            shopButton.addEventListener('mouseleave', function () {
                gsap.to(this, {
                    scale: 1,
                    y: 0,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        }

        // Special animation for strips image with parallax effect
        const stripsImage = document.querySelector('.strips-image');
        if (stripsImage) {
            // Parallax scroll effect for strips
            gsap.to(stripsImage, {
                y: -50,
                ease: 'none',
                scrollTrigger: {
                    trigger: stripsImage,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1
                }
            });
        }
    }

    /**
     * Fix for WooCommerce "View cart" link
     */
    function initViewCartFix() {
        // This new version directly handles the click on the 'View cart' link
        // to ensure navigation happens, overriding any other scripts that might
        // be trying to prevent it.
        jQuery(document).on('click', '.added_to_cart', function (e) {
            // Prevent other scripts from interfering.
            e.preventDefault();
            e.stopImmediatePropagation();

            const cartUrl = jQuery(this).attr('href');
            if (cartUrl) {
                // Force the browser to navigate to the cart page.
                window.location.href = cartUrl;
            }
            return false;
        });
    }
});

/**
 * Best Section Product Slider
 */
function initBestSectionSlider() {
    const mainImg = document.getElementById('mainProductImg');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (!mainImg || !thumbnails.length || !prevBtn || !nextBtn) {
        return; // Exit if elements don't exist
    }

    let currentIndex = 0;
    const totalImages = thumbnails.length;

    // Function to update the main image and active thumbnail
    function updateSlider(index) {
        if (index < 0) index = totalImages - 1;
        if (index >= totalImages) index = 0;

        currentIndex = index;

        // Update main image with fade effect
        mainImg.style.opacity = '0';

        setTimeout(() => {
            const newImageSrc = thumbnails[currentIndex].getAttribute('data-img');
            const newAltText = thumbnails[currentIndex].querySelector('img').alt;
            const newLink = thumbnails[currentIndex].querySelector('a').href;
            document.querySelector('.main-product-image').querySelector('a').href = newLink;
            mainImg.src = newImageSrc;
            mainImg.alt = newAltText;
            mainImg.style.opacity = '1';
        }, 150);

        // Update active thumbnail
        thumbnails.forEach((thumb, i) => {
            if (i === currentIndex) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
    }

    // Navigation arrow event listeners
    prevBtn.addEventListener('click', function () {
        updateSlider(currentIndex - 1);
    });

    nextBtn.addEventListener('click', function () {
        updateSlider(currentIndex + 1);
    });

    // Thumbnail click event listeners
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function () {
            updateSlider(index);
        });
    });

    // Auto-play slider (optional)
    let autoplayInterval;

    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            updateSlider(currentIndex + 1);
        }, 5000); // Change image every 5 seconds
    }

    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }

    // Start autoplay
    startAutoplay();

    // Pause autoplay on hover
    const sliderSection = document.querySelector('.product-slider-section');
    if (sliderSection) {
        sliderSection.addEventListener('mouseenter', stopAutoplay);
        sliderSection.addEventListener('mouseleave', startAutoplay);
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (document.querySelector('#best:hover')) {
            if (e.key === 'ArrowLeft') {
                updateSlider(currentIndex - 1);
            } else if (e.key === 'ArrowRight') {
                updateSlider(currentIndex + 1);
            }
        }
    });

    // Add smooth transition to main image
    mainImg.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

    // Add loading state
    mainImg.addEventListener('load', function () {
        this.style.opacity = '1';
    });

    // Preload images for better performance
    thumbnails.forEach(thumbnail => {
        const img = new Image();
        img.src = thumbnail.getAttribute('data-img');
    });
}

/**
 * Additional utility functions
 */

// Debounce function for performance
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        const later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Cart Sidebar Functionality
function initCartSidebar() {
    const cartToggle = document.getElementById('cart-toggle');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartSidebarClose = document.getElementById('cart-sidebar-close');
    const cartSidebarOverlay = document.getElementById('cart-sidebar-overlay');
    const cartSidebarBody = document.getElementById('cart-sidebar-body');

    if (!cartToggle || !cartSidebar) return;

    // Open cart sidebar
    cartToggle.addEventListener('click', function (e) {
        e.preventDefault();
        
        // Refresh cart count if on product category page or shop page
        const currentPath = window.location.pathname;
        const isProductCategory = currentPath.includes('/product-category/');
        const isShopPage = currentPath.includes('/shop') || document.querySelector('.woocommerce-shop, .woocommerce-page');
        
        if (isProductCategory || isShopPage) {
            // Force refresh cart count before opening sidebar
            if (typeof updateCartCountFromServer === 'function') {
                updateCartCountFromServer();
            }
        }
        
        openCartSidebar();
    });

    // Close cart sidebar
    function closeCartSidebar() {
        cartSidebar.classList.remove('active');
        document.body.classList.remove('cart-sidebar-open');
    }

    // Open cart sidebar
    function openCartSidebar() {
        cartSidebar.classList.add('active');
        document.body.classList.add('cart-sidebar-open');
        loadCartContent();
    }

    // Close events
    if (cartSidebarClose) {
        cartSidebarClose.addEventListener('click', closeCartSidebar);
    }

    if (cartSidebarOverlay) {
        cartSidebarOverlay.addEventListener('click', closeCartSidebar);
    }

    // Close on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && cartSidebar.classList.contains('active')) {
            closeCartSidebar();
        }
    });

    // Load cart content via AJAX
    function loadCartContent() {
        if (!cartSidebarBody) return;

        cartSidebarBody.innerHTML = '<div class="cart-loading"><p>Loading cart...</p></div>';

        // Refresh cart count before loading cart content (important for shop/category pages)
        if (typeof updateCartCountFromServer === 'function') {
            updateCartCountFromServer();
        }

        // Build request with error handling for 403 errors
        const requestBody = new URLSearchParams({
            action: 'get_cart_contents'
        });
        
        // Add nonce if available
        if (mellluxe_ajax.nonce) {
            requestBody.append('nonce', mellluxe_ajax.nonce);
        }
        
        fetch(mellluxe_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: requestBody,
            credentials: 'same-origin'
        })
            .then(response => {
                // Handle 403 errors specifically
                if (response.status === 403) {
                    console.warn('Cart contents request forbidden (403)');
                    cartSidebarBody.innerHTML = '<div class="cart-empty"><p>Unable to load cart. Please refresh the page.</p></div>';
                    // Try to use server-side count
                    useServerSideCartCount();
                    throw new Error('403 Forbidden');
                }
                
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    cartSidebarBody.innerHTML = data.data.html;
                    updateCartTotal(data.data.total);
                    
                    // Update cart count from cart contents response
                    if (data.data.cart_count !== undefined) {
                        updateCartCount(data.data.cart_count);
                    }
                    
                    initCartItemEvents();
                } else {
                    cartSidebarBody.innerHTML = '<div class="cart-empty"><p>Your cart is empty</p></div>';
                    // Update count to 0 if cart is empty
                    updateCartCount(0);
                }
            })
            .catch(error => {
                console.error('Error loading cart:', error);
                if (!error.message.includes('403')) {
                    cartSidebarBody.innerHTML = '<div class="cart-empty"><p>Error loading cart</p></div>';
                }
            });
    }

    // Update cart total
    function updateCartTotal(total) {
        const cartTotalAmount = document.getElementById('cart-total-amount');
        if (cartTotalAmount) {
            cartTotalAmount.innerHTML = total;
        }
    }

    // Initialize cart item events (remove, quantity change)
    function initCartItemEvents() {
        // Remove item buttons
        const removeButtons = cartSidebarBody.querySelectorAll('.cart-item-remove');
        removeButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const cartKey = this.dataset.cartKey;
                removeCartItem(cartKey);
            });
        });

        // Quantity change buttons
        const quantityBtns = cartSidebarBody.querySelectorAll('.quantity-btn');
        quantityBtns.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const cartKey = this.dataset.cartKey;
                const action = this.dataset.action;
                const currentQty = parseInt(this.parentNode.querySelector('.quantity-input').value);

                let newQty = currentQty;
                if (action === 'increase') {
                    newQty = currentQty + 1;
                } else if (action === 'decrease' && currentQty > 1) {
                    newQty = currentQty - 1;
                }

                if (newQty !== currentQty) {
                    updateCartItemQuantity(cartKey, newQty);
                }
            });
        });
    }

    // Remove cart item
    function removeCartItem(cartKey) {
        fetch(mellluxe_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'remove_cart_item',
                cart_key: cartKey,
                nonce: mellluxe_ajax.nonce
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartContent(); // Reload cart content
                    updateCartCount(data.data.cart_count);
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
            });
    }

    // Update cart item quantity
    function updateCartItemQuantity(cartKey, quantity) {
        fetch(mellluxe_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'update_cart_item_quantity',
                cart_key: cartKey,
                quantity: quantity,
                nonce: mellluxe_ajax.nonce
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCartContent(); // Reload cart content
                    updateCartCount(data.data.cart_count);
                }
            })
            .catch(error => {
                console.error('Error updating quantity:', error);
            });
    }

    // Update cart count in header
    function updateCartCount(count) {
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            if (count > 0) {
                cartCount.textContent = count;
                cartCount.style.display = 'flex';
                cartCount.classList.add('updating');
                setTimeout(() => {
                    cartCount.classList.remove('updating');
                }, 600);
            } else {
                cartCount.style.display = 'none';
            }
        } else {
            // Create cart count element if it doesn't exist
            const cartIcon = document.querySelector('.cart-icon');
            if (cartIcon && count > 0) {
                const newCartCount = document.createElement('span');
                newCartCount.className = 'cart-count';
                newCartCount.id = 'cart-count';
                newCartCount.textContent = count;
                newCartCount.style.display = 'flex';
                cartIcon.appendChild(newCartCount);
            }
        }
    }
}

// Function to update cart count badge directly (preserves cart icon)
function updateCartCountBadge(count) {
    const cartIcon = document.querySelector('.cart-icon');
    if (!cartIcon) {
        console.warn('Cart icon not found');
        return;
    }
    
    let cartCount = document.getElementById('cart-count');
    
    // Create cart count element if it doesn't exist (but preserve the icon)
    if (!cartCount && cartIcon) {
        cartCount = document.createElement('span');
        cartCount.className = 'cart-count';
        cartCount.id = 'cart-count';
        // Append to cart icon (after the SVG, not replacing it)
        cartIcon.appendChild(cartCount);
    }
    
    if (cartCount) {
        if (count > 0) {
            cartCount.textContent = count;
            cartCount.style.display = 'flex';
            cartCount.classList.add('updating');
            setTimeout(() => {
                cartCount.classList.remove('updating');
            }, 600);
        } else {
            cartCount.style.display = 'none';
        }
    } else {
        console.warn('Cart count element not found and could not be created');
    }
}

// Function to update cart count from server (global scope for event listeners)
// Enhanced for Mac/Safari compatibility
function updateCartCountFromServer() {
    if (typeof mellluxe_ajax === 'undefined') {
        console.warn('mellluxe_ajax not available for cart count update');
        return;
    }
    
    const cartIcon = document.querySelector('.cart-icon');
    if (!cartIcon) {
        // Don't fail silently - this is important for Mac/Safari
        console.warn('Cart icon not found, cannot update cart count');
        return;
    }
    
    // Detect Mac/Safari for special handling
    const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
    const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    
    // Build request data
    const requestData = new URLSearchParams({
        action: 'get_cart_count',
        nonce: mellluxe_ajax.nonce || ''
    });
    
    // Use fetch API with enhanced error handling for Mac/Safari
    if (typeof fetch !== 'undefined') {
        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: requestData,
            // Add credentials for Mac/Safari cookie handling
            credentials: 'same-origin',
            cache: 'no-cache'
        };
        
        fetch(mellluxe_ajax.ajax_url, requestOptions)
            .then(response => {
                // Handle 403 errors specifically
                if (response.status === 403) {
                    console.warn('Cart count request forbidden (403) - using fallback');
                    useServerSideCartCount();
                    throw new Error('403 Forbidden - using server-side count');
                }
                
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    const count = parseInt(data.data.cart_count) || 0;
                    updateCartCountBadge(count);
                } else {
                    console.warn('Cart count update returned unsuccessful:', data);
                    // Always use server-side rendered count as fallback
                    useServerSideCartCount();
                }
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
                // Always use fallback on error
                useServerSideCartCount();
                
                // Retry only if it's not a 403 error
                if (!error.message.includes('403')) {
                    if (isMac || isSafari) {
                        updateCartCountViaXHR();
                    } else {
                        setTimeout(updateCartCountFromServer, 1000);
                    }
                }
            });
    } else {
        // Fallback for older browsers using XMLHttpRequest
        updateCartCountViaXHR();
    }
    
    // XMLHttpRequest fallback function
    function updateCartCountViaXHR() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', mellluxe_ajax.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.withCredentials = true; // Important for Mac/Safari
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        if (data && data.success) {
                            const count = parseInt(data.data.cart_count) || 0;
                            updateCartCountBadge(count);
                        } else {
                            useServerSideCartCount();
                        }
                    } catch (e) {
                        console.error('Error parsing cart count response:', e);
                        useServerSideCartCount();
                    }
                } else {
                    console.error('XHR failed with status:', xhr.status);
                    useServerSideCartCount();
                }
            }
        };
        
        xhr.send(requestData.toString());
    }
    
    // Fallback: Use server-side rendered count (important for Mac/Safari)
    function useServerSideCartCount() {
        const existingCount = document.getElementById('cart-count');
        if (existingCount) {
            // Try data attribute first (more reliable)
            let serverCount = parseInt(existingCount.getAttribute('data-cart-count')) || 0;
            // Fallback to text content
            if (serverCount === 0) {
                serverCount = parseInt(existingCount.textContent.trim()) || 0;
            }
            if (serverCount > 0) {
                updateCartCountBadge(serverCount);
            }
        }
        
        // Also try WooCommerce cart object if available (Mac/Safari specific)
        if (typeof wc_add_to_cart_params !== 'undefined' && typeof jQuery !== 'undefined') {
            try {
                jQuery(document.body).trigger('wc_update_cart');
            } catch (e) {
                console.warn('Could not trigger WooCommerce cart update:', e);
            }
        }
    }
}

// Enhanced WooCommerce event listeners for cross-browser compatibility
(function() {
    // Wait for both jQuery and WooCommerce to be ready
    function setupCartUpdateListeners() {
        // Intercept add to cart button clicks for immediate feedback
        document.addEventListener('click', function(e) {
            const addToCartBtn = e.target.closest('.add_to_cart_button, .single_add_to_cart_button, button[type="submit"][name="add-to-cart"]');
            if (addToCartBtn && !addToCartBtn.classList.contains('disabled')) {
                // Update cart count after a short delay to allow WooCommerce to process
                setTimeout(function() {
                    updateCartCountFromServer();
                }, 500);
                
                // Also update again after a longer delay as fallback
                setTimeout(function() {
                    updateCartCountFromServer();
                }, 1500);
            }
        }, true);
        
        // jQuery-based listeners (WooCommerce standard)
        if (typeof jQuery !== 'undefined') {
            // Listen for add to cart event - PRIMARY METHOD
            jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
                // Update immediately from fragments if available
                if (fragments && fragments['#cart-count']) {
                    const fragmentHTML = fragments['#cart-count'];
                    const cartCount = document.getElementById('cart-count');
                    const cartIcon = document.querySelector('.cart-icon');
                    
                    if (cartCount && cartIcon) {
                        // Only update the innerHTML/text, don't replace the entire element
                        // Parse the fragment to get just the text content
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = fragmentHTML;
                        const newCartCount = tempDiv.querySelector('#cart-count') || tempDiv.querySelector('.cart-count');
                        
                        if (newCartCount) {
                            // Update the count text and visibility
                            const count = newCartCount.textContent.trim();
                            const countNum = parseInt(count) || 0;
                            
                            cartCount.textContent = count;
                            if (countNum > 0) {
                                cartCount.style.display = 'flex';
                                cartCount.classList.add('updating');
                                setTimeout(() => {
                                    cartCount.classList.remove('updating');
                                }, 600);
                            } else {
                                cartCount.style.display = 'none';
                            }
                        }
                    } else if (cartIcon && !cartCount) {
                        // Cart count doesn't exist, create it
                        cartIcon.insertAdjacentHTML('beforeend', fragmentHTML);
                        const newCartCount = document.getElementById('cart-count');
                        if (newCartCount) {
                            newCartCount.classList.add('updating');
                            setTimeout(() => {
                                newCartCount.classList.remove('updating');
                            }, 600);
                        }
                    } else {
                        // Fallback: fetch from server
                        updateCartCountFromServer();
                    }
                } else {
                    // Fallback: fetch from server immediately
                    updateCartCountFromServer();
                }
                
                // Double-check after a delay
                setTimeout(function() {
                    updateCartCountFromServer();
                }, 1000);
            });
            
            // Listen for fragment refresh (WooCommerce built-in)
            jQuery(document.body).on('wc_fragment_refresh wc_fragments_refreshed', function(event, fragments) {
                if (fragments && fragments['#cart-count']) {
                    const fragmentHTML = fragments['#cart-count'];
                    const cartCount = document.getElementById('cart-count');
                    const cartIcon = document.querySelector('.cart-icon');
                    
                    if (cartCount && cartIcon) {
                        // Only update content, not replace element
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = fragmentHTML;
                        const newCartCount = tempDiv.querySelector('#cart-count') || tempDiv.querySelector('.cart-count');
                        
                        if (newCartCount) {
                            const count = newCartCount.textContent.trim();
                            const countNum = parseInt(count) || 0;
                            
                            cartCount.textContent = count;
                            if (countNum > 0) {
                                cartCount.style.display = 'flex';
                            } else {
                                cartCount.style.display = 'none';
                            }
                        }
                    } else if (cartIcon && !cartCount) {
                        cartIcon.insertAdjacentHTML('beforeend', fragmentHTML);
                    } else {
                        updateCartCountFromServer();
                    }
                } else {
                    updateCartCountFromServer();
                }
            });
            
            // Listen for cart updates
            jQuery(document.body).on('updated_wc_div updated_cart_totals', function() {
                updateCartCountFromServer();
            });
            
            // Listen for cart item removed
            jQuery(document.body).on('removed_from_cart', function() {
                updateCartCountFromServer();
            });
            
            // Intercept WooCommerce AJAX add to cart
            jQuery(document).on('submit', 'form.cart, form.woocommerce-cart-form', function(e) {
                const form = jQuery(this);
                if (form.find('input[name="add-to-cart"]').length || form.find('button[type="submit"][name="add-to-cart"]').length) {
                    // This is an add to cart form
                    setTimeout(function() {
                        updateCartCountFromServer();
                    }, 500);
                    setTimeout(function() {
                        updateCartCountFromServer();
                    }, 1500);
                }
            });
        }
        
        // Also listen for native DOM events as fallback
        document.body.addEventListener('added_to_cart', function(event) {
            updateCartCountFromServer();
        });
        
        // Listen for custom events that might be triggered
        window.addEventListener('cart_updated', function() {
            updateCartCountFromServer();
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupCartUpdateListeners);
    } else {
        setupCartUpdateListeners();
    }
    
    // Also set up when jQuery is ready (if available)
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(setupCartUpdateListeners);
    }
    
    // Force update on page visibility change (user switches tabs/windows)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            // Page became visible, refresh cart count
            updateCartCountFromServer();
        }
    });
})();

// Initialize cart count on page load - Enhanced for Mac/Safari compatibility
function initCartCount() {
    // Update cart count when page loads
    if (typeof mellluxe_ajax === 'undefined') {
        console.warn('mellluxe_ajax not defined, cart count initialization skipped');
        return;
    }
    
    // Detect if we're on Mac/Safari
    const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
    const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    
    // Wait for DOM and WooCommerce to be ready
    function doInit(attempt = 1) {
        const maxAttempts = isMac || isSafari ? 5 : 3; // More attempts for Mac/Safari
        
        // Check if we're on shop page or product category
        const isShopPage = document.querySelector('.woocommerce-shop, .woocommerce-page, .shop-page-container, .woocommerce');
        const isProductCategory = window.location.pathname.includes('/product-category/');
        
        // First, check if cart count is already in the DOM (from server-side render)
        const existingCount = document.getElementById('cart-count');
        const cartIcon = document.querySelector('.cart-icon');
        
        if (!cartIcon) {
            if (attempt < maxAttempts) {
                // Retry if cart icon not found (common on Mac/Safari)
                setTimeout(() => doInit(attempt + 1), 500);
            }
            return;
        }
        
        if (existingCount) {
            // Try data attribute first (more reliable)
            let serverCount = parseInt(existingCount.getAttribute('data-cart-count')) || 0;
            if (serverCount === 0) {
                serverCount = parseInt(existingCount.textContent.trim()) || 0;
            }
            
            if (serverCount > 0) {
                // Already has count from server, ensure it's visible
                existingCount.style.display = 'flex';
                existingCount.textContent = serverCount;
            }
        }
        
        // Always update from server to ensure accuracy (especially important for shop/category pages and Mac/Safari)
        if (isShopPage || isProductCategory) {
            // More aggressive updates for shop/category pages
            updateCartCountFromServer();
            setTimeout(() => updateCartCountFromServer(), 1000);
            setTimeout(() => updateCartCountFromServer(), 2000);
        } else {
            updateCartCountFromServerWithRetry(attempt, maxAttempts);
        }
    }
    
    // Multiple initialization attempts for Mac/Safari
    function updateCartCountFromServerWithRetry(attempt, maxAttempts) {
        updateCartCountFromServer();
        
        // Retry for Mac/Safari if first attempt fails
        if ((isMac || isSafari) && attempt < maxAttempts) {
            setTimeout(() => {
                updateCartCountFromServer();
            }, 1000 * attempt); // Staggered retries
        }
    }
    
    // Wait for DOM to be ready - multiple strategies for Mac/Safari
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => doInit(1), isMac || isSafari ? 500 : 300);
        });
    } else {
        setTimeout(() => doInit(1), isMac || isSafari ? 500 : 300);
    }
    
    // Also update when jQuery/WooCommerce is ready
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function() {
            setTimeout(() => doInit(1), isMac || isSafari ? 800 : 500);
        });
        
        // Additional check for WooCommerce being ready (important for Mac)
        if (typeof wc_add_to_cart_params !== 'undefined') {
            setTimeout(() => doInit(1), 1000);
        }
    }
    
    // Force update after page is fully loaded (Mac/Safari specific)
    if (isMac || isSafari) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                updateCartCountFromServer();
            }, 1500);
        });
    }
}

/**
 * Shop Page Animations
 */
function initShopPageAnimations() {
    // Only run on shop page
    if (!document.querySelector('.shop-page-container')) {
        return;
    }

    // Shop Hero Animations
    gsap.timeline()
        .from('.shop-hero-title', {
            y: 50,
            opacity: 0,
            duration: 1,
            ease: 'power2.out'
        })
        .from('.shop-hero-subtitle', {
            y: 30,
            opacity: 0,
            duration: 0.8,
            ease: 'power2.out'
        }, '-=0.5')
        .from('.category-item', {
            y: 30,
            opacity: 0,
            duration: 0.6,
            stagger: 0.2,
            ease: 'back.out(1.7)'
        }, '-=0.3')
        .from('.hero-product-showcase', {
            x: 50,
            opacity: 0,
            duration: 1,
            ease: 'power2.out'
        }, '-=0.8');

    // Trust Indicators Animation
    gsap.from('.trust-item', {
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        ease: 'power2.out',
        scrollTrigger: {
            trigger: '.shop-trust-section',
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse'
        }
    });

    // Collections Animation
    gsap.from('.collection-item', {
        scale: 0.8,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        ease: 'back.out(1.7)',
        scrollTrigger: {
            trigger: '.collections-grid',
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse'
        }
    });

    // Enhanced Product Grid Animations
    gsap.from('.woocommerce .product', {
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: 'power2.out',
        scrollTrigger: {
            trigger: '.products',
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse'
        }
    });

    // Category hover interactions
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        item.addEventListener('mouseenter', function () {
            gsap.to(this, {
                scale: 1.05,
                duration: 0.3,
                ease: 'power2.out'
            });
        });

        item.addEventListener('mouseleave', function () {
            gsap.to(this, {
                scale: 1,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
    });

    // Collection overlay animations
    const collectionItems = document.querySelectorAll('.collection-item');
    collectionItems.forEach(item => {
        const overlay = item.querySelector('.collection-overlay');
        const image = item.querySelector('.collection-image img');

        item.addEventListener('mouseenter', function () {
            gsap.to(image, {
                scale: 1.1,
                duration: 0.5,
                ease: 'power2.out'
            });
        });

        item.addEventListener('mouseleave', function () {
            gsap.to(image, {
                scale: 1,
                duration: 0.5,
                ease: 'power2.out'
            });
        });
    });

    // Product sorting functionality
    const sortSelect = document.getElementById('product-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const value = this.value;
            // Add loading animation
            const productsGrid = document.querySelector('.woocommerce .products');
            if (productsGrid) {
                gsap.to(productsGrid, {
                    opacity: 0.5,
                    duration: 0.3,
                    onComplete: function () {
                        // Trigger WooCommerce sorting
                        const url = new URL(window.location);
                        url.searchParams.set('orderby', value);
                        window.location.href = url.toString();
                    }
                });
            }
        });
    }
}

function initCartPage() {
    const cartPage = document.querySelector('.cart-page-container');
    if (!cartPage) return;

    const updateCartButton = cartPage.querySelector('.update-cart-button');

    // Handle custom quantity buttons using CSS pseudo-elements
    cartPage.addEventListener('click', function (e) {
        const productQuantity = e.target.closest('.product-quantity');
        if (!productQuantity) return;

        const rect = productQuantity.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const input = productQuantity.querySelector('input[type="number"]');

        if (!input) return;

        let currentValue = parseInt(input.value, 10) || 0;

        // Check if click is on the minus button (left side)
        if (clickX <= 35) {
            currentValue = Math.max(0, currentValue - 1);
            input.value = currentValue;
        }
        // Check if click is on the plus button (right side)  
        else if (clickX >= rect.width - 35) {
            currentValue++;
            input.value = currentValue;
        }
        else {
            return; // Click was on the input itself
        }

        // Trigger change event for WooCommerce
        const changeEvent = new Event('change', { bubbles: true });
        input.dispatchEvent(changeEvent);

        // Enable update button
        if (updateCartButton) {
            updateCartButton.disabled = false;
        }
    });

    // Enable update button when quantity changes manually
    cartPage.addEventListener('change', function (e) {
        if (e.target.type === 'number') {
            if (updateCartButton) {
                updateCartButton.disabled = false;
            }
        }
    });

    // Handle input focus/blur for better UX
    cartPage.addEventListener('focus', function (e) {
        if (e.target.type === 'number') {
            e.target.select();
        }
    }, true);

    // For AJAX based themes, we might need to re-init this
    document.body.addEventListener('updated_cart_totals', initCartPage);
}

// Debug function to check if AJAX variables are available
console.log('AJAX Variables:', window.mellluxe_ajax);

/**
 * Mobile Search Functionality
 */
function initMobileSearch() {
    const searchToggle = document.querySelector('.mobile-search-toggle');
    const searchModal = document.querySelector('.mobile-search-modal');
    const searchOverlay = document.querySelector('.mobile-search-overlay');
    const searchCancel = document.querySelector('.mobile-search-cancel');
    const searchField = document.querySelector('.mobile-search-field');
    const searchTags = document.querySelectorAll('.search-tag');
    const searchResults = document.querySelector('#mobile-search-results');
    const searchForm = document.querySelector('.mobile-search-form');

    if (!searchToggle || !searchModal) {
        console.log('Search elements not found:', {
            searchToggle: !!searchToggle,
            searchModal: !!searchModal
        });
        return;
    }
    
    console.log('Mobile search initialized successfully');

    // Open search modal
    searchToggle.addEventListener('click', function() {
        openSearchModal();
    });

    // Close search modal
    function closeSearchModal() {
        searchModal.classList.remove('active');
        searchToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        searchField.value = '';
        searchResults.innerHTML = '';
        
        // Focus trap
        searchToggle.focus();
    }

    function openSearchModal() {
        searchModal.classList.add('active');
        searchToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        
        // Focus on search field
        setTimeout(() => {
            searchField.focus();
        }, 300);
    }

    // Close on overlay click
    if (searchOverlay) {
        searchOverlay.addEventListener('click', closeSearchModal);
    }

    // Close on cancel button
    if (searchCancel) {
        searchCancel.addEventListener('click', closeSearchModal);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchModal.classList.contains('active')) {
            closeSearchModal();
        }
    });

    // Handle search tag clicks
    searchTags.forEach(tag => {
        tag.addEventListener('click', function() {
            const searchTerm = this.getAttribute('data-search');
            searchField.value = searchTerm;
            performSearch(searchTerm);
        });
    });

    // Handle search input
    let searchTimeout;
    searchField.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        } else {
            searchResults.innerHTML = '';
        }
    });

    // Handle form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const query = searchField.value.trim();
            if (query) {
                // Submit the form to WordPress search
                this.submit();
            }
        });
    }

    // Perform AJAX search
    function performSearch(query) {
        if (!query || query.length < 2) return;

        searchResults.innerHTML = '<div class="search-loading">Searching...</div>';

        // Create form data
        const formData = new FormData();
        formData.append('action', 'mellluxe_search_products');
        formData.append('query', query);
        formData.append('nonce', mellluxe_ajax.nonce);

        // Send AJAX request
        fetch(mellluxe_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySearchResults(data.data);
            } else {
                searchResults.innerHTML = '<div class="search-error">No products found</div>';
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            searchResults.innerHTML = '<div class="search-error">Search failed</div>';
        });
    }

    // Display search results
    function displaySearchResults(products) {
        if (!products || products.length === 0) {
            searchResults.innerHTML = '<div class="search-no-results">No products found</div>';
            return;
        }

        let html = '';
        products.forEach(product => {
            html += `
                <div class="search-result-item">
                    <img src="${product.image}" alt="${product.name}" class="search-result-image">
                    <div class="search-result-details">
                        <h4>${product.name}</h4>
                        <p>${product.short_description}</p>
                    </div>
                    <div class="search-result-price">${product.price}</div>
                </div>
            `;
        });

        searchResults.innerHTML = html;

        // Add click handlers to results
        const resultItems = searchResults.querySelectorAll('.search-result-item');
        resultItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                window.location.href = products[index].url;
            });
        });
    }
}

/**
 * Categories Menu Functionality
 */
function initCategoriesMenu() {
    const categoriesMenu = document.querySelector('.categories-menu');
    const categoriesToggle = document.querySelector('.categories-toggle');
    const categoriesDropdown = document.querySelector('.categories-dropdown');

    if (!categoriesMenu || !categoriesToggle || !categoriesDropdown) {
        return;
    }

    // Check if we're on mobile
    function isMobile() {
        return window.innerWidth <= 991;
    }

    // Toggle categories dropdown
    function toggleCategories() {
        const isActive = categoriesMenu.classList.contains('active');
        
        if (isActive) {
            categoriesMenu.classList.remove('active');
        } else {
            categoriesMenu.classList.add('active');
        }
    }

    // Handle click events
    categoriesToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent event bubbling to parent menu
        toggleCategories();
    });

    // Desktop hover behavior
    function setupDesktopBehavior() {
        if (!isMobile()) {
            categoriesMenu.addEventListener('mouseenter', function() {
                categoriesDropdown.style.opacity = '1';
                categoriesDropdown.style.visibility = 'visible';
            });

            categoriesMenu.addEventListener('mouseleave', function() {
                categoriesDropdown.style.opacity = '0';
                categoriesDropdown.style.visibility = 'hidden';
            });
        }
    }

    // Setup initial behavior
    setupDesktopBehavior();

    // Handle keyboard navigation
    categoriesToggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleCategories();
        }
        
        if (e.key === 'Escape') {
            categoriesMenu.classList.remove('active');
            if (!isMobile()) {
                categoriesDropdown.style.opacity = '0';
                categoriesDropdown.style.visibility = 'hidden';
            }
        }
    });

    // Close dropdown when clicking outside (desktop only)
    if (!isMobile()) {
        document.addEventListener('click', function(e) {
            if (!categoriesMenu.contains(e.target)) {
                categoriesDropdown.style.opacity = '0';
                categoriesDropdown.style.visibility = 'hidden';
            }
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        // Reset categories state when switching between mobile/desktop
        categoriesMenu.classList.remove('active');
        
        if (!isMobile()) {
            // Desktop mode - reset dropdown styles
            categoriesDropdown.style.opacity = '0';
            categoriesDropdown.style.visibility = 'hidden';
            setupDesktopBehavior();
        } else {
            // Mobile mode - remove desktop hover listeners
            categoriesMenu.removeEventListener('mouseenter', arguments.callee);
            categoriesMenu.removeEventListener('mouseleave', arguments.callee);
        }
    });

    // Add smooth transitions to category links (desktop only)
    if (!isMobile()) {
        const categoryLinks = categoriesDropdown.querySelectorAll('.category-link');
        categoryLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    }

    // Close mobile menu when category link is clicked (mobile only)
    const categoryLinks = categoriesDropdown.querySelectorAll('.category-link');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (isMobile()) {
                // Close the mobile menu when a category is selected
                const mobileMenu = document.querySelector('.main-navigation');
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    // Call the closeMobileMenu function if it exists
                    if (typeof closeMobileMenu === 'function') {
                        closeMobileMenu();
                    } else {
                        // Fallback: manually close the menu
                        mobileMenu.classList.remove('active');
                        document.querySelector('.mobile-menu-toggle').classList.remove('active');
                        document.querySelector('.mobile-menu-overlay').classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            }
        });
    });
} 
