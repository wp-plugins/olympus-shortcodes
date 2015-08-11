<?php
/**
 * Shortcode Functions
 *
 * Render the shortcodes
 *
 * @package     olympus-shortcodes
 * @copyright   Copyright (c) 2015, Danny Cooper
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Allow shortcodes in widgets
 */
add_filter( 'widget_text', 'do_shortcode' );


/**
 * Remove the extraneous p and br tags that are generated when wpautop processes content prior to shortcodes.
 *
 * @param string $content User inputted content.ted content.
 */
function olympus_fix_shortcodes($content) {
	$array = array(
		'<p>['		=> '[',
		']</p>'		=> ']',
		']<br />'	=> ']',
	);
	$content = strtr( $content, $array );
	return $content;
}

add_filter( 'the_content', 'olympus_fix_shortcodes' );


/**
 * Clear Floats
 *
 * @param array $atts Shortcode attributes.
 */
function olympus_clear_floats_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'margin'			=> '',
	), $atts ) );
	return '<div class="olympus-clear-floats" style="margin-bottom:' . $margin . '"></div>';
}

add_shortcode( 'olympus_clear', 'olympus_clear_floats_shortcode' );


/**
 * Call to Action
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.ted content.
 */
function olympus_cta_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'button_text'			=> '',
		'button_color'			=> 'blue',
		'button_url'			=> 'http://olympusthemes.com',
		'button_target'			=> 'blank',
		'button_size'			=> '',
		'class'					=> '',
	), $atts ) );
	$output = '<div class="olympus-cta olympus-clearfix '. $class .'">';
	if ( '' !== $button_text ) {
		$output .= '<div class="olympus-cta-button">';
			$output .= '<a href="'. esc_url( $button_url ) .'" title="'. $button_text .'" target="_'. $button_target .'" class="olympus-button '. $button_size .' '.$button_color .'"><span class="olympus-button-inner">';
			$output .= $button_text;
		$output .= '</span></a>';
		$output .= '</div>';
	}
	$output .= '<div class="olympus-cta-caption">';
		$output .= do_shortcode( $content );
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}

add_shortcode( 'olympus_cta', 'olympus_cta_shortcode' );



/**
 * Spacing
 *
 * @param array $atts Shortcode attributes.
 */
function olympus_spacing_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'size'	=> '20px',
		'class'	=> '',
		),
	$atts ) );
	return '<hr class="olympus-spacing '. $class .'" style="height: '. intval( $size ) .'px" />';
}

add_shortcode( 'olympus_spacing', 'olympus_spacing_shortcode' );

/**
 * Social Icons
 *
 * @param array $atts Shortcode attributes.
 */
function olympus_social_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'icon'				=> 'twitter',
		'url'				=> 'http://www.twitter.com/',
		'title'				=> '',
		'target'			=> 'self',
	), $atts ) );
	$icon_name = 'olympus_' . $icon . '_url';
	return '<a href="' . esc_url( $url ) . '" class="olympus-social-icon '. $icon_name .'" target="_'.$target.'" title="'. $title .'"></a>';
}

add_shortcode( 'olympus_social', 'olympus_social_shortcode' );

/**
 * Highlights
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.ted content.
 */
function olympus_highlight_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color'			=> 'yellow',
		),
	$atts ) );
	return '<span class="olympus-highlight olympus-highlight-' . $color . '">' . do_shortcode( $content ) . '</span>';

}

add_shortcode( 'olympus_highlight', 'olympus_highlight_shortcode' );


/**
 * Buttons
 *
 * @param array $atts Shortcode attributes.
 */
function olympus_button_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'text'				=> 'Click Me!',
		'color'				=> 'blue',
		'url'				=> 'https://olympusthemes.com',
		'target'			=> 'self',
		'size'				=> '',
		'class'				=> '',
	), $atts ) );
	$button = '';
	$button .= '<a href="' . $url . '" class="olympus-button '. $size .' ' . $color . ' '. $class .'" target="_'.$target.'">';
		$button .= '<span class="olympus-button-inner">';

			$button .= $text;

		$button .= '</span>';
	$button .= '</a>';
	return $button;
}

add_shortcode( 'olympus_button', 'olympus_button_shortcode' );


/**
 * Boxes
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.ted content.
 */
function olympus_box_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color'				=> 'gray',
		'float'				=> 'center',
		'text_align'		=> 'left',
		'width'				=> '100%',
		'margin_top'		=> null,
		'margin_bottom'		=> null,
		'class'				=> '',
	), $atts ) );
	$style_attr = '';
	if ( $margin_bottom ) {
		$style_attr .= 'margin-bottom: '. $margin_bottom .';';
	}
	if ( $margin_top ) {
		$style_attr .= 'margin-top: '. $margin_top .';';
	}
	$alert_content = '';
	$alert_content .= '<div class="olympus-box  ' . $color . ' '. $class .'" style="text-align:'. $text_align .'; '. $style_attr .'">';
	$alert_content .= ' '. do_shortcode( $content ) .'</div>';
	return $alert_content;
}

add_shortcode( 'olympus_box', 'olympus_box_shortcode' );


/**
 * Columns
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_column_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'size'			=> 'one-third',
		'position'		=> '',
		'class'			=> '',
	), $atts ) );
	return '<div class="olympus-column olympus-' . $size . ' olympus-column-'.$position.' '. $class .'">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'olympus_column', 'olympus_column_shortcode' );


/**
 * Toggle
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_toggle_shortcode( $atts, $content = null ) {

	wp_enqueue_script( 'olympus-shortcode-scripts' );
	
	extract( shortcode_atts( array(
		'title'			=> 'Toggle Title',
		'class'			=> '',
	), $atts ) );

	// Display the Toggle.
	return '<div class="olympus-toggle '. $class .'"><h3 class="olympus-toggle-trigger">'. $title .'</h3><div class="olympus-toggle-container">' . do_shortcode( $content ) . '</div></div>';
}

add_shortcode( 'olympus_toggle', 'olympus_toggle_shortcode' );


/**
 * Accordion Outer
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_accordion_main_shortcode( $atts, $content = null  ) {

	wp_enqueue_script( 'olympus-shortcode-scripts' );	
	
	extract( shortcode_atts( array(
		'title'			=> 'Accordian Title',
		'class'			=> '',
	), $atts ) );

	// Display the accordion.
	return '<div class="olympus-accordion '. $class .'">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'olympus_accordion', 'olympus_accordion_main_shortcode' );


/**
 * Accordion Inner
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_accordion_inner_shortcode( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'title'	=> 'Title',
		'class'	=> '',
	), $atts ) );
	return '<h3 class="olympus-accordion-trigger '. $class .'"><a href="#">'. $title .'</a></h3><div>' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'olympus_accordion_item', 'olympus_accordion_inner_shortcode' );


/**
 * Tabs
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_tabs_shortcode( $atts, $content = null ) {

	wp_enqueue_script( 'olympus-shortcode-scripts' );

	// Display Tabs.
	$defaults = array();
	extract( shortcode_atts( $defaults, $atts ) );
	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();
	if ( isset( $matches[1] ) ) { $tab_titles = $matches[1]; }
	$output = '';
	if ( count( $tab_titles ) ) {
		$output .= '<div id="olympus-tab-'. rand( 1, 100 ) .'" class="olympus-tabs">';
		$output .= '<ul class="ui-tabs-nav olympus-clearfix">';
		foreach ( $tab_titles as $tab ) {
			$output .= '<li><a href="#olympus-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
		}
		$output .= '</ul>';
		$output .= do_shortcode( $content );
		$output .= '</div>';
	} else {
		$output .= do_shortcode( $content );
	}
	return $output;
}

add_shortcode( 'olympus_tabs', 'olympus_tabs_shortcode' );

/**
 * Tabs
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_tab_shortcode( $atts, $content = null ) {
	$defaults = array(
		'title'			=> '',
		'class'			=> '',
	);
	extract( shortcode_atts( $defaults, $atts ) );
	return '<div id="olympus-tab-'. sanitize_title( $title ) .'" class="tab-content ' . $class . '">'. do_shortcode( $content ) .'</div>';
}

add_shortcode( 'olympus_tab', 'olympus_tab_shortcode' );


/**
 * Slider
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_slider_shortcode( $atts, $content = null ) {

	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'olympus-shortcode-scripts' );
	wp_enqueue_style( 'flexslider' );

	return '<div class="olympus-slider-container flexslider"><ul class="olympus-slider slides">'. do_shortcode( $content ) .'</ul></div>';
}

add_shortcode( 'olympus_slider', 'olympus_slider_shortcode' );

/**
 * Individual Slide
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_slide_shortcode( $atts, $content = null ) {
	$defaults = array(
		'img'			=> 'https://placeholdit.imgix.net/~text?txtsize=33&txt=700×300&w=700&h=300',
		'url'			=> '',
	);
	extract( shortcode_atts( $defaults, $atts ) );
	return '<li><a href="' . esc_url( $url ) . '"><img src="' . esc_url( $img ) . '" /></a></li>';
}

add_shortcode( 'olympus_slide', 'olympus_slide_shortcode' );

/**
 * Heading
 *
 * @param array $atts Shortcode attributes.
 */
function olympus_heading_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'title'			=> __( 'Sample Heading', 'olympus-toolkit' ),
		'type'			=> 'h2',
		'style'			=> 'double-line',
		'margin_top'	=> '',
		'margin_bottom'	=> '',
		'text_align'	=> '',
		'font_size'		=> '',
		'color'			=> '',
		'class'			=> '',
		),
	$atts ) );

	$style_attr = '';
	if ( $font_size ) {
		$style_attr .= 'font-size: '. $font_size .';';
	}
	if ( $color ) {
		$style_attr .= 'color: '. $color .';';
	}
	if ( $margin_bottom ) {
		$style_attr .= 'margin-bottom: '. intval( $margin_bottom ) .'px;';
	}
	if ( $margin_top ) {
		$style_attr .= 'margin-top: '. intval( $margin_top ) .'px;';
	}

	if ( $text_align ) {
		$text_align = 'text-align-'. $text_align;
	} else {
		$text_align = 'text-align-left';
	}

	$output = '<'.$type.' class="olympus-heading olympus-heading-'. $style .' '. $text_align .' '. $class .'" style="'.$style_attr.'"><span>';
		$output .= $title;
	$output .= '</'.$type.'></span>';

	return $output;
}

add_shortcode( 'olympus_heading', 'olympus_heading_shortcode' );


/**
 * Google Maps
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content User inputted content.
 */
function olympus_shortcode_googlemaps($atts, $content = null) {

	wp_enqueue_script( 'google-maps' );
	wp_enqueue_script( 'olympus-shortcode-scripts' );	
	
	extract(shortcode_atts(array(
			'title'			=> '',
			'location'		=> '',
			'width'			=> '',
			'height'		=> '300',
			'zoom'			=> 8,
			'align'			=> '',
			'class'			=> '',
	), $atts));

	$output = '<div id="map_canvas_'.rand( 1, 100 ).'" class="googlemap '. $class .'" style="height:'.$height.'px;width:100%">';
		$output .= ( ! empty( $title )) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
		$output .= '<input class="location" type="hidden" value="'.$location.'" />';
		$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
		$output .= '<div class="map_canvas"></div>';
	$output .= '</div>';

	return $output;
}

add_shortcode( 'olympus_gmap', 'olympus_shortcode_googlemaps' );


/**
 * Divider
 *
 * @param array $atts Shortcode attributes.
 */
function olympus_divider_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'style'				=> 'solid',
		'margin_top'		=> '20px',
		'margin_bottom'		=> '20px',
		'color'				=> '',
		'class'				=> '',
		),
	$atts ) );
	$style_attr = 'style="';

	if ( $margin_bottom ) {
		$style_attr .= 'margin-bottom: ' . intval( $margin_bottom ) .'px;';
	}

	if ( $margin_top ) {
		$style_attr .= 'margin-top: ' . intval( $margin_top ) .'px;';
	}

	if ( $color ) {
		$style_attr .= 'border-color: ' . $color ;
	}

	$style_attr .= '"';

	return '<hr class="olympus-divider '. $style .' '. $class .'" '.$style_attr.' />';
}

add_shortcode( 'olympus_divider', 'olympus_divider_shortcode' );

/**
 * Font Awesome
 *
 * @param array $atts Shortcode attributes.
 */
function fa_function( $atts ) {

	wp_enqueue_style( 'font-awesome' );

	$atts = shortcode_atts( array(
		'type' => '',
	), $atts );
	$class  = 'fa ';
	$class .= ( $atts['type'] ) ? $atts['type'] : '';

	return sprintf(
		'<i class="%s"></i>',
		esc_attr( $class )
	);
}

add_shortcode( 'olympus_icon', 'fa_function' );


