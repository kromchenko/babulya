( function( $ ) {
	var isRellax = false;
	var currentDevice = '';
	var get_Dyncontel_ElementSettings = function( $element ) {
		
		var elementSettings = {},
			modelCID = $element.data( 'model-cid' );

		if ( elementorFrontend.isEditMode() && modelCID ) {
			var settings = elementorFrontend.config.elements.data[modelCID],
			type = settings.attributes.widgetType || settings.attributes.elType;
			
			var settingsKeys = elementorFrontend.config.elements.keys[ type ];

			if (!settingsKeys) {
				settingsKeys = elementorFrontend.config.elements.keys[type] = [];

				jQuery.each(settings.controls, function (name, control) {
					if (control.frontend_available) {
						settingsKeys.push(name);
					}
				});
			}

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
	var WidgetElements_RellaxHandler = function( panel, model, view ) {
		//console.log( $scope );
		//alert('Rellax');
		var $scope 		= view.$el;
		var scene = $scope.find('#scene');
		//var parallax = new Rellax( scene[0] );
		
	};

	var WidgetElements_RellaxHandlerFront = function( $scope, $ ){
		//console.log( $scope );
		var elementSettings = get_Dyncontel_ElementSettings( $scope );
		//console.log(elementorFrontend);
		//var $scope 		= $scope;
		//var myitem = $scope.find('.parallax').attr('id');
		
		var rellax = null;
		
		$(window).on('resize',function(){

			  if(rellax){
			  	rellax.destroy();
			  	if( rellax ) initRellax();
			  }
			  
		})
		var initRellax = function(){
			if(elementSettings.enabled_rellax){

				currentDevice = elementorFrontend.getCurrentDeviceMode();

				var setting_speed = 'speed_rellax';
				var value_speed = 0;

				if( currentDevice != 'desktop' ){
					setting_speed = 'speed_rellax_'+currentDevice;
				}
				if( eval('elementSettings.'+setting_speed+'.size') ) value_speed = eval('elementSettings.'+setting_speed+'.size');

				//alert('Rellax '+$scope.data('id'));
				var rellaxId = '#rellax-'+$scope.data('id');
				//alert(elementorFrontend.getCurrentDeviceMode());
				//if( rellax ) rellax.destroy();
				
				rellax = new Rellax(rellaxId
				,{
				
					    speed: value_speed,
					    
					    //center: true
					    /*wrapper: '.elementor',
					    relativeToWrapper: true,*/
					    
					    //round: true,
					    //vertical: 'yes' === elementSettings.vertical_rellax,
					    //horizontal: 'yes' === elementSettings.horizontal_rellax,
					  }  
				);
				//var parallax = new Rellax( scene[0] );
				
				//alert(elementSettings.horizontal_rellax);
				isRellax = true;
			};
		};
		initRellax();
		
	};


	// Make sure you run this code under Elementor..
	$( window ).on( 'elementor/frontend/init', function() {
		//alert('test rellax');
		//elementor.hooks.addAction( 'panel/open_editor/widget/dyncontel-rellax', WidgetElements_RellaxHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/global', WidgetElements_RellaxHandlerFront );
	} );
} )( jQuery );