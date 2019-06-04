( function( $ ) {
	

	var get_Dyncontel_ElementSettings = function( $element ) {
		
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
	
	var WidgetElements_SvgMorphHandler = function( $scope, $ ) {
		//console.log( $scope );
		//alert('svg');


		var elementSettings = get_Dyncontel_ElementSettings( $scope );
		var id_scope = $scope.attr('data-id');
		//alert(elementSettings.repeater_shape_polygon);
		//console.log(elementSettings);
		// il tipo di forma: path | polygon | circle | ECC..
		var forma = elementSettings.type_of_shape;
		// --------------------------------------------------
		const DOM = {};
		//DOM.svg = document.querySelector('#dce-svg-'+id_scope);
		//DOM.shapeEl = DOM.svg.querySelector('#forma-'+id_scope);

		var step;

		var intervallo;
		var is_running = false;

		// ciclo il ripetitore in base alla Forma
		var ripetitore = 'repeater_shape_'+forma;
		eval('var repeaterShape = elementSettings.'+ripetitore);

		var contentElemsTotal = repeaterShape.length;
		if( elementorFrontend.isEditMode()){

		}else{

		}
		var duration_anim = elementSettings.duration_morph.size;
		var speed_anim = elementSettings.speed_morph.size;
		//console.log(repeaterShape);
		//alert(repeaterShape.length);
		
		var numberOfElements = repeaterShape.length;
		var shapes = [];
		var tweensKute = [];
		var iniziaShapes = function(){
			numberOfElements = repeaterShape.length;
			shapes = [];
			//
			for( var i = 0; i < numberOfElements; i++){
				if( elementorFrontend.isEditMode()){
					var id_shape = repeaterShape.models[i].attributes.id_shape;
					var points = repeaterShape.models[i].attributes.shape_numbers;
					// var x_position = repeaterShape.models[i].attributes.x_position.size;
					// var y_position = repeaterShape.models[i].attributes.y_position.size;
					// var rotate = repeaterShape.models[i].attributes.rotate.size;
					// var scale = repeaterShape.models[i].attributes.scale.size;
					var fillColor = repeaterShape.models[i].attributes.fill_color;
					var strokeColor = repeaterShape.models[i].attributes.stroke_color;
					var strokeWidth = repeaterShape.models[i].attributes.stroke_width.size;
				}else{
					var id_shape = repeaterShape[i].id_shape;
					var points = repeaterShape[i].shape_numbers;
					// var x_position = repeaterShape[i].x_position.size;
					// var y_position = repeaterShape[i].y_position.size;
					// var rotate = repeaterShape[i].rotate.size;
					// var scale = repeaterShape[i].scale.size;
					var fillColor = repeaterShape[i].fill_color;
					var strokeColor = repeaterShape[i].stroke_color;
					var strokeWidth = repeaterShape[i].stroke_width.size;
				}
				var objRep = {
					//d: points,
					points: points,
					//scaleX: scale,
					//scaleY: scale,
					//rotate: rotate,
					//tx: x_position,
					//ty: y_position,
					path: {
						duration: duration_anim || 700,
						easing: 'easeOutQuad',
						elasticity: 600
					},
					fill: {
						color: fillColor,
						duration: duration_anim || 700,
						easing: 'linear'
					},
					stroke: {
						width: strokeWidth,
						color: strokeColor
					},
					animation: {
						points: {
							duration: duration_anim,
							easing: 'easeOutElastic',
							elasticity: 600
						},
						svg: {
							duration: duration_anim,
							easing: 'easeOutElastic',
							elasticity: 600
						}
					}
				}
				shapes.push(objRep);
			} // end for ripeater
			
			//console.log(shapes);
			//
			const dots = [];
			for( var i = 0; i < repeaterShape.length; i++){
				dots[i] = {value: shapes[i].points, duration:3500};

			}
			/*
			easingSinusoidalInOut, 
			easingQuadraticInOut, 
			easingCubicInOut,
			easingQuarticInOut, 
			easingQuinticInOut, 
			easingCircularInOut,
			easingExponentialInOut.
			*/
			tweensKute = [];
			for (var i = 0; i < numberOfElements; i++){
					if($("#forma-"+id_scope).length){
						var tweenKute = KUTE.to("#forma-"+id_scope, { path: shapes[i].points, attr:{fill:shapes[i].fill.color, 'stroke-width':shapes[i].stroke.width, stroke:shapes[i].stroke.color}/*, draw:'0% 100%'*/ }, {
						    //repeat: 1,
						    //yoyo: true,
						    duration: elementSettings.duration_morph.size || 700, //Number(elementSettings.speed_morph.size),
						    delay: elementSettings.delay_morph.size || 0,
						    easing: elementSettings.easing_kute || 'easingElasticOut',

						    morphPrecision: 4,
						    morphIndex: 127,
						});
						tweensKute.push(tweenKute);
					}
				}
		} // end IniziaShapes



		/*var scambia_kute = function(idx, oldIdx){
			//alert(strokeWidth);
			//console.log(shapes);
			//
			// if(oldIdx >= 0){
			// 	tweensKute[oldIdx].chain(tweensKute[idx]);
			// }else{
				//
				//alert(tweensKute[idx]);
				//if(tweensKute[idx]) tweensKute[idx].start();
			//}
			
		}*/
		var scambia_points = function(idx, oldIdx){
			//alert('scambio'+idx);
			anime.remove("#forma-"+id_scope);
			anime({
					targets: "#forma-"+id_scope,
					duration: elementSettings.duration_morph.size,
					easing: elementSettings.easing_morph,
					elasticity: shapes[idx].animation.points.elasticity || 600,
					points: shapes[idx].points,
					fill: {
						value: shapes[idx].fill.color,
						duration: shapes[idx].fill.duration,
						easing: shapes[idx].fill.easing
					},
					stroke: {
						value: shapes[idx].stroke.color,
						duration: shapes[idx].fill.duration,
						easing: shapes[idx].fill.easing
					},
					strokeWidth: {
						value: shapes[idx].stroke.width,
						duration: shapes[idx].fill.duration,
						easing: shapes[idx].fill.easing
					}
				});
		}
		var playShapeEl = function() {
			var count = 0;
			var oldCount = -1;
			is_running = true;

			if($("#dce-svg-"+id_scope).attr('data-run') == 'paused') speed_anim = 100;
			//alert("#forma-"+id_scope);
			//alert($("#dce-svg-"+id_scope).attr('data-run'));
			//scambia_kute(count, oldCount);
			setInterval(function(){ 
				iniziaShapes();
				//
				//$scope.append('m: '+tweensKute[count]+' ');
				//
				if(count != oldCount){
					//alert(forma);
					if(forma == 'path'){
						//scambia_kute(count, oldCount);

						if (typeof tweensKute[count] != undefined) tweensKute[count].start();
					}else{
						//alert(forma);
						scambia_points(count, oldCount);
					}
				}
				oldCount = count;
				count = $('#dce-svg-'+id_scope).attr('data-morphid');






				if($('#dce-svg-'+id_scope).attr('data-run') == 'running'){
					
					if(count < contentElemsTotal - 1){ 
						count ++;
					}else{
						count = 0;
					}
					//cambio l'indice del morphing nell'intervallo solo se sono in running
					$('#dce-svg-'+id_scope).attr('data-morphid',count);	
				}else{

				}
				
				//alert('count: '+count+' '+shapes[count].points);
				
			}, speed_anim);
			//alert('play '+intervallo);
			//console.log(intervallo);
		}
		/*var stopShapeEl = function() {
			is_running = false;
			//alert(intervallo);
			window.clearInterval(intervallo);
			
			if(forma == 'path'){
				for (var i = 0; i < numberOfElements; i++) {
				  tweensKute[i].stop();
				}
			}else{
				anime.remove("#forma-"+id_scope);
			}
			
		} */
		
		//alert($('#dce-svg-'+id_scope).attr('data-run'));
		if( $('#dce-svg-'+id_scope).attr('data-run') == 'running'){
			
		}else{
			//stopShapeEl();
			//tweenKute.stop();
		}
		// in frontend rendo obbligatorio l'animazione se sono con più di un elemento
		if(!elementorFrontend.isEditMode() && contentElemsTotal > 1){ 
			$('#dce-svg-'+id_scope).attr('data-run','running');
		}
		if(contentElemsTotal > 1) playShapeEl();
		/*$('#dce-svg-'+id_scope).on('changeDataMorph', function (e) {    
		    alert('My Custom Event - Change Data Called! for ' + this.morphid);
		});*/
		/*$(document).on('data-attribute-changed', function() {
			
		    var data = $('#dce-svg-'+id_scope).data('morphid');
		    alert('Data changed to: ' + data);
		  });*/
	};

	// Make sure you run this code under Elementor..
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dyncontel-svgmorphing.default', WidgetElements_SvgMorphHandler );
		//console.log(elementorFrontend);
		
		/*var editor, editedModel, replyToControl;
		elementor.hooks.addAction( 'panel/open_editor/widget/dyncontel-svgmorphing', function( panel, model, view ) {
			alert('sss');

			editor = panel.getCurrentPageView();

			var $element = view.$el.find( '.elementor-selector' );

		   	if ( $element.length ) {
		   	$element.click( function() {
		   	  alert( 'Some Message' );
		   	} );
		   }
		} );*/
		
	} );
	//alert('svgMorph');
} )( jQuery );
