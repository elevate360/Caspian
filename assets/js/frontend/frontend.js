( function( $ ) {

	var caspian = caspian || {};

	caspian.init = function() {

		caspian.$body 	= $( document.body );
		caspian.$window = $( window );
		caspian.$html 	= $( 'html' );
		caspian.$footerWidgets = $( '.footer-widgets' );

		this.inlineSVG();
		this.fitVids();
		this.responsiveTable();
		this.smoothScroll();
		this.parallax();
		this.stickit();
		this.subMenuToggle();
		this.gallery();
		this.masonry();
		this.returnToTop();
		this.bind();

	};

	caspian.supportsInlineSVG = function() {

		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );

	};

	caspian.inlineSVG = function() {

		if ( true === caspian.supportsInlineSVG() ) {
			document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
		}

	};

	caspian.fitVids = function() {

		$( '#page' ).fitVids({
			customSelector: 'iframe[src^="https://videopress.com"]'
		});

	};

	caspian.responsiveTable = function() {
		$table = $( 'table' );
		$table.wrap( '<div class="table-responsive"></div>' );
	};

	caspian.smoothScroll = function() {

		$smoothScroll = $( 'a[href*="#content"], a[href*="#site-navigation"], a[href*="#secondary"], a[href*="#page"]' ),

		$smoothScroll.click(function(event) {
	        // On-page links
	        if (
	            location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
	            location.hostname === this.hostname
	        ) {
	            // Figure out element to scroll to
	            var target = $(this.hash);
	            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	            // Does a scroll target exist?
	            if (target.length) {
	                // Only prevent default if animation is actually gonna happen
	                event.preventDefault();
	                $('html, body').animate({
	                    scrollTop: target.offset().top
	                }, 500, function() {
	                    // Callback after animation
	                    // Must change focus!
	                    var $target = $(target);
	                    $target.focus();
	                    if ($target.is(':focus')) { // Checking if the target was focused
	                        return false;
	                    } else {
	                        $target.attr( 'tabindex', '-1' ); // Adding tabindex for elements not focusable
	                        $target.focus(); // Set focus again
	                    }
	                });
	            }
	        }
		});

	};

	caspian.parallax = function() {

		$parallax = $( '.wp-custom-header' );

		$parallax.parallax();

	};

	caspian.stickit = function() {

		$mainNav = $( '.main-navigation' );

		$mainNav.stickit({
			screenMinWidth: 782,
			zIndex: 5
		});

	};

	caspian.subMenuToggle = function() {

		$subMenu = $( '.main-navigation .sub-menu' );

		$subMenu.before( '<button class="sub-menu-toggle" role="button" aria-expanded="false">' + Caspianl10n.expandMenu + Caspianl10n.collapseMenu + Caspianl10n.subNav + '</button>' );
		$( '.sub-menu-toggle' ).on( 'click', function( e ) {

			e.preventDefault();

			var $this = $( this );
			$this.attr( 'aria-expanded', function( index, value ) {
				return 'false' === value ? 'true' : 'false';
			});

			// Add class to toggled menu
			$this.toggleClass( 'toggled' );
			$this.next( '.sub-menu' ).slideToggle( 0 );

		});

	};

	caspian.gallery = function() {

		$entryGallery = $( '.entry-gallery' );

		$entryGallery.each( function() {

			var galleryID = $(this).attr('id');

			$( '#'+ galleryID ).justifiedGallery({
				rowHeight : 150,
				margins : 5,
				lastRow: 'justify'
			});

			$( '#'+ galleryID ).magnificPopup({
				delegate: 'a',
				type: 'image',
				closeOnContentClick: false,
				closeBtnInside: false,
				mainClass: 'mfp-with-zoom mfp-img-mobile',
				image: {
					verticalFit: true,
					titleSrc: function(item) {
						return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">'+ Caspianl10n.imageSrc +'</a>';
					}
				},
				gallery: {
					enabled: true
				},
				zoom: {
					enabled: true,
					duration: 300, // don't foget to change the duration also in CSS
					opener: function(element) {
						return element.find('img');
					}
				}

			});
		});

	};

	caspian.masonry = function() {

		caspian.$footerWidgets.masonry({
			itemSelector: '.widget',
			columnWidth: '.widget'
		});

		$( window ).load(function(){
	        caspian.$footerWidgets.masonry( 'reloadItems' );
	        caspian.$footerWidgets.masonry( 'layout' );
		});

	};

	caspian.returnToTop = function() {

		$returnTop = $( '.return-to-top' );

		$(window).scroll(function () {
		    if ($(this).scrollTop() > 720) {
		        $returnTop.removeClass('off').addClass('on');
		    }
		    else {
		        $returnTop.removeClass('on').addClass('off');
		    }
		});

	};

	caspian.bind = function() {

		caspian.$body.on( 'post-load', function () {
			caspian.fitVids();
			caspian.gallery();
		});

		caspian.$window.load(function(){
	        caspian.$footerWidgets.masonry( 'reloadItems' );
	        caspian.$footerWidgets.masonry( 'layout' );
		});

		caspian.$body.on( 'wp-custom-header-video-loaded', function() {
			$body.addClass( 'has-header-video' );
		});

	};

	/** Initialize caspian.init() */
	$( function() {
		caspian.init();
	});


} )( jQuery );
