<?php
namespace PowerpackElements\Classes;

class PP_Elements_WPML {
    public function __construct()
    {
		add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'translate_fields' ) );
		$this->type = 'widgetType';
	}
	
	public function translate_fields ( $widgets ) {
		$widgets[ 'pp-business-hours' ]       = [
			'conditions' => [ $this->type => 'pp-business-hours' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Business_Hours'
		];
		$widgets[ 'pp-caldera-forms' ]        = [
			'conditions' => [ $this->type => 'pp-caldera-forms' ],
			'fields'     => [
				[
					'field'       => 'form_title_custom',
					'type'        => __( 'Caldera Forms - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'form_description_custom',
					'type'        => __( 'Caldera Forms - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];
		$widgets[ 'pp-contact-form-7' ]       = [
			'conditions' => [ $this->type => 'pp-contact-form-7' ],
			'fields'     => [
				[
					'field'       => 'form_title_text',
					'type'        => __( 'Contact Form 7 - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'form_description_text',
					'type'        => __( 'Contact Form 7 - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];
		$widgets[ 'pp-countdown' ]            = [
			'conditions' => [ $this->type => 'pp-countdown' ],
			'fields'     => [
				[
					'field'       => 'fixed_expire_message',
					'type'        => __( 'Countdown - Fixed Expiry Message', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'fixed_redirect_link',
					'type'        => __( 'Countdown - Fixed Redirect Link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'evergreen_expire_message',
					'type'        => __( 'Countdown - Evergreen Expire Message', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'evergreen_redirect_link',
					'type'        => __( 'Countdown - Evergreen Redirect Link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_years_plural',
					'type'        => __( 'Countdown - Years in Plural', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_years_singular',
					'type'        => __( 'Countdown - Years in Singular', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_months_plural',
					'type'        => __( 'Countdown - Months in Plural', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_months_singular',
					'type'        => __( 'Countdown - Months in Singular', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_days_plural',
					'type'        => __( 'Countdown - Days in Plural', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_days_singular',
					'type'        => __( 'Countdown - Days in Singular', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_hours_plural',
					'type'        => __( 'Countdown - Hours in Plural', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_hours_singular',
					'type'        => __( 'Countdown - Hours in Singular', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_minutes_plural',
					'type'        => __( 'Countdown - Minutes in Plural', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_minutes_singular',
					'type'        => __( 'Countdown - Minutes in Singular', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_seconds_plural',
					'type'        => __( 'Countdown - Seconds in Plural', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'label_seconds_singular',
					'type'        => __( 'Countdown - Seconds in Singular', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-counter' ]              = [
			'conditions' => [ $this->type => 'pp-counter' ],
			'fields'     => [
				[
					'field'       => 'number_prefix',
					'type'        => __( 'Counter - Number Prefix', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'number_suffix',
					'type'        => __( 'Counter - Number Suffix', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'counter_title',
					'type'        => __( 'Counter - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-divider' ]              = [
			'conditions' => [ $this->type => 'pp-divider' ],
			'fields'     => [
				[
					'field'       => 'divider_text',
					'type'        => __( 'Divider - Divider Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-dual-heading' ]         = [
			'conditions' => [ $this->type => 'pp-dual-heading' ],
			'fields'     => [
				[
					'field'       => 'first_text',
					'type'        => __( 'Dual Heading - First Text', 'powerpack' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'second_text',
					'type'        => __( 'Dual Heading - Second Text', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];
		$widgets[ 'pp-google-maps' ]          = [
			'conditions' => [ $this->type => 'pp-google-maps' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Google_Maps'
		];
		$widgets[ 'pp-gravity-forms' ]        = [
			'conditions' => [ $this->type => 'pp-gravity-forms' ],
			'fields'     => [
				[
					'field'       => 'form_title_custom',
					'type'        => __( 'Gravity Forms - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'form_description_custom',
					'type'        => __( 'Gravity Forms - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];
		$widgets[ 'pp-image-hotspots' ]       = [
			'conditions' => [ $this->type => 'pp-image-hotspots' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Image_Hotspots'
		];
		$widgets[ 'pp-icon-list' ]            = [
			'conditions' => [ $this->type => 'pp-icon-list' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Icon_List'
		];
		$widgets[ 'pp-image-comparison' ]     = [
			'conditions' => [ $this->type => 'pp-image-comparison' ],
			'fields'     => [
				[
					'field'       => 'before_label',
					'type'        => __( 'Image Comparision - Before Label', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'after_label',
					'type'        => __( 'Image Comparision - After Label', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				
			],
		];
		$widgets[ 'pp-info-box' ]             = [
			'conditions' => [ $this->type => 'pp-info-box' ],
			'fields'     => [
				[
					'field'       => 'icon_text',
					'type'        => __( 'Info Box - Icon Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'heading',
					'type'        => __( 'Info Box - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'sub_heading',
					'type'        => __( 'Info Box - Subtitle', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'description',
					'type'        => __( 'Info Box - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'link',
					'type'        => __( 'Info Box - Link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'button_text',
					'type'        => __( 'Info Box - Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				
			],
		];
		$widgets[ 'pp-info-box-carousel' ]    = [
			'conditions' => [ $this->type => 'pp-info-box-carousel' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Info_Box_Carousel'
		];
		$widgets[ 'pp-info-list' ]            = [
			'conditions' => [ $this->type => 'pp-info-list' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Info_List'
		];
		$widgets[ 'pp-info-table' ]           = [
			'conditions' => [ $this->type => 'pp-info-table' ],
			'fields'     => [
				[
					'field'       => 'icon_text',
					'type'        => __( 'Info Table - Icon Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'heading',
					'type'        => __( 'Info Table - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'sub_heading',
					'type'        => __( 'Info Table - Subtitle', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'description',
					'type'        => __( 'Info Table - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'sale_badge_text',
					'type'        => __( 'Info Table - Sale Badge Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'link',
					'type'        => __( 'Info Table - Link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'button_text',
					'type'        => __( 'Info Table - Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				
			],
		];
		$widgets[ 'pp-instafeed' ]            = [
			'conditions' => [ $this->type => 'pp-instafeed' ],
			'fields'     => [
				[
					'field'       => 'insta_link_title',
					'type'        => __( 'Instafeed - Link Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'insta_profile_url',
					'type'        => __( 'Instafeed - Instagram Profile URL', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pa-link-effects' ]         = [
			'conditions' => [ $this->type => 'pa-link-effects' ],
			'fields'     => [
				[
					'field'       => 'text',
					'type'        => __( 'Link Effects - Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'secondary_text',
					'type'        => __( 'Link Effects - Secondary Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'link',
					'type'        => __( 'Link Effects - link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-logo-carousel' ]        = [
			'conditions' => [ $this->type => 'pp-logo-carousel' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Logo_Carousel'
		];
		$widgets[ 'pp-logo-grid' ]            = [
			'conditions' => [ $this->type => 'pp-logo-grid' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Logo_Grid'
		];
		$widgets[ 'pp-modal-popup' ]          = [
			'conditions' => [ $this->type => 'pp-modal-popup' ],
			'fields'     => [
				[
					'field'       => 'title',
					'type'        => __( 'Popup Box - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'popup_link',
					'type'        => __( 'Popup Box - URL', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'content',
					'type'        => __( 'Popup Box - Content', 'powerpack' ),
					'editor_type' => 'VISUAL'
				],
				[
					'field'       => 'custom_html',
					'type'        => __( 'Popup Box - Custom HTML', 'powerpack' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'button_text',
					'type'        => __( 'Popup Box - Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'element_identifier',
					'type'        => __( 'Popup Box - CSS Class or ID', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-ninja-forms' ]          = [
			'conditions' => [ $this->type => 'pp-ninja-forms' ],
			'fields'     => [
				[
					'field'       => 'form_title_custom',
					'type'        => __( 'Ninja Forms - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'form_description_custom',
					'type'        => __( 'Ninja Forms - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];		
		$widgets[ 'pp-one-page-nav' ]         = [
			'conditions' => [ $this->type => 'pp-one-page-nav' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_One_Page_Nav'
		];
		$widgets[ 'pp-price-menu' ]           = [
			'conditions' => [ $this->type => 'pp-price-menu' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Price_Menu'
		];
		$widgets[ 'pp-pricing-table' ]        = [
			'conditions' => [ $this->type => 'pp-pricing-table' ],
			'fields'     => [
				[
					'field'       => 'table_title',
					'type'        => __( 'Pricing Table - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'table_subtitle',
					'type'        => __( 'Pricing Table - Subtitle', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'table_price',
					'type'        => __( 'Pricing Table - Price', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'table_original_price',
					'type'        => __( 'Pricing Table - Origibal Price', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'table_duration',
					'type'        => __( 'Pricing Table - Duration', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'table_button_text',
					'type'        => __( 'Pricing Table - Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'link',
					'type'        => __( 'Pricing Table - Link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'table_additional_info',
					'type'        => __( 'Pricing Table - Additional Info', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
			'integration-class' => 'WPML_PP_Pricing_Table'
		];
		$widgets[ 'pp-promo-box' ]            = [
			'conditions' => [ $this->type => 'pp-promo-box' ],
			'fields'     => [
				[
					'field'       => 'heading',
					'type'        => __( 'Promo Box - Heading', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'sub_heading',
					'type'        => __( 'Promo Box - Sub Heading', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'content',
					'type'        => __( 'Promo Box - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'button_text',
					'type'        => __( 'Promo Box - Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'link',
					'type'        => __( 'Promo Box - link', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-team-member' ]          = [
			'conditions' => [ $this->type => 'pp-team-member' ],
			'fields'     => [
				[
					'field'       => 'team_member_name',
					'type'        => __( 'Team Member - Name', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'team_member_position',
					'type'        => __( 'Team Member - Position', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'team_member_description',
					'type'        => __( 'Team Member - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
			'integration-class' => 'WPML_PP_Team_Member'
		];
		$widgets[ 'pp-team-member-carousel' ] = [
			'conditions' => [ $this->type => 'pp-team-member-carousel' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Team_Member_Carousel'
		];
		$widgets[ 'pp-tiled-posts' ]          = [
			'conditions' => [ $this->type => 'pp-tiled-posts' ],
			'fields'     => [
				[
					'field'       => 'read_more_text',
					'type'        => __( 'Tiled Posts - Read More Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'offset',
					'type'        => __( 'Tiled Posts - Offset', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'post_meta_divider',
					'type'        => __( 'Tiled Posts - Post Meta Divider', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];
		$widgets[ 'pp-toggle' ]               = [
			'conditions' => [ $this->type => 'pp-toggle' ],
			'fields'     => [
				[
					'field'       => 'primary_label',
					'type'        => __( 'Toggle - Primary Label', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'primary_content',
					'type'        => __( 'Toggle - Primary Content', 'powerpack' ),
					'editor_type' => 'VISUAL'
				],
				[
					'field'       => 'secondary_label',
					'type'        => __( 'Toggle - Secondary Label', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'secondary_content',
					'type'        => __( 'Toggle - Secondary Content', 'powerpack' ),
					'editor_type' => 'VISUAL'
				],
			],
		];
		$widgets[ 'pp-wpforms' ]              = [
			'conditions' => [ $this->type => 'pp-wpforms' ],
			'fields'     => [
				[
					'field'       => 'form_title_custom',
					'type'        => __( 'WPForms - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'form_description_custom',
					'type'        => __( 'WPForms - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
			],
		];
		$widgets[ 'pp-recipe' ]               = [
			'conditions' => [ $this->type => 'pp-recipe' ],
			'fields'     => [
				[
					'field'       => 'recipe_name',
					'type'        => __( 'Recipe - Name', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'recipe_description',
					'type'        => __( 'Recipe - Description', 'powerpack' ),
					'editor_type' => 'AREA'
				],
				[
					'field'       => 'prep_time',
					'type'        => __( 'Recipe - Prep Time', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'cook_time',
					'type'        => __( 'Recipe - Cook Time', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'total_time',
					'type'        => __( 'Recipe - Total Time', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'servings',
					'type'        => __( 'Recipe - Servings', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'calories',
					'type'        => __( 'Recipe - Calories', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'item_notes',
					'type'        => __( 'Recipe - Item Notes', 'powerpack' ),
					'editor_type' => 'VISUAL'
				],
			],
			'integration-class' => 'WPML_PP_Recipe'
		];
		$widgets[ 'pp-offcanvas-content' ]     = [
			'conditions' => [ $this->type => 'pp-offcanvas-content' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => __( 'Offcanvas Content - Toggle Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				
			],
			'integration-class' => 'WPML_PP_Offcanvas_Content'
		];
		$widgets[ 'pp-showcase' ]               = [
			'conditions' => [ $this->type => 'pp-showcase' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Showcase'
		];
		$widgets[ 'pp-timeline' ]               = [
			'conditions' => [ $this->type => 'pp-timeline' ],
			'fields'     => [
				[
					'field'       => 'button_text',
					'type'        => __( 'Timeline - Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
			'integration-class' => 'WPML_PP_Timeline'
		];
		$widgets[ 'pp-image-accordion' ]               = [
			'conditions' => [ $this->type => 'pp-image-accordion' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Image_Accordion'
		];
		$widgets[ 'pp-advanced-accordion' ]               = [
			'conditions' => [ $this->type => 'pp-advanced-accordion' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Advanced_Accordion'
		];
		$widgets[ 'pp-advanced-tabs' ]               = [
			'conditions' => [ $this->type => 'pp-advanced-tabs' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Advanced_Tabs'
		];
		$widgets[ 'pp-breadcrumbs' ]               = [
			'conditions' => [ $this->type => 'pp-breadcrumbs' ],
			'fields'     => [
				[
					'field'       => 'home_text',
					'type'        => __( 'Breadcrumbs - Home Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'blog_text',
					'type'        => __( 'Breadcrumbs - Blog Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'separator_text',
					'type'        => __( 'Breadcrumbs - Separator Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-video' ]               = [
			'conditions' => [ $this->type => 'pp-video' ],
			'fields'     => [
				[
					'field'       => 'youtube_url',
					'type'        => __( 'Video - YouTube URL', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'vimeo_url',
					'type'        => __( 'Video - Vimeo URL', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'dailymotion_url',
					'type'        => __( 'Video - Dailymotion URL', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'start_time',
					'type'        => __( 'Video - Start Time', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'end_time',
					'type'        => __( 'Video - End Time', 'power-pack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-video-gallery' ]               = [
			'conditions' => [ $this->type => 'pp-video-gallery' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Video_Gallery'
		];
		$widgets[ 'pp-testimonials' ]               = [
			'conditions' => [ $this->type => 'pp-testimonials' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Testimonials'
		];
		$widgets[ 'pp-buttons' ]               = [
			'conditions' => [ $this->type => 'pp-buttons' ],
			'fields'     => [],
			'integration-class' => 'WPML_PP_Buttons'
		];
		$widgets[ 'pp-flipbox' ]               = [
			'conditions' => [ $this->type => 'pp-flipbox' ],
			'fields'     => [
				[
					'field'       => 'title_front',
					'type'        => __( 'Flip Box - Front Title', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'description_front',
					'type'        => __( 'Flip Box - Front Description', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'title_back',
					'type'        => __( 'Flip Box - Back Title', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'description_back',
					'type'        => __( 'Flip Box - Back Description', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'link',
					'type'        => __( 'Flip Box - Link', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'flipbox_button_text',
					'type'        => __( 'Flip Box - Button Text', 'power-pack' ),
					'editor_type' => 'LINE'
				],
			],
		];
		$widgets[ 'pp-image-gallery' ]               = [
			'conditions' => [ $this->type => 'pp-image-gallery' ],
			'fields'     => [
				[
					'field'       => 'filter_label',
					'type'        => __( 'Image Gallery - Filter Label', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'filter_all_label',
					'type'        => __( 'Image Gallery - "All" Filter Label', 'power-pack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'load_more_text',
					'type'        => __( 'Image Gallery - Load More Button Text', 'power-pack' ),
				],
			],
		];
		$widgets[ 'pp-album' ]               = [
			'conditions' => [ $this->type => 'pp-album' ],
			'fields'     => [
				[
					'field'       => 'album_trigger_button_text',
					'type'        => __( 'Album - Trigger Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'album_title',
					'type'        => __( 'Album - Title', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'album_subtitle',
					'type'        => __( 'Album - Subtitle', 'powerpack' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'album_cover_button_text',
					'type'        => __( 'Album - Cover Button Text', 'powerpack' ),
					'editor_type' => 'LINE'
				],
			],
		];

		$this->init_classes();
		
		return $widgets;
	}
	
	private function init_classes() {
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-business-hours.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-google-maps.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-image-hotspots.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-icon-list.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-info-box-carousel.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-info-list.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-logo-carousel.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-logo-grid.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-one-page-nav.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-price-menu.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-pricing-table.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-team-member.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-team-member-carousel.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-recipe.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-offcanvas-content.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-showcase.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-timeline.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-image-accordion.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-advanced-accordion.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-advanced-tabs.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-video-gallery.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-testimonials.php';
		require_once POWERPACK_ELEMENTS_PATH . 'classes/wpml/class-wpml-pp-buttons.php';
	}
}

$pp_elements_wpml = new PP_Elements_WPML();
