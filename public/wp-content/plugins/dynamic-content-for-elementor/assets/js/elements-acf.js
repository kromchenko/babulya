var isAdminBar		= false,
	isEditMode		= false;
	

( function( $ ) {
	var get_acf_ElementSettings = function( $element ) {
		var elementSettings = {},
			modelCID = $element.data( 'model-cid' );

		if ( elementorFrontend.isEditMode() && modelCID ) {
			var settings = elementorFrontend.config.elements.data[ modelCID ],
				settingsKeys = elementorFrontend.config.elements.keys[ settings.attributes.widgetType || settings.attributes.elType ];

			jQuery.each( settings.getActiveControls(), function( controlKey ) {
				if ( -1 !== settingsKeys.indexOf( controlKey ) ) {
					elementSettings[ controlKey ] = settings.attributes[ controlKey ];
				}
			} );
		} else {
			elementSettings = $element.data('settings') || {};
		}
		return elementSettings;
	}
	//
	var WidgetElementsACFDCEHandler = function( $scope, $ ) {
		//console.log( 'pppppppppppppppp '+$scope );
		//alert('ACF Fields');
		var elementSettings = get_acf_ElementSettings( $scope );

		var bindEvents = function() {
			$scope.find( '.elementor-custom-embed-image-overlay' ).on( 'click', handleVideo );
		};
		var handleVideo = function() {
			if ( elementSettings.lightbox ) {
				alert( elementSettings.lightbox );
				// var elementSettings = get_acf_ElementSettings(),
				// 	position = elementSettings.lightbox_content_position;
				/*
				var options = {
					type: 'video',
					url: this.elements.$videoFrame.attr( 'src' ),
					modalOptions: {
						id: 'elementor-video-modal-' + this.getID(),
						videoAspectRatio: elementSettings.aspect_ratio,
						entranceAnimation: elementSettings.lightbox_content_animation,
						position: {
							my: position,
							at: position
						}
					}
				};*/

				//getLightBox().showModal( options );
			} else {
				//alert('sss');
				$(this).fadeOut(1000,function(){
					
					$(this).remove();
					playVideo();
				});

				
			}
		};
		var playVideo = function() {
			var $videoFrame = $scope.find( 'iframe' ),
				newSourceUrl = $videoFrame[0].src.replace( '&autoplay=0', '' );

			$videoFrame[0].src = newSourceUrl + '&autoplay=1';
		};
		bindEvents();

	};
	
	// Make sure you run this code under Elementor..
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dyncontel-acf.default', WidgetElementsACFDCEHandler );
	} );
} )( jQuery );
