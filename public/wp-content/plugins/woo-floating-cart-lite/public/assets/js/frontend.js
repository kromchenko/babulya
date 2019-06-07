(function($) {
  $.fn.mutated = function(cb, e) {
    e = e || { subtree:true, childList:true, characterData:true };
    $(this).each(function() {
      function callback(changes) { cb.call(node, changes, this); }
      var node = this;
      (new MutationObserver(callback)).observe(node, e);
    });
  };
})(jQuery);

(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	*/

	$(function() {

		// wc_cart_fragments_params is required to continue, ensure the object exists
		if ( typeof wc_cart_fragments_params === 'undefined' ) {
			return false;
		}

		/* Storage Handling */
		var $supports_html5_storage;
		var cart_hash_key = wc_cart_fragments_params.ajax_url.toString() + '-wc_cart_hash';

		try {
			$supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
			window.sessionStorage.setItem( 'wc', 'test' );
			window.sessionStorage.removeItem( 'wc' );
			window.localStorage.setItem( 'wc', 'test' );
			window.localStorage.removeItem( 'wc' );
		} catch( err ) {
			$supports_html5_storage = false;
		}

        var layouts = {
            'S': 480,
            'M': 768,
            'L': 1070
        };

		var isTouch = touchSupport();

        var wooNotices = $('.woocommerce-notices-wrapper');

		//store jQuery objects
		var cartWrapper = $('.xt_woofc'),
			addToCartBtn,
		    singleAddToCartBtn,
            cartHeaderNotif,
            cartBody,
            cartBodyHeader,
            cartBodyFooter,
            cartList,
            cartTotal,
            cartTrigger,
            cartCheckoutButton,
            cartCount,
            cartSpinner,
            cartError,
            undo,
            couponToggle,
			couponRemoveBtn,
            couponForm,
            cartErrorTimeoutId,
            undoTimeoutId,
            addTimeoutId,
            winWidth,
		    cartActive = false,
		    cartTransitioning = false,
            cartRefreshing = false,
		    isReady = false,
		    viewMode = 'desktop',
		    couponsEnabled = false,
            totalsEnabled = false,
            ajaxInit = cartWrapper.attr('data-ajax-init') === '1',
            expressCheckout = cartWrapper.attr('data-express-checkout') === '1',
		    triggerevent = cartWrapper.attr('data-triggerevent'),
		    hoverdelay = cartWrapper.attr('data-hoverdelay') ? cartWrapper.attr('data-hoverdelay') : 0


		if(isTouch && triggerevent === 'mouseenter') {
			triggerevent = 'vclick';
		}

		function initVars() {

			cartWrapper = $('.xt_woofc');
			addToCartBtn = $('.add_to_cart_button');
			singleAddToCartBtn = $('form .single_add_to_cart_button, .variations .single_add_to_cart_button');
			wooNotices = $('.woocommerce-notices-wrapper');
			cartWrapper = $('.xt_woofc');
			cartHeaderNotif = $('.xt_woofc-notif');
			cartBody = cartWrapper.find('.xt_woofc-body');
			cartBodyHeader = cartBody.find('.xt_woofc-body-header');
			cartBodyFooter = cartBody.find('.xt_woofc-body-footer');
			cartList = cartBody.find('ul').eq(0);
			cartTrigger = cartWrapper.find('.xt_woofc-trigger');
			cartCount = cartTrigger.find('.xt_woofc-count');
			cartCheckoutButton = cartWrapper.find('.xt_woofc-checkout');
			cartTotal = cartCheckoutButton.find('span.amount');
			cartSpinner = cartWrapper.find('.xt_woofc-spinner-wrap');
			cartError = cartWrapper.find('.xt_woofc-cart-error');
			undo = cartWrapper.find('.xt_woofc-undo');
			totalsEnabled = cartWrapper.hasClass('xt_woofc-enable-totals');
			couponsEnabled = cartWrapper.hasClass('xt_woofc-enable-coupon');
			if(couponsEnabled) {
				couponToggle = cartWrapper.find('.xt_woofc-coupon');
				couponRemoveBtn = cartWrapper.find('.xt_woofc-remove-coupon');
				couponForm = cartWrapper.find('.xt_woofc-coupon-form');
			}
		}
		
		function showLoading() {
			$('html').addClass('xt_woofc-loading');
		}

		function hideLoading() {
			$('html').removeClass('xt_woofc-loading');
		}

		function init() {

			if( !cartWrapper.length ) {
				return false;
			}

			initVars();
            setListHeight();

            $(window).on('resize', function(){

                window.requestAnimationFrame(onResize);

            }).trigger('resize');

			//override add product to cart event
			$(document.body).off( 'click', addToCartBtn.selector);
			$(document.body).on( 'vclick', addToCartBtn.selector, function(e) {

                var $button = $(this);

                if($button.hasClass('ajax_add_to_cart')) {

					e.preventDefault();

					if (!$button.attr('data-product_id')) {
						return true;
					}

					$button.removeClass('added');
					$button.addClass('loading');

					var data = {};

					$.each($button.data(), function (key, value) {
						data[key] = value;
					});

					// Trigger event.
					$(document.body).trigger('adding_to_cart', [$button, data]);

					// Ajax action.
					$.XT_Ajax_Queue({

						url: XT_WOOFC.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
						data: data,
						type: 'post'

					}).done(function (response) {

						if (!response) {
							return;
						}

						if (response.error && response.product_url) {
							window.location = response.product_url;
							return;
						}

						// Redirect to cart option
						if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
							window.location = wc_add_to_cart_params.cart_url;
							return;
						}

						// Trigger event so themes can refresh other areas.
						$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);

					});

				}else{

                	if($button.attr('href') !== '') {

                		location.href = $button.attr('href');
					}
				}
			});

			$(document.body).on('added_to_cart', function(evt, fragments, cart_hash, btn){

			    if(!cartHasErrors(fragments)) {
                    addToCart(btn, fragments);
					setListHeight();
                }
            });

			// Remove alerts on click
			$(document.body).on('vclick', '.woocommerce-error, .woocommerce-message', function() {

				$(this).slideUp(function() {
					$(this).remove();
				});
			});

            // Update Cart List Obj
            $(document.body).on('wc_fragments_refreshed', function() {

                initVars();
				removeUnwantedElements();
                setListHeight();

            });

			//open/close cart

			cartTrigger.on('vclick', function(evt){
				evt.preventDefault();
				if(!cartTransitioning) {
					toggleCart();
				}
			});

			if(triggerevent === 'mouseenter') {

				var mouseEnterTimer;
				cartTrigger.on('mouseenter', function(evt){

				    mouseEnterTimer = setTimeout(function () {

					    if(!cartActive && !cartTransitioning) {
							evt.preventDefault();
							toggleCart();
						}

				    }, hoverdelay);

				}).on("mouseleave", function() {

				    clearTimeout(mouseEnterTimer);
				});

			}


			//close cart when clicking on the .xt_woofc::before (bg layer)
			cartWrapper.on('vclick', function(evt){
				if( $(evt.target).is($(this)) ) {
					toggleCart(true);
				}
			});


			//delete an item from the cart
			cartBody.on('vclick', '.xt_woofc-delete-item', function(evt){
				evt.preventDefault();

				var key = $(evt.target).parents('.xt_woofc-product').data('key');
				removeProduct(key);
			});

			//update item quantity

			$( document ).on('change', '.xt_woofc-quantity input', function(evt) {

                evt.preventDefault();

				var $parent = $( this ).parent();
				var min = parseFloat( $( this ).attr( 'min' ) );
				var max	= parseFloat($( this ).attr( 'max' ) );

				if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {

					$( this ).val( min );
					showError(XT_WOOFC.lang.min_qty_required, $parent);
                    return;

				}else if ( max && max > 0 && parseFloat( $( this ).val() ) > max ) {

					$( this ).val( max );
					showError(XT_WOOFC.lang.max_stock_reached, $parent);
					return;

				}

				var product = $(this).closest('.xt_woofc-product');
				var qty = $(this).val();
				var key = product.data('key');

                updateProduct(key, qty);

			});


			$( document ).on( 'vclick', '.xt_woofc-quantity-up, .xt_woofc-quantity-down', function(evt) {

				evt.preventDefault();

				// Get values

				var $parent 	= $( this ).closest( '.xt_woofc-quantity' ),
					$qty		= $parent.find( 'input' ),
					currentVal	= parseFloat( $qty.val() ),
					max			= parseFloat( $qty.attr( 'max' ) ),
					min			= parseFloat( $qty.attr( 'min' ) ),
					step		= $qty.attr( 'step' ),
					newQty		= currentVal;

				// Format values
				if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) {
					currentVal = 0;
				}
				if ( max === '' || max === 'NaN' ) {
					max = '';
				}
				if ( min === '' || min === 'NaN' ) {
					min = 0;
				}
				if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) {
					step = 1;
				}


				// Change the value
				if ( $( this ).is( '.xt_woofc-quantity-up' ) ) {

					if ( max && ( max === currentVal || currentVal > max ) ) {
						newQty = ( max );
						showError(XT_WOOFC.lang.max_stock_reached, $parent);
                        return;
					} else {
						newQty = ( currentVal + parseFloat( step ) );
					}

				} else {

					if ( min && ( min === currentVal || currentVal < min ) ) {
						newQty = ( min );
						showError(XT_WOOFC.lang.min_qty_required, $parent);
						return;
					} else if ( currentVal > 0 ) {
						newQty = ( currentVal - parseFloat( step ) );
					}

				}

				// Trigger change event

				var product = $qty.closest('.xt_woofc-product');
				var key = product.data('key');

				if(currentVal !== newQty) {

					// Update product quantity
					updateProduct(key, newQty);
				}

			});


			//reinsert item deleted from the cart
			undo.on('vclick', 'a', function(evt){
				if(undoTimeoutId) {
					clearInterval(undoTimeoutId);
				}
				evt.preventDefault();

				var timeout = 0;

				var product = cartList.find('.xt_woofc-deleted');

				product.each(function(i) {

					var $this = $(this);

					timeout = timeout + 300;

					setTimeout(function() {

						$this.addClass('xt_woofc-undo-deleted');

					}, timeout);

				});

				animationEnd(product, true, function(el) {

					el.removeClass('xt_woofc-deleted xt_woofc-undo-deleted').removeAttr('style');

					var key = undo.data('key');

					undoProductRemove(key, function() {

						$( document.body ).trigger( 'xt_woofc_undo_product_remove', [ key ] );

					});
					refreshCartVisibility();

				});

                setTimeout(function() {
                    undo.removeClass('xt_woofc-visible');
                    showCouponToggle();
                });

			});


            if(XT_WOOFC.can_use_premium_code || (typeof(XT_WOOVS) !== 'undefined' && XT_WOOVS.can_use_premium_code)) {

                //single add product to cart
                $(document).on('vclick', singleAddToCartBtn.selector, function(evt){

                    var btn = $(this);

                    if(btn.hasClass('disabled')) {
                        return false;
                    }

                    if(skipAddToCart(btn)) {
                        return true;
                    }

                    evt.preventDefault();
                    evt.stopPropagation();

                    if(validateAddToCart(btn)) {
                        addToCart(btn);
                    }
                });

				$( document.body ).on('updated_cart_totals', function(e) {

					if($('form.woocommerce-shipping-calculator').length) {
						$('form.woocommerce-shipping-calculator').slideUp();
					}
				});


				if(expressCheckout || totalsEnabled) {

					$( document ).on('change', 'select.shipping_method, :input[name^=shipping_method]', function () {
						showLoading();
					});


					$(document).on('updated_shipping_method', function (e) {

						if(!expressCheckout) {
							$(document.body).trigger('wc_update_cart');
						}else{
							$(document.body).trigger('update_checkout');
						}
					});


					$(document).on('updated_wc_div', function (e) {

						setTimeout(function() {
							hideLoading();
						}, 800);
					});

					$(document).on('select2:open', '.xt_woofc-body .woocommerce-shipping-calculator #calc_shipping_country', function (e) {

						var $form = $(e.target).closest('form');

						$form.find('input:text, textarea').val('');
						$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
					});

					$(document).on('select2:open', '.xt_woofc-body .select2-hidden-accessible', function (e) {

						cartBody.css('overflow', 'hidden');
					});

					$(document).on('select2:select', '.xt_woofc-body .select2-hidden-accessible', function (e) {

						cartBody.css('overflow', '');
						cartBody.off('scroll.select2-' + e.target.id);
					});

					$(document).on('select2:close', '.xt_woofc-body .select2-hidden-accessible', function (e) {

						cartBody.css('overflow', '');
						cartBody.off('scroll.select2-' + e.target.id);
					});
				}

				if(expressCheckout) {

					$(document.body).on('update_checkout', function(){

						removeAllAlerts();
						showLoading();
						setListHeight();
					});

					$(document.body).on('checkout_error updated_checkout', function(){

						hideLoading();
						removeUnwantedElements();
						scrollToAlert();
						setListHeight();
					});

					$(document.body).on('click', 'a.showlogin', function(e) {

						var $this = $(e.target);

						setTimeout(function() {

							var $div = cartBody.find('.woocommerce-form-login').first();

							if($div.length && $div.is(':visible')) {
								cartBody.animate({scrollTop: (cartBody.scrollTop() + $this.position().top) - 10}, 500);
							}
						}, 500);
					});

					if(XT_WOOFC.can_checkout) {

						$(document).on('vclick', cartCheckoutButton.selector, function (e) {

							var order_btn = cartBody.find('[name="woocommerce_checkout_place_order"]');

							if(order_btn.length) {
								order_btn.trigger('click');

								showLoading();
								e.preventDefault();
							}
						});

						$(document).off('click', '.shipping-calculator-button');
						$(document).on('click', '.xt_woofc-cart-totals .shipping-calculator-button', function (e) {

							e.preventDefault();

							var use_shipping_address = cartBody.find('#ship-to-different-address-checkbox').is(':checked');
							var $div = use_shipping_address ? cartBody.find('.woocommerce-shipping-fields').first() : cartBody.find('.woocommerce-billing-fields').first();

							if ($div.length) {
								cartBody.animate({scrollTop: (cartBody.scrollTop() + $div.position().top) - 10}, 500);
							}
						});

					}
                }
            }

			initMutationObserver();
			setTriggerDefaultText();
			refreshCartCountSize();
			removeUnwantedElements();

			if(ajaxInit) {

                refreshCart(function () {

                    cartReady();
                });

            }else{
				cartReady();
			}

		}

		function setListHeight() {

            cartList.css({'min-height': 'calc(100% - '+cartBodyFooter.height()+'px)'});
        }

		function onResize() {

            winWidth = $(window).width();

            if(winWidth <= layouts.S) {

                cartWrapper.removeClass('xt_woofc-is-desktop xt_woofc-is-tablet');
                cartWrapper.addClass('xt_woofc-is-mobile');
                viewMode = 'mobile';

            }else if(winWidth <= layouts.M) {

                cartWrapper.removeClass('xt_woofc-is-desktop xt_woofc-is-mobile');
                cartWrapper.addClass('xt_woofc-is-tablet');
                viewMode = 'tablet';

            }else{

                cartWrapper.removeClass('xt_woofc-is-mobile xt_woofc-is-tablet');
                cartWrapper.addClass('xt_woofc-is-desktop');
                viewMode = 'desktop';
            }

			setListHeight();

        }

        function initMutationObserver() {

			if(isReady) {
				return false;
			}

			$('body').mutated(function(changes, observer) {

				if(isReady) {
					return false;
				}

				changes.some(function(change) {

					return Array.prototype.slice.call(change.addedNodes).some(function(item) {

						if($(item).hasClass('single_add_to_cart_button')) {

							initVars();
							setTriggerDefaultText();
							return true;
						}

					})

				})

			});
		}

		function setTriggerDefaultText() {

			if(singleAddToCartBtn.length > 0) {

				singleAddToCartBtn.each(function() {

					$(this).data('defaultText', $(this).html().trim());

					if($(this).data('defaultText') !== '') {
						$(this).html(XT_WOOFC.lang.wait);
					}

					$(this).data('loading', true).addClass('loading');

				});
			}
		}

		function resetTriggerDefaultText() {

			singleAddToCartBtn.each(function() {

				$(this).removeData('loading').removeClass('loading');

				if($(this).data('defaultText') !== '') {
					$(this).html($(this).data('defaultText'));
				}

			});
		}

		function transitionEnd(el, once, callback) {

			var events = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';

			if(once) {

				el.one(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});

			}else{

				el.on(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});
			}
		}

		function animationEnd(el, once, callback) {

			var events = 'webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend';

			if(once) {

				el.one(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});

			}else{

				el.on(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});
			}
		}

		function skipAddToCart(btn) {

			if(btn.closest('.wc-product-table').length) {

				return true;
			}

			return false;
		}

		function cartHasErrors(fragments) {

		    if(fragments && fragments.hasOwnProperty('.woocommerce-notices-wrapper') && $(fragments['.woocommerce-notices-wrapper']).length) {

                return $(fragments['.woocommerce-notices-wrapper']).find('.woocommerce-error').length > 0;
            }
            return false;
        }

        function validateAddToCart(btn) {

            // validate required options from multiple plugins

            var form = btn.closest('form');
            var errors = 0;

            // Check if has quantity
            var $qty = form.find('.quantity .qty:visible');

            if($qty.length) {

                $qty.closest('.quantity').removeClass('xt_woofc-error');

                if (parseInt($qty.val()) === 0) {

                    $qty.closest('.quantity').addClass('xt_woofc-error');
                    errors++;
                }
            }

            // https://woocommerce.com/products/product-add-ons/
            var $elements = form.find('.wc-pao-required-addon, .required-product-addon');

            // https://codecanyon.net/item/woocommerce-extra-product-options/7908619
            $elements = $.merge(
                $elements,
                form.find('.tm-has-required + div.tm-extra-product-options-container').not('.tc-hidden div.tm-extra-product-options-container')
            );

            // https://wordpress.org/plugins/woocommerce-product-addon/
            $elements = $.merge(
                $elements,
                form.find('.ppom-field-wrapper .show_required').closest('.ppom-field-wrapper')
            );

            // https://woocommerce.com/products/gravity-forms-add-ons/
            $elements = $.merge(
                $elements,
                form.find('.gfield_contains_required')
            );

            $elements.each(function() {

                var $row = $(this);
                var $input = $row.find(':input');

                if($input.attr('type') === 'checkbox' || $input.attr('type') === 'radio') {
                    $row.removeClass('xt_woofc-error');
                    if(!$input.is(':checked')) {
                        errors++;
                        $row.addClass('xt_woofc-error');
                    }
                }else{
                    $row.removeClass('xt_woofc-error');
                    if($input.val() === '') {
                        errors++;
                        $row.addClass('xt_woofc-error');
                    }
                }
            });

            if(errors > 0) {
                var $firstError = form.find('.xt_woofc-error').first();
                var inQuickView = $firstError.closest('.xt-woo-quick-view').length > 0;
                var scroll_selector = inQuickView ? '.xt_wooqv-item-info' : 'html,body';

                if($firstError.length) {
                    $(scroll_selector).animate({scrollTop: $firstError.offset().top - 100}, 500);
                }
            }

            return (errors === 0);
        }

		function toggleCart(bool) {

			cartTransitioning = true;
			var cartIsOpen = ( typeof bool === 'undefined' ) ? cartWrapper.hasClass('xt_woofc-cart-open') : bool;

			if( cartIsOpen ) {
				cartWrapper.removeClass('xt_woofc-cart-open');
				cartActive = false;

				if(XT_WOOFC.can_use_premium_code && XT_WOOFC.body_lock_scroll) {
					bodyScrollLock.enableBodyScroll(cartBody.get(0));
				}

				resetUndo();
				resetCouponForm();
                showCouponToggle();

				setTimeout(function(){
					cartBody.scrollTop(0);
					//check if cart empty to hide it
					refreshCartVisibility();
				}, 500);

			} else {
				cartWrapper.addClass('xt_woofc-cart-open');
				cartActive = true;

				if(XT_WOOFC.can_use_premium_code && XT_WOOFC.body_lock_scroll) {
					bodyScrollLock.disableBodyScroll(cartBody.get(0));
				}
			}

			transitionEnd(cartWrapper, true, function() {
				cartTransitioning = false;
				if( !cartIsOpen ) {
					cartWrapper.addClass('xt_woofc-cart-opened');
				}else{
					cartWrapper.removeClass('xt_woofc-cart-opened');
				}
			});

			setTimeout(function(){
				cartTransitioning = false;
				refreshCartVisibility();
			}, 500)
		}

		function addToCart(trigger, fragments) {

			fragments = typeof(fragments) !== 'undefined' ? fragments : null;

			if(addTimeoutId){
				clearInterval(addTimeoutId);
			}

			if(trigger.data('loading')) {
				return false;
			}

			var type;
			var single = trigger.hasClass('single_add_to_cart_button');
			var single_variation = false;

			if(single) {
				single_variation = trigger.closest('.variations').length;
			}

			var args = {};

			trigger.removeClass('added');

			if(!single || fragments) {

				type = 'add';
				args = {
					fragments: fragments
				};

			}else{

				type = 'single-add';
				var form = trigger.closest('form');
				args = form.serializeJSON();

				if(typeof args === 'string') {
					args = $.parseJSON(args);
				}

				if(typeof args === 'object') {
					args['add-to-cart'] = form.find('[name="add-to-cart"]').val();
				}
			}


			trigger.data('loading', true);
			trigger.addClass('loading');

			//update cart product list
			request(type, args, function(data) {

				if(!cartHasErrors(data.fragments)) {

                    if(XT_WOOFC.can_use_premium_code) {

                        if (cartWrapper.attr('data-flytocart') === '1') {

                            animateAddToCart(trigger, single, single_variation);

                        } else if (!single_variation) {

                            animateCartShake();
                        }
                    }

					trigger.removeClass('loading').addClass('added');
					trigger.removeData('loading');

					$( document.body ).trigger( 'xt_woofc_added_to_cart', [ data ] );

				}else{

					trigger.removeClass('loading');
					trigger.removeData('loading');
				}

			});

			//show cart
			refreshCartVisibility();
		}

		function animateAddToCart(trigger, single, single_variation) {

			var item = null;
			var productsContainer = $('body');
			var position_key = viewMode !== 'desktop' ? 'data-'+viewMode+'-position' : 'data-position';

			var position = cartWrapper.attr(position_key);

			if(!single) {

				item = findLoopImage(trigger);

			}else{

				item = findSingleImage(trigger);

				if(item && item.length === 0) {

					var id_input = productsContainer.find('input[name="add-to-cart"]');

					if(id_input.length) {

						var product_id = id_input.val();

						trigger = $('.add_to_cart_button[data-product_id="'+product_id+'"]');

						if(trigger.length) {
							animateAddToCart(trigger, single, single_variation);
							return false;
						}
					}

				}
			}

			if(!item || item.length === 0) {

				return false;
			}

			var itemPosition = item.offset();
			var triggerPosition = cartTrigger.offset();


			var defaultState = {
				opacity: 1,
				top: itemPosition.top,
				left: itemPosition.left,
				width: item.width(),
				height: item.height(),
				transform: 'scale(1)'
			};

			var top_dir = 0;
			var left_dir = 0;

			if(position === 'bottom-right') {

				top_dir = -1;
				left_dir = -1;

			}else if(position === 'bottom-left') {

				top_dir = -1;
				left_dir = 1;

			}else if(position === 'top-right') {

				top_dir = 1;
				left_dir = -1;

			}else if(position === 'top-left') {

				top_dir = 1;
				left_dir = 1;
			}

			var animationState = {
				top: triggerPosition.top + (cartTrigger.height() / 2) - (defaultState.height / 2) + (trigger.height() * top_dir),
			    left: triggerPosition.left + (cartTrigger.width() / 2) - (defaultState.width / 2) + (trigger.width() * left_dir),
			    opacity: 0.9,
			    transform: 'scale(0.5)'
			};

			var inCartState = {
				top: triggerPosition.top + (cartTrigger.height() / 2) - (defaultState.height / 2),
			    left: triggerPosition.left + (cartTrigger.width() / 2) - (defaultState.width / 2),
			    opacity: 0,
			    transform: 'scale(0)'
			};


			var duplicatedItem = item.clone();
			duplicatedItem.find('.add_to_cart_button').remove();
			duplicatedItem.css(defaultState);
			duplicatedItem.addClass('xt_woofc-fly-to-cart');

			duplicatedItem.appendTo(productsContainer);

			var flyAnimationDuration = cartWrapper.attr('data-flyduration') ? cartWrapper.attr('data-flyduration') : 650;
			flyAnimationDuration = (parseInt(flyAnimationDuration) / 1000);

			TweenLite.to(duplicatedItem, flyAnimationDuration, { css: animationState, ease: Power3.easeOut, onComplete:function() {

				animateCartShake();

				TweenLite.to($(this.target), (flyAnimationDuration * 0.8), { css: inCartState, ease: Power3.easeOut, onComplete: function() {

					$(this.target).remove();

				}});

			}});

		}

		function animateCartShake() {

			var shakeClass = cartWrapper.attr('data-shaketrigger');

			if(shakeClass !== '') {
				cartTrigger.addClass('xt_woofc-shake-'+shakeClass);

				animationEnd(cartTrigger, false, function(_trigger) {
					_trigger.removeClass('xt_woofc-shake-'+shakeClass);

					if(cartWrapper.attr('data-opencart-onadd') === '1') {
						toggleCart(false);
					}

				});
			}
		}

		function findLoopImage(trigger) {

			var item = null;

			if(trigger.closest('.product').length) {

				var product = trigger.closest('.product');
				item = product.find('.attachment-woocommerce_thumbnail, .woocommerce-placeholder, .wp-post-image').first();

				if(item.length === 0) {

					item = product;
				}
			}

			return item;

		}

		function findSingleImage(trigger) {

			var item = null;

			// If Woo Product Table, Find Row Image
			if(trigger.closest('.wc-product-table').length) {

				if(trigger.closest('.product-row').find('.product-table-image').length) {

					item = trigger.closest('.product-row').find('.product-table-image');

				// If Woo Product Table, Mobile View Find Row Image
				}else if(trigger.closest('tr').prev('.product-row').find('.product-table-image').length) {

					item = trigger.closest('tr').prev('.product-row').find('.product-table-image');
				}

			// If Woo Product Table, Find Row Image
			}else if(trigger.closest('.variations').find('.image_link img').length) {

				item = trigger.closest('.variations').find('.image_link img');

			// Find image in Woo Quick View Modal
			}else if(trigger.closest('.xt-woo-quick-view').length) {

				item = $('.xt_wooqv-slider-wrapper');

			// Find image in Product Quick View Modal
			}else if(trigger.closest('.product-quick-view-container').length) {

				item = trigger.closest('.product-quick-view-container').find('.slide.first img');

			// Find image in single product page
			}else if(trigger.closest('.product').length) {

				var product = trigger.closest('.product');

				if(product.find('.images img.attachment-shop_single').length) {

					item = product.find('.images img.attachment-shop_single').first();

				}else if(product.find('.magic-slide').length) {

					item = product.find('.magic-slide');

				}else if(product.find('.woocommerce-product-gallery .woocommerce-product-gallery__image').length) {

					item = product.find('.woocommerce-product-gallery .woocommerce-product-gallery__image').first();

				}else if(product.find('.images img').length) {

					item = product.find('.images img').first();
				}
			}

			if(!item) {
				item = findLoopImage(trigger);
			}

			return item;
		}

		function request(type, args, callback) {

			hideHeaderMessages();
			resetCouponForm();
			showCouponToggle();

			if(type !== 'refresh') {
				removeAllAlerts();
			}

			showLoading();

			if(type !== 'remove' && type !== 'undo') {
				undo.removeClass('xt_woofc-visible');
			}

			if(type === 'refresh' || type === 'totals') {

				refreshFragments(type, callback);
				return false;

			}else if(type === 'add') {

				onRequestDone(args, type, callback);
				return false;
			}

			var params = {
				type: type
			};

			params = $.extend(params, args);

			$.XT_Ajax_Queue({

				url: XT_WOOFC.wc_ajax_url.toString().replace( '%%endpoint%%', 'xt_woofc_update_cart' ),
				data: params,
				type: 'post'

			}).done(function(data) {

			    onRequestDone(data, type, callback);

			});

		}

		function refreshFragments(type, callback) {

			$.XT_Ajax_Queue({
				url: XT_WOOFC.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
				data: {
					type: type
				},
				type: 'post'

			}).done(function(data) {

				onRequestDone(data, type, callback);
			});
		}

		function onRequestDone(data, type, callback) {

            $.each( data.fragments, function( key, value ) {

                $( key ).replaceWith( value );
            });

            // If cart has errors, scroll to error
            if(cartHasErrors(data.fragments) && wooNotices.length) {

                // Close Quick View
                if(xt_wooqv_close) {
                    xt_wooqv_close();
                }
                $('html,body').animate({scrollTop: wooNotices.offset().top - 100}, 500);
            }

            if ( $supports_html5_storage ) {
                sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(data.fragments));
                set_cart_hash(data.cart_hash);

                if (data.cart_hash) {
                    set_cart_creation_timestamp();
                }
            }

            initVars();
            setListHeight();
            refreshCartVisibility();

			$(document.body).trigger('wc_fragments_refreshed');

			var loadingTimout = cartWrapper.attr('data-loadingtimeout') ? parseInt(cartWrapper.attr('data-loadingtimeout')) : 0;

			setTimeout(function() {
				$('html').addClass('xt_woofc-stoploading');
				setTimeout(function() {
					hideLoading();
					$('html').removeClass('xt_woofc-stoploading');

					if(typeof(callback) !== 'undefined') {
						callback(data);
					}

				}, loadingTimout);
			}, 100);

		}

		function updateProduct(key, qty, callback) {

			if(qty > 0) {

				request('update', {

					cart_item_key: key,
					cart_item_qty: qty

				}, function(data) {

					$( document.body ).trigger( 'xt_woofc_product_update', [ key, qty ] );

					if(typeof(callback) !== 'undefined') {
						callback(data);
					}

				});

			}else{
				removeProduct(key, callback);
			}
		}

		function removeProduct(key, callback) {

			request('remove', {

				cart_item_key: key

			}, function() {

                resetUndo();
				resetCouponForm();
                showCouponToggle();

				var product = cartList.find('li[data-key="'+key+'"]');

				if(product.length > 0) {

					var isBundle = product.hasClass('xt_woofc-bundle');
					var isComposite = product.hasClass('xt_woofc-composite');
					var topPosition = product.offset().top - cartBody.children('ul').offset().top;
					var selector = '';

					product.css('top', topPosition+'px');

				}

				if(isBundle || isComposite) {

					var group_id = product.data('key');

					if(isBundle) {
						selector = '.xt_woofc-bundled-item[data-group="'+group_id+'"]';
					}else{
						selector = '.xt_woofc-composite-item[data-group="'+group_id+'"]';
					}

					var groupedProducts = $(cartList.find(selector).get().reverse());

					groupedProducts.addClass('xt_woofc-deleted');
				}

				product.addClass('xt_woofc-deleted');
				refreshCartVisibility();

                hideCouponToggle();
                undo.data('key', key).addClass('xt_woofc-visible');

				$( document.body ).trigger( 'xt_woofc_product_removed', [ key ] );


				//wait 8sec before completely remove the item
				undoTimeoutId = setTimeout(function(){

					resetUndo();
                    resetCouponForm();
                    showCouponToggle();

					if(typeof(callback) !== 'undefined') {
						callback();
					}

				}, 8000);

			});
		}

        function showCouponToggle() {

		    if(couponsEnabled) {
                couponToggle.addClass('xt_woofc-visible');
            }

            cartHeaderNotif.removeClass('xt_woofc-visible');
        }

        function hideCouponToggle() {

            if(couponsEnabled) {
                couponToggle.removeClass('xt_woofc-visible');
            }

            cartHeaderNotif.addClass('xt_woofc-visible');
        }

		function resetCouponForm() {

		    if(couponsEnabled && couponForm.is(':visible')) {
				couponForm.slideUp();
            }
        }

		function resetUndo() {

			if(undoTimeoutId) {
				clearInterval(undoTimeoutId);
			}

			undo.removeData('key').removeClass('xt_woofc-visible');
			cartList.find('.xt_woofc-deleted').remove();

		}

		function undoProductRemove(key, callback) {

			request('undo', {

				cart_item_key: key,

			}, callback);
		}

		function refreshCart(callback) {

		    if(!cartRefreshing) {

                cartRefreshing = true;
                request('refresh', {}, function() {

                    cartRefreshing = false;

                    if(typeof(callback) !== 'undefined') {
                        callback();
                    }
                });
            }
		}

		function refreshCartVisibility() {

			initVars();

			if( cartList.find('li:not(.xt_woofc-deleted):not(.xt_woofc-no-product)').length === 0) {
				cartWrapper.addClass('xt_woofc-empty');
			}else{
				cartWrapper.removeClass('xt_woofc-empty');
			}

		}

		function refreshCartCountSize() {

			var quantity = Number(cartCount.find('li').eq(0).text());

			if(quantity > 99) {
				cartCount.addClass('xt_woofc-count-big');
			}else{
				cartCount.removeClass('xt_woofc-count-big');
			}
		}

		/* Cart session creation time to base expiration on */
		function set_cart_creation_timestamp() {
			if ( $supports_html5_storage ) {
				sessionStorage.setItem( 'wc_cart_created', ( new Date() ).getTime() );
			}
		}

		/** Set the cart hash in both session and local storage */
		function set_cart_hash( cart_hash ) {
			if ( $supports_html5_storage ) {
				localStorage.setItem( cart_hash_key, cart_hash );
				sessionStorage.setItem( cart_hash_key, cart_hash );
			}
		}

		function hideHeaderMessages() {

			if(cartErrorTimeoutId) {
				clearInterval(cartErrorTimeoutId);
			}

			undo.removeClass('xt_woofc-visible');
			cartError.removeClass('xt_woofc-visible');

			hideCouponToggle();
		}


		function showError(error, elemToShake) {

			hideHeaderMessages();

			if(typeof(elemToShake) !== 'undefined') {
				elemToShake.removeClass('xt_woofc-shake');
			}

			cartError.removeClass('xt_woofc-shake xt_woofc-visible');
			setTimeout(function() {

				cartError.text(error).addClass('xt_woofc-visible');

				transitionEnd(cartError, true, function() {

					cartError.addClass('xt_woofc-shake');

					if(typeof(elemToShake) !== 'undefined') {
						elemToShake.addClass('xt_woofc-shake');
					}

					animationEnd(cartError, true, function() {

						cartError.removeClass('xt_woofc-shake');

						cartErrorTimeoutId = setTimeout(function() {

							cartError.removeClass('xt_woofc-visible');

							showCouponToggle();

						}, 5000);
					});
				});

			},100);

		}


		function removeUnwantedElements() {

			cartBody.find('.woocommerce-cart-form').empty();

			if(cartBody.find('.woocommerce-notices-wrapper').length) {
				cartBody.find('.woocommerce-notices-wrapper').remove();
			}

			if(cartBody.find('.woocommerce-form-coupon,.woocommerce-form-coupon-toggle').length) {
				cartBody.find('.woocommerce-form-coupon,.woocommerce-form-coupon-toggle').remove();
			}

			if(totalsEnabled && !expressCheckout && cartBody.find('.angelleye-proceed-to-checkout-button-separator').length) {

				setTimeout(function() {
					cartBody.find('.angelleye-proceed-to-checkout-button-separator').insertAfter(cartBody.find('.angelleye_smart_button_bottom'));
				},100);
			}
		}

		function removeAllAlerts() {

			var $alerts = cartBody.find('.woocommerce-error, .woocommerce-message');
			if($alerts.length) {
				$alerts.each(function() {
					$(this).slideUp(function() {
						$(this).remove();
					});
				});
			}
		}

		function scrollToAlert() {

            setTimeout(function() {

                var $alert = cartBody.find('.woocommerce-error, .woocommerce-message').first();

                if($alert.length) {
                    cartBody.animate({scrollTop: (cartBody.scrollTop() + $alert.position().top) - 10}, 500);
                }
            },500)

        }

		function touchSupport() {

			if ("ontouchstart" in document.documentElement) {
				$('html').addClass('xt_woofc-touchevents');
				return true;
			}

			$('html').addClass('xt_woofc-no-touchevents');

			return false;
		}

        function cartReady() {

            resetTriggerDefaultText();

            $('body').addClass('xt_woofc-ready');

            $(document).trigger('xt_woofc_ready');

            isReady = true;
        }


        $(function() {

			init();

			if(XT_WOOFC.can_use_premium_code && couponsEnabled) {

				var wc_checkout_coupons = {
					init: function () {
						$(document.body).on('vclick', couponToggle.selector, this.show_coupon_form);
						$(document.body).on('vclick', couponRemoveBtn.selector, this.remove_coupon);
						couponForm.hide().submit(this.submit);
					},
					show_coupon_form: function (e) {
						e.preventDefault();

						cartBody.animate({
							scrollTop: 0
						}, 'fast');

						couponForm.slideToggle(400, function () {
							couponForm.find(':input:eq(0)').focus();
						});
					},
					submit: function (e) {

						e.preventDefault();

						var $form = $(this);

						if ($form.is('.processing')) {
							return false;
						}

						$form.addClass( 'processing' );

						showLoading();

						var data = {
							coupon_code: $form.find('input[name="coupon_code"]').val()
						};

						$.XT_Ajax_Queue({
							url: XT_WOOFC.wc_ajax_url.toString().replace('%%endpoint%%', 'xt_woofc_apply_coupon'),
							data: data,
							type: 'post'

						}).done(function(response) {

							$form.removeClass( 'processing' );

							setTimeout(function() {

								$form.slideUp();

								onRequestDone(response, 'apply_coupon');
								$(document.body).trigger('coupon_applied');

								hideLoading();

							},5);
						});

						return false;
					},
					remove_coupon: function (e) {
						e.preventDefault();

						var coupon = $(this).data('coupon');
						var container = $(this).closest('.xt_woofc-cart-totals');

						if (container.is('.processing')) {
							return false;
						}

						container.addClass( 'processing' );

						showLoading();

						var data = {
							coupon: coupon
						};

						$.XT_Ajax_Queue({
							url: XT_WOOFC.wc_ajax_url.toString().replace('%%endpoint%%', 'xt_woofc_remove_coupon'),
							data: data,
							type: 'post'

						}).done(function(response) {

							container.removeClass( 'processing' );

							onRequestDone(response, 'remove_coupon');
							$(document.body).trigger('coupon_removed');

							// Remove coupon code from coupon field
							$('form.xt_woofc-coupon-form').find('input[name="coupon_code"]').val('');

							hideLoading();

						});

					}
				};

				wc_checkout_coupons.init();

			}

			if(XT_WOOFC.can_use_premium_code) {

                if (typeof(wp) !== 'undefined' && typeof(wp.customize) !== 'undefined' && typeof(wp.customize.preview) !== 'undefined') {

                    wp.customize.value('xt_woofc[cart_product_link_to_single]').bind(function () {

                        top.wp.customize.previewer.save();
                    });

                    wp.customize.value('xt_woofc[cart_product_show_sku]').bind(function () {

                        top.wp.customize.previewer.save();
                    });

                    wp.customize.value('xt_woofc[cart_product_show_bundled_products]').bind(function () {

                        top.wp.customize.previewer.save();
                    });

                    wp.customize.value('xt_woofc[cart_product_show_composite_products]').bind(function () {

                        top.wp.customize.previewer.save();
                    });

                    wp.customize.value('xt_woofc[cart_product_show_attributes]').bind(function () {

                        top.wp.customize.previewer.save();
                    });

                    wp.customize.value('xt_woofc[cart_product_attributes_hide_label]').bind(function () {

                        top.wp.customize.previewer.save();
                    });

                    wp.customize.preview.bind('saved', function () {

                        setListHeight();
                        refreshCart();
                    });
                }
            }

		});


		window.xt_woofc_refresh_cart = refreshCart;
		window.xt_woofc_refresh_visibility = refreshCartVisibility;
	});


})( jQuery, window );
