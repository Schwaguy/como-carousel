<?php
/*
Plugin Name: Como Carousel
Plugin URI: http://www.comocreative.com/
Version: 4.1.3
Author: Como Creative LLC
Description: Plugin designed to enable easy Bootstrap Carousel Creation.  <strong>Bootstrap 3 CSS and jQuery scripts required.</strong>  Carousels can be inserted into a page or post by using shortcode:   [comocarousel name=slider-slug template=TEMPLATE type=slide/fade indicators=show/hide controls=show/hide captions=show/hide interval=2000 pause=true/false orderby=DATE/TITLE/MENU_ORDER order=ASC/DESC]
*/
defined('ABSPATH') or die('No Hackers!');
/* Include plugin updater. */
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/updater.php' );
function comoCarousel_script_enqueue() {
	if( is_admin() ) {
		global $typenow;
		if( $typenow == 'comoslide' ) {
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('meta-box-color-carousel', plugins_url('js/meta-box-colorpicker.js', __FILE__), array('wp-color-picker'));
		}
	}
}
add_action( 'admin_enqueue_scripts', 'comoCarousel_script_enqueue' );
/* ##################### Define Carousel Slide Post Type ##################### */
if ( ! function_exists('comoslide_post_type') ) {
	function comoslide_post_type() {
		$labels = array(
			'name'                  => _x('Carousel Slides', 'Post Type General Name', 'como-carousel' ),
			'singular_name'         => _x('Carousel Slide', 'Post Type Singular Name', 'como-carousel' ),
			'menu_name'             => __('Carousel Slides', 'como-carousel' ),
			'name_admin_bar'        => __('Carousel Slide', 'como-carousel' ),
			'archives'              => __('Slide Archives', 'como-carousel' ),
			'parent_item_colon'     => __('Parent Slide:', 'como-carousel' ),
			'all_items'             => __('All Slides', 'como-carousel' ),
			'add_new_item'          => __('Add New Slide', 'como-carousel' ),
			'add_new'               => __('Add New', 'como-carousel' ),
			'new_item'              => __('New Slide', 'como-carousel' ),
			'edit_item'             => __('Edit Slide', 'como-carousel' ),
			'update_item'           => __('Update Slide', 'como-carousel' ),
			'view_item'             => __('View Slide', 'como-carousel' ),
			'search_items'          => __('Search Slides', 'como-carousel' ),
			'not_found'             => __('Not found', 'como-carousel' ),
			'not_found_in_trash'    => __('Not found in Trash', 'como-carousel' ),
			'featured_image'        => __('Slide Image', 'como-carousel' ),
			'set_featured_image'    => __('Set slide image', 'como-carousel' ),
			'remove_featured_image' => __('Remove slide image', 'como-carousel' ),
			'use_featured_image'    => __('Use as slide image', 'como-carousel' ),
			'insert_into_item'      => __('Insert into carousel', 'como-carousel' ),
			'uploaded_to_this_item' => __('Uploaded to this slide', 'como-carousel' ),
			'items_list'            => __('Slide list', 'como-carousel' ),
			'items_list_navigation' => __('Slide list navigation', 'como-carousel' ),
			'filter_items_list'     => __('Filter slides list', 'como-carousel' ),
		);
		$rewrite = array(
			'slug'                => 'comoslide',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$capabilities = array(
			'edit_post'           => 'edit_slide',
			'read_post'           => 'read_slide',
			'delete_post'         => 'delete_slide',
			'delete_posts'         => 'delete_slides',
			'edit_posts'          => 'edit_slides',
			'edit_others_posts'   => 'edit_others_slides',
			'publish_posts'       => 'publish_slides',
			'read_private_posts'  => 'read_private_slides',
		);
		$args = array(
			'label'                 => __('Carousel Slide', 'como-carousel' ),
			'description'           => __('Slides to be displayed in the Como Strap Carousel', 'como-carousel' ),
			'labels'                => $labels,
			'supports'              => array('title','thumbnail','page-attributes'),
			'taxonomies'			=> array(),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-images-alt2',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false, //Set to false to hide Archive Page		
			'exclude_from_search'   => true,
			'publicly_queryable'    => false, // Set to false to hide Single Pages
			'capability_type'       => 'post',
			'rewrite'               => $rewrite,
			'capabilities'          => $capabilities,
		);
		register_post_type( 'comoslide', $args );
	}
	add_action( 'init', 'comoslide_post_type', 0 );
}
// Give Admin & Editor Access to Slides
function add_comoslide_capability() {
	$roles = array('administrator','editor');
	foreach ($roles as $role) {
		$role = get_role($role);
		$role->add_cap('edit_slide'); 
		$role->add_cap('read_slide');
		$role->add_cap('delete_slide');
		$role->add_cap('delete_slides');
		$role->add_cap('edit_slides');
		$role->add_cap('edit_others_slides');
		$role->add_cap('publish_slides');
		$role->add_cap('read_private_slides');
	}
}
add_action( 'admin_init', 'add_comoslide_capability');
// Carousel Slide Taxonomy 
add_action( 'init', 'create_slide_tax', 0 );
function create_slide_tax() {
	$labels = array(
		'name'              => _x( 'Carousel Names', 'taxonomy general name' ),
		'singular_name'     => _x( 'Carousel Name', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Carousels' ),
		'all_items'         => __( 'All Carousels' ),
		'parent_item'       => __( 'Parent Carousel' ),
		'parent_item_colon' => __( 'Parent Carousel:' ),
		'edit_item'         => __( 'Edit Carousel Name' ),
		'update_item'       => __( 'Update Carousel Name' ),
		'add_new_item'      => __( 'Add New Carousel Name' ),
		'new_item_name'     => __( 'New Carousel Name' ),
		'menu_name'         => __( 'Carousel Names' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'carousel-name' ),
	);
	register_taxonomy('carousel-name', array('comoslide'), $args );
}
// Add Sorting Dropdown on Admin Screen
add_action( 'restrict_manage_posts', 'comoslide_restrict_manage_posts');
function comoslide_restrict_manage_posts() {
	global $typenow;
	$taxonomy = 'carousel-name';
	if( $typenow == "comoslide" ){
		$filters = array($taxonomy);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
			echo "<option value=''>Show All ". $tax_name ."</option>";
			foreach ($terms as $term) { echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; }
			echo "</select>";
		}
	}
}
// Remove the Yoast SEO meta box
function comoslide_wp_seo_meta_box() {
	remove_meta_box('wpseo_meta', 'comoslide', 'normal');
}
add_action('add_meta_boxes', 'comoslide_wp_seo_meta_box', 100);
// Remove the Yoast SEO columns
function comoslide_remove_columns( $columns ) {
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );
	unset( $columns['wpseo-score-readability'] );
	unset( $columns['wpseo-links']);
	unset( $columns['wpseo-linked']);
	return $columns;
}
add_filter ( 'manage_edit-comoslide_columns', 'comoslide_remove_columns' );
// Remove Yoast SEO Sorting Dropdowns
function comoslide_remove_yoast_seo_posts_filter() {
    global $wpseo_meta_columns, $typenow;
	if( $typenow == "comoslide" ){
		if ( $wpseo_meta_columns ) {
			remove_action('restrict_manage_posts', array($wpseo_meta_columns, 'posts_filter_dropdown'));
			remove_action('restrict_manage_posts', array($wpseo_meta_columns, 'posts_filter_dropdown_readability'));
		}
	}
}
add_action( 'admin_init', 'comoslide_remove_yoast_seo_posts_filter', 20 );

// Add Custom Image Sizes
add_action( 'after_setup_theme', 'comocarousel_img_sizes' );
function comocarousel_img_sizes() {
	add_image_size( 'carousel-widescreen', 1920, 1080, true ); // (cropped)
	add_image_size( 'carousel-fullscreen', 1920, 1280, true ); // (cropped) 
}
add_filter( 'image_size_names_choose', 'comocarousel_img_sizes_choose' );
function comocarousel_img_sizes_choose( $sizes ) {
    $custom_sizes = array(
        'carousel-widescreen' => 'Carousel Wide Screen',
		'carousel-fullscreen' => 'Carousel Full Screen'
    );
    return array_merge( $sizes, $custom_sizes );
}

function getAnimations($selected) {
	$animeSelect = ''; 
	$animations = array(''=>'none','bounce'=>'Bounce','flash'=>'Flash','pulse'=>'Pulse','rubberBand'=>'Rubber Band','shake'=>'Shake','headShake'=>'Head Shake','swing'=>'Swing','tada'=>'Tada','wobble'=>'Wobble','jello'=>'Jello','bounceIn'=>'Bounce In','bounceInDown'=>'Bounce In Down','bounceInLeft'=>'Bounce In Left','bounceInRight'=>'Bounce In Right','bounceInUp'=>'Bounce In Up','bounceOut'=>'Bounce Out','bounceOutDown'=>'Bounce Out Down','bounceOutLeft'=>'Bounce Out Left','bounceOutRight'=>'Bounce Out Right','bounceOutUp'=>'Bounce Out Up','fadeIn'=>'Fade In','fadeInDown'=>'Fade In Down','fadeInDownBig'=>'Fade In Down Big','fadeInLeft'=>'Fade In Left','fadeInLeftBig'=>'Fade In Left Big','fadeInRight'=>'Fade In Right','fadeInRightBig'=>'Fade In Right Big','fadeInUp'=>'Fade In Up','fadeInUpBig'=>'Fade In Up Big','fadeOut'=>'Fade Out','fadeOutDown'=>'Fade Out Down','fadeOutDownBig'=>'Fade Out Down Big','fadeOutLeft'=>'Fade Out Left','fadeOutLeftBig'=>'Fade Out Left Big','fadeOutRight'=>'Fade Out Right','fadeOutRightBig'=>'Fade Out Right Big','fadeOutUp'=>'Fade Out Up','fadeOutUpBig'=>'Fade Out Up Big','flipInX'=>'Flip In X','flipInY'=>'Flip In Y','flipOutX'=>'Flip Out X','flipOutY'=>'Flip Out Y','lightSpeedIn'=>'Light Speed In','lightSpeedOut'=>'Light Speed Out','rotateIn'=>'Rotate In','rotateInDownLeft'=>'Rotate In Down Left','rotateInDownRight'=>'rotate In Down Right','rotateInUpLeft'=>'Rotate In Up Left','rotateInUpRight'=>'Rotate In Up Right','rotateOut'=>'Rotate Out','rotateOutDownLeft'=>'Rotate Out Down Left','rotateOutDownRight'=>'Rotate Out Down Right','rotateOutUpLeft'=>'Rotate Out Up Left','rotateOutUpRight'=>'Rotate Out Up Right','slideInDown'=>'Slide In Down','slideInLeft'=>'Slide In Left','slideInRight'=>'Slide In Right','slideInUp'=>'Slide In Up','slideOutDown'=>'Slide Out Down','slideOutLeft'=>'Slide Out Left','slideOutRight'=>'Slide Out Right','slideOutUp'=>'Slide Out Up','hinge'=>'Hinge','rollIn'=>'Roll In','rollOut'=>'Roll Out','zoomIn'=>'Zoom In','zoomInDown'=>'Zoom In Down','zoomInLeft'=>'Zoom In Left','zoomInRight'=>'Zoom In Right','zoomInUp'=>'Zoom In Up','zoomOut'=>'Zoom Out','zoomOutDown'=>'Zoom Out Down','zoomOutLeft'=>'Zoom Out Left','zoomOutRight'=>'Zoom Out Right','zoomOutUp'=>'Zoom Out Up');
	foreach ($animations as $key=>$value) {
		$animeSelect .= '<option value="'. $key .'"';
		$animeSelect .= (($key == $selected) ? ' selected' : '');
		$animeSelect .= '>'. $value .'</option>';
	}
	return $animeSelect;
}
function getLocations($selected) {
	$locSelect = ''; 
	$locations = array('inside'=>'Inside Caption Box','outside'=>'Outside Caption Box');
	foreach ($locations as $key=>$value) {
		$locSelect .= '<option value="'. $key .'"';
		$locSelect .= (($key == $selected) ? ' selected' : '');
		$locSelect .= '>'. $value .'</option>';
	}
	return $locSelect;
}
/* ##################### Meta Box ##################### */
function comoslide_custom_meta() {
    add_meta_box('comoslide_meta', __('Additional Slide Info','comoslide'),'comoslide_meta_callback','comoslide','normal','high');
}
add_action( 'add_meta_boxes', 'comoslide_custom_meta' );
function comoslide_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'comoslide_nonce' );
    $comoslide_stored_meta = get_post_meta( $post->ID );
    ?>
 
    <p><label for="comoslide-subtitle" class="comoslide-row-title"><?php _e( 'Slide Subtitle', 'comoslide' )?></label>
  	<span class="comoslide-row-content"><input type="text" name="comoslide-subtitle" id="comoslide-subtitle" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-subtitle'] ) ) echo $comoslide_stored_meta['comoslide-subtitle'][0]; ?>" /></span></p>
	<p><label for="comoslide-content" class="comoslide-row-title"><?php _e( 'Slide Content', 'comoslide' )?></label>
  	<span class="comoslide-row-content"><textarea name="comoslide-content" id="comoslide-content" style="width: 100%" rows="3"><?php if ( isset ( $comoslide_stored_meta['comoslide-content'] ) ) echo $comoslide_stored_meta['comoslide-content'][0]; ?></textarea></span></p>
	<p><label for="comoslide-color" class="comoslide-row-title"><?php _e( 'Text Color', 'comoslide' )?></label>
  	<span class="comoslide-row-content"><input type="text" name="comoslide-color" id="comoslide-color" class="meta-color color-field" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-color'] ) ) echo $comoslide_stored_meta['comoslide-color'][0]; ?>" /><br><em>Overrides default color set in stylesheet</em></span></p>

	<table style="border: none; width: 100%">
		<tr>
			<td>
				<p><label for="comoslide-button-text" class="comoslide-row-title"><?php _e( 'Button 1 Text', 'comoslide' )?></label>
				<span class="comoslide-row-content"><input type="text" name="comoslide-button-text" id="comoslide-button-text" style="width: 100%" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-button-text'] ) ) echo $comoslide_stored_meta['comoslide-button-text'][0]; ?>" /></span></p>
			</td>
			<td>
				<p><label for="comoslide-link" class="comoslide-row-title"><?php _e( 'Link 1', 'comoslide' )?></label>
 				<span class="comoslide-row-content"><input type="text" name="comoslide-link" id="comoslide-link" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-link'] ) ) echo $comoslide_stored_meta['comoslide-link'][0]; ?>" /></span></p>
			</td>
			<td>
				<p><label for="comoslide-link-target" class="comoslide-row-title"><?php _e( 'Link Target 1', 'comoslide' )?></label>
 				<span class="comoslide-row-content"><input type="text" name="comoslide-link-target" id="comoslide-link-target" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-link-target'] ) ) echo $comoslide_stored_meta['comoslide-link-target'][0]; ?>" /></span></p>
			</td>
		</tr>
	</table>

	<table style="border: none; width: 100%">
		<tr>
			<td>
				<p><label for="comoslide-button-text-2" class="comoslide-row-title"><?php _e( 'Button 2 Text', 'comoslide' )?></label>
				<span class="comoslide-row-content"><input type="text" name="comoslide-button-text-2" id="comoslide-button-text-2" style="width: 100%" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-button-text-2'] ) ) echo $comoslide_stored_meta['comoslide-button-text-2'][0]; ?>" /></span></p>
			</td>
			<td>
				<p><label for="comoslide-link-2" class="comoslide-row-title"><?php _e( 'Link 2', 'comoslide' )?></label>
				<span class="comoslide-row-content"><input type="text" name="comoslide-link-2" id="comoslide-link-2" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-link-2'] ) ) echo $comoslide_stored_meta['comoslide-link-2'][0]; ?>" /></span></p>
			</td>
			<td>
				<p><label for="comoslide-link-target-2" class="comoslide-row-title"><?php _e( 'Link 2 Target', 'comoslide' )?></label>
				<span class="comoslide-row-content"><input type="text" name="comoslide-link-target-2" id="comoslide-link-target-2" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-link-target-2'] ) ) echo $comoslide_stored_meta['comoslide-link-target-2'][0]; ?>" /></span></p>
			</td>
		</tr>
	</table>
    
	<p><label for="comoslide-class" class="comoslide-row-title"><?php _e( 'Slide Class', 'comoslide' )?></label>
 	<span class="comoslide-row-content"><input type="text" name="comoslide-class" id="comoslide-class" value="<?php if ( isset ( $comoslide_stored_meta['comoslide-class'] ) ) echo $comoslide_stored_meta['comoslide-class'][0]; ?>" /></span></p>
    
    <?php 
		$captionAnime = ((isset($comoslide_stored_meta['comoslide-caption-animation'])) ? $comoslide_stored_meta['comoslide-caption-animation'][0] : ''); 
		$captionAnimeSelect = getAnimations($captionAnime);
		$titleAnime = ((isset($comoslide_stored_meta['comoslide-title-animation'])) ? $comoslide_stored_meta['comoslide-title-animation'][0] : ''); 
		$titleAnimeSelect = getAnimations($titleAnime);
		$subtextAnime = ((isset($comoslide_stored_meta['comoslide-subtitle-animation'])) ? $comoslide_stored_meta['comoslide-subtitle-animation'][0] : '');
		$subtextAnimeSelect = getAnimations($subtextAnime);
		$contentAnime = ((isset($comoslide_stored_meta['comoslide-content-animation'])) ? $comoslide_stored_meta['comoslide-content-animation'][0] : '');
		$contentAnimeSelect = getAnimations($contentAnime);
		$buttonAnime = ((isset($comoslide_stored_meta['comoslide-btn-animation'])) ? $comoslide_stored_meta['comoslide-btn-animation'][0] : '');
		$buttonAnimeSelect = getAnimations($buttonAnime);
		$buttonLocation = ((isset($comoslide_stored_meta['comoslide-btn-location'])) ? $comoslide_stored_meta['comoslide-btn-location'][0] : '');
		$buttonLocationSelect = getLocations($buttonLocation);
	?>
        
    <table style="border: none; width: 100%">
    	<tr>
        	<td><label for="comoslide-caption-animation" class="comoslide-row-title"><?php _e( 'Caption Animation ', 'comoslide' )?></label>
            <span class="comoslide-row-content"><select name="comoslide-caption-animation" id="comoslide-caption-animation"><?=$captionAnimeSelect?></select></span></td>
           
           	<td><label for="comoslide-title-animation" class="comoslide-row-title"><?php _e( 'Title Animation ', 'comoslide' )?></label>
            <span class="comoslide-row-content"><select name="comoslide-title-animation" id="comoslide-title-animation"><?=$titleAnimeSelect?></select></span></td>
            
            <td><label for="comoslide-subtitle-animation" class="comoslide-row-title"><?php _e( 'Subtext Animation ', 'comoslide' )?></label>
            <span class="comoslide-row-content"><select name="comoslide-subtitle-animation" id="comoslide-subtitle-animation"><?=$subtextAnimeSelect?></select></span></td>
			
			<td><label for="comoslide-content-animation" class="comoslide-row-title"><?php _e( 'Content Animation ', 'comoslide' )?></label>
            <span class="comoslide-row-content"><select name="comoslide-content-animation" id="comoslide-content-animation"><?=$contentAnimeSelect?></select></span></td>
		</tr>
		<td>
            <td><label for="comoslide-btn-animation" class="comoslide-row-title"><?php _e( 'Button Animation ', 'comoslide' )?></label>
            <span class="comoslide-row-content"><select name="comoslide-btn-animation" id="comoslide-btn-animation"><?=$buttonAnimeSelect?></select></span></td>
			
			<td><label for="comoslide-btn-location" class="comoslide-row-title"><?php _e( 'Button Location ', 'comoslide' )?></label>
            <span class="comoslide-row-content"><select name="comoslide-btn-location" id="comoslide-btn-location"><?=$buttonLocationSelect?></select></span></td>
		
			<td></td>
			<td></td>
    	</tr>
    </table>
    
    <input type="hidden" name="comoSlide_update_flag" value="true" />
 
    <?php 
}
/* Save Meta Box Info */
function comoslide_meta_save( $post_id ) {
	
	// Only do this if our custom flag is present
    if (isset($_POST['comoSlide_update_flag'])) {
	
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'comoslide_nonce' ] ) && wp_verify_nonce( $_POST[ 'comoslide_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		// Specify Meta Variables to be Updated
		$metaVars = array('comoslide-subtitle','comoslide-content','comoslide-color','comoslide-button-text','comoslide-link','comoslide-link-target','comoslide-button-text-2','comoslide-link-2','comoslide-link-target-2','comoslide-class','comoslide-caption-animation','comoslide-title-animation','comoslide-subtitle-animation','comoslide-content-animation','comoslide-btn-animation','comoslide-btn-location');
		//$sanitizeVars = array('comoslide-subtitle','comoslide-content','comoslide-button-text','comoslide-link');
		$sanitizeVars = array();
		$checkboxVars = array();
		// Update Meta Variables
		foreach ($metaVars as $var) {
			if (in_array($var,$checkboxVars)) {
				if (isset($_POST[$var])) {
					update_post_meta($post_id, $var, 'yes');
				} else {
					update_post_meta($post_id, $var, '');
				}
			} else {
				if(isset($_POST[$var])) {
					if (in_array($var,$sanitizeVars)) {
						update_post_meta($post_id, $var, sanitize_text_field($_POST[$var]));
					} else {
						update_post_meta($post_id, $var, $_POST[$var]);
					}
				} else {
					update_post_meta($post_id, $var, '');
				}
			}
		}
	}
}
add_action( 'save_post', 'comoslide_meta_save' );
// Adds the meta box stylesheet when appropriate 
function comoslide_admin_styles(){
    global $typenow;
    if($typenow == 'comoslide') {
        wp_enqueue_style('comoslide_meta_box_styles', plugin_dir_url( __FILE__ ) .'css/admin.min.css');
    }
}
add_action('admin_print_styles', 'comoslide_admin_styles');
// Add Animate.css if Not already Installed
//add_action('wp_enqueue_scripts', 'check_animate_css', 99999);
function check_animate_css() {
  	global $wp_styles;
  	$srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
  	if ( in_array('animate.css', $srcs) || in_array('animate.min.css', $srcs) || in_array('style.combined.min.css', $srcs) ) {
     	// Stylesheet already exists
  	} else {
		wp_enqueue_style('animate_stylesheet', plugin_dir_url( __FILE__ ) .'css/animate.min.css');
	}
}
/* ##################### Shortcode to place Slideshow ##################### */
// Usage: [comocarousel name=SLIDER-NAME type=SLIDE/FADE indicators=SHOW/HIDE controls=SHOW/HIDE captions=show/hide interval=SLIDE_TIME pause=TRUE/FALSE orderby=DATE/TITLE/MENU_ORDER order=ASC/DESC]
class ComoCarousel_Shortcode {
	static $add_script;
	static $add_style;
	static function init() {
		add_shortcode('comocarousel', array(__CLASS__, 'handle_shortcode'));
		add_action('init', array(__CLASS__, 'register_script'));
		add_action('wp_footer', array(__CLASS__, 'print_script'));
	}
	static function handle_shortcode($atts) {
		if (!is_admin()) {
			self::$add_style = true;
			self::$add_script = true;
			$slider_name = $atts['name'];
			$slider_type = (isset($atts['type']) ? $atts['type'] : 'slide');
			$slider_indicators = (isset($atts['indicators']) ? $atts['indicators'] : 'show');
			$slider_controls = (isset($atts['controls']) ? $atts['controls'] : 'show');
			$slider_captions = (isset($atts['captions']) ? $atts['captions'] : 'show');
			$slider_interval = (isset($atts['interval']) ? $atts['interval'] : '3000');
			$slider_pause = (isset($atts['pause']) ? $atts['pause'] : 'true');
			$orderby = (isset($atts['orderby']) ? $atts['orderby'] : 'menu_order');
			$order = (isset($atts['order']) ? $atts['order'] : 'ASC');
			$slider_template = (isset($atts['template']) ? $atts['template'] : '');
			$slider_image_size = (isset($atts['imgsize']) ? $atts['imgsize'] : 'full');
			$args = array(
				'post_type' => 'comoslide',
				'post_status'=>'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'carousel-name',
						'field'    => 'slug',
						'terms'    => $slider_name,
					),
				),
				'posts_per_page'=>-1,
				'orderby'=>$orderby,
				'order'=>$order
			);
			$query = new WP_Query( $args );
			$comocarousel = ''; 
			$comoslides = ''; 
			$comoindicators = ''; 
			if ($query->have_posts()) { 
				$cslide = 0;
				while ($query->have_posts()) {
					$query->the_post(); 
					unset($slide);
					$slide['id'] = get_the_ID();
					$slide['image-id'] = get_post_thumbnail_id($slide['id']);
					$slide['image'] = get_the_post_thumbnail($slide['id'],$slider_image_size,array('class'=>'comoslide-img img-responsive img-fluid'));
					$slide['title'] = get_the_title();
					$slide['subtitle'] = get_post_meta($slide['id'],'comoslide-subtitle',true);
					$slide['content'] = get_post_meta($slide['id'],'comoslide-content',true);
					$slide['color'] = get_post_meta($slide['id'],'comoslide-color',true);
					$slide['button-text'] = get_post_meta($slide['id'],'comoslide-button-text',true);
					$slide['link'] = get_post_meta($slide['id'],'comoslide-link',true);
					$slide['link-target'] = get_post_meta($slide['id'],'comoslide-link-target',true);
					$slide['button-text-2'] = get_post_meta($slide['id'],'comoslide-button-text-2',true);
					$slide['link-2'] = get_post_meta($slide['id'],'comoslide-link-2',true);
					$slide['link-target-2'] = get_post_meta($slide['id'],'comoslide-link-target-2',true);
					$slide['button-location'] = get_post_meta($slide['id'],'comoslide-btn-location',true);
					$slide['class'] = get_post_meta($slide['id'],'comoslide-class',true);
					$slide['comoslide-caption-animation'] = get_post_meta($slide['id'],'comoslide-caption-animation',true);
					$slide['comoslide-title-animation'] = get_post_meta($slide['id'],'comoslide-title-animation',true);
					$slide['comoslide-subtitle-animation'] = get_post_meta($slide['id'],'comoslide-subtitle-animation',true);
					$slide['comoslide-content-animation'] = get_post_meta($slide['id'],'comoslide-content-animation',true);
					$slide['comoslide-btn-animation'] = get_post_meta($slide['id'],'comoslide-btn-animation',true);
					$slideclass = (($cslide == 0) ? 'active' : '');
					$slideclass .= (!empty($slide['class']) ? ' '. $slide['class'] : '');
					$slideAria = (($cslide == 0) ? 'aria-current="true"' : 'aria-current="false"');
					if ($slider_template) {
						$temp = (is_child_theme() ? get_stylesheet_directory() : get_template_directory() ) . '/como-carousel/'. $slider_template .'.php';
						if (file_exists($temp)) {
							include($temp);
						} else {
							include(plugin_dir_path( __FILE__ ) .'templates/default.php');
						}
					} else {
						include(plugin_dir_path( __FILE__ ) .'templates/default.php');
					}
					$cslide++;
				}
				$comocarousel .= '<div id="'. $slider_name .'" class="carousel comocarousel slide carousel-'. $slider_type .'" data-ride="carousel" data-bs-ride="carousel" data-interval="'. $slider_interval .'" data-bs-interval="'. $slider_interval .'" data-pause="'. $slider_pause .'" data-bs-pause="'. $slider_pause .'">';
				if ($slider_indicators == 'show') {
					$comocarousel .= '<ol class="carousel-indicators">'. $comoindicators .'</ol>';
				}
				$comocarousel .= '<div class="carousel-inner" role="listbox">'. $comoslides .'</div>';
				if ($slider_controls == 'show') {
					
					$default_controls = '<a class="left carousel-control" href="#'. $slider_name .'" role="button" data-slide="prev" data-bs-slide="prev">
						<span class="icon-prev" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#'. $slider_name .'" role="button" data-slide="next" data-bs-slide="next">
						<span class="icon-next" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>';
					$comocarousel .= ((isset($comocarousel_controls)) ? $comocarousel_controls : $default_controls); 
				}
				$comocarousel .= '</div>';
			}
			if ($comocarousel) { return $comocarousel; }
		}
	}
	
	// Register & Print Scripts
	static function register_script() {
		wp_register_script('comocarousel_script', plugins_url('js/comocarousel.min.js', __FILE__), array('jquery'), '1.0', true);
		//wp_register_style('comoslide_stylesheet', plugins_url('css/comocarousel.min.css', __FILE__), '', '1.0', 'all');
	}
	static function print_script() {
		if ( ! self::$add_style )
			return;
		//wp_enqueue_style('comoslide_stylesheet');
		
		if ( ! self::$add_script )
			return;
		wp_print_scripts('comocarousel_script');
	}
}
ComoCarousel_Shortcode::init();
/********* TinyMCE Button Add-On ***********/
add_action( 'after_setup_theme', 'comocarousel_button_setup' );
if (!function_exists('comocarousel_button_setup')) {
    function comocarousel_button_setup() {
        add_action( 'init', 'comocarousel_buttons' );
    }
}
if ( ! function_exists( 'comocarousel_buttons' ) ) {
    function comocarousel_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }
        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }
        add_filter( 'mce_external_plugins', 'comocarousel_add_buttons' );
        add_filter( 'mce_buttons', 'comocarousel_register_buttons' );
    }
}
if ( ! function_exists( 'comocarousel_add_buttons' ) ) {
    function comocarousel_add_buttons( $plugin_array ) {
        $plugin_array['comocarouselButton'] = plugin_dir_url( __FILE__ ) .'js/tinymce_carousel_button.js';
        return $plugin_array;
    }
}
if ( ! function_exists( 'comocarousel_register_buttons' ) ) {
    function comocarousel_register_buttons( $buttons ) {
        array_push( $buttons, 'comocarouselButton' );
        return $buttons;
    }
}
add_action ( 'after_wp_tiny_mce', 'comocarousel_tinymce_extra_vars' );
if ( !function_exists( 'comocarousel_tinymce_extra_vars' ) ) {
	function comocarousel_tinymce_extra_vars() { 
		
		// Get Slider Names
		$terms = get_terms([
			'taxonomy' => 'carousel-name',
			'hide_empty' => false,
		]);
		$count = count($terms);
		if ( $count > 0 ) {
			foreach ( $terms as $term ) {
				$carouselNames[] = array('value'=>$term->slug,'text'=>$term->name);
			}
		}
		$carouselNames = json_encode($carouselNames);
		
		// get Slide Templates
		$slideTemplates[] = array('value'=>'default','text'=>'Default');
		$templateDir = (is_child_theme() ? get_stylesheet_directory() : get_template_directory() ) . '/como-carousel/';
		if (file_exists($templateDir) == true) {
			if ($handle = opendir($templateDir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$slideTemplates[] = array('value'=>basename($entry, '.php'),'text'=>basename($entry, '.php'));
					}
				}
				closedir($handle);
			}
		}
		$slideTemplates = json_encode($slideTemplates);
		
		
		/** Get all the registered image sizes along with their dimensions
 		* @return array $image_sizes The image sizes
 		*/
		function como_get_all_image_sizes() {
			global $_wp_additional_image_sizes;
			$default_image_sizes = get_intermediate_image_sizes();
			foreach ( $default_image_sizes as $size ) {
				$image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
				$image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
				$image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
			}
			if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
				$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
			}
			return $image_sizes;
		}
		$imageSizes = como_get_all_image_sizes();
		foreach ($imageSizes as $key => $value) {
			$imgSizes[] = array('value'=>$key,'text'=>$key .'('. $value['width'] .'x'. $value['height'] .')');
		}
		$imgSizes = json_encode($imgSizes);
		
		?>
		<script type="text/javascript">
			var tinyMCE_slider = <?php echo json_encode(
				array(
					'carousel_select_options' => $carouselNames,
					'slide_template_select_options' => $slideTemplates,
					'slide_image_size_options' => $imgSizes
				)
			);
			?>;
		</script><?php
	} 	
}
?>