<?php
/**
 * Plugin Name:       Dr Info Slider
 * Plugin URI:        https://md-sh-emon.github.io/dr-info-slider/
 * Description:       This is a Slider Plugin for showing Information of Doctors. Easy to use slider plugin
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mohammad Saeed Hossain
 * Author URI:        https://dev-md-sh-emon.pantheonsite.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dr-info-slider
 */

class doctorInfoSlider_Doctor {
    public function __construct(){
        // Setup  
        add_action( 'init', array( $this, 'doctorInfoSlider_setup' ));

        // Including css
        add_action( 'wp_enqueue_scripts', array( $this, 'doctorInfoSlider_styles' ) );

        // Including js
        add_action( 'wp_enqueue_scripts', array( $this, 'doctorInfoSlider_scripts' ) );

        // adding meta box
        add_action( 'add_meta_boxes', array( $this, 'doctorInfoSlider_meta_boxes' ) );

        // Sending meta box value to database
        add_action( 'save_post', array( $this, 'doctorInfoSlider_send_meta_box_value_to_database' ) );

        // Dr info slider shortcode
        add_shortcode( 'dr-info-slider', array( $this, 'doctorInfoSlider_shortcode' ) );
    }

    // callback of init hook
    public function doctorInfoSlider_setup(){
        if( current_user_can( 'manage_options' ) ){
            // Doctors Post Type Labels
            $labels = array(
                'name'                  => _x( 'Doctors', 'Doctors general name', 'doctors-info' ),
                'singular_name'         => _x( 'Doctor', 'Doctor singular name', 'doctors-info' ),
                'menu_name'             => _x( 'Doctors', 'Admin Menu text', 'doctors-info' ),
                'name_admin_bar'        => _x( 'Doctor', 'Add New on Toolbar', 'doctors-info' ),
                'add_new'               => __( 'Add New Doctor', 'doctors-info' ),
                'add_new_item'          => __( 'Add New Doctor', 'doctors-info' ),
                'new_item'              => __( 'New Doctor', 'doctors-info' ),
                'edit_item'             => __( 'Edit Doctor', 'doctors-info' ),
                'view_item'             => __( 'View Doctor', 'doctors-info' ),
                'all_items'             => __( 'All Doctors', 'doctors-info' ),
                'search_items'          => __( 'Search Doctors', 'doctors-info' ),
                'parent_item_colon'     => __( 'Parent Doctors:', 'doctors-info' ),
                'not_found'             => __( 'No Doctors found.', 'doctors-info' ),
                'not_found_in_trash'    => __( 'No Doctors found in Trash.', 'doctors-info' ),
                'featured_image'        => _x( 'Doctor Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'doctors-info' ),
                'set_featured_image'    => _x( 'Set Doctor image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'doctors-info' ),
                'remove_featured_image' => _x( 'Remove Doctor image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'doctors-info' ),
                'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'doctors-info' ),
                'archives'              => _x( 'Doctor archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'doctors-info' ),
                'insert_into_item'      => _x( 'Insert into Doctor', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'doctors-info' ),
                'uploaded_to_this_item' => _x( 'Uploaded to this Doctor', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'doctors-info' ),
                'filter_items_list'     => _x( 'Filter Doctors list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'doctors-info' ),
                'items_list_navigation' => _x( 'Doctors list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'doctors-info' ),
                'items_list'            => _x( 'Doctors list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'doctors-info' ),
            );

            // Doctors Post Type args
            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-insert',
                'supports'           => array( 'title', 'thumbnail' ),
            );

            // Registering Doctors Post Type
            register_post_type('doctors-info', $args);

            // Doctors Post Type args
            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'dashicons-insert',
                'supports'           => array( 'title', 'thumbnail' ),
            );

            // Registering Doctors Post Type
            register_post_type('doctors-info', $args);

            // Speciality Taxonomy labels
            $speciality_labels = array(
                'name'              => _x( 'Speciality', 'Speciality general name', 'doctors-info' ),
                'singular_name'     => _x( 'Speciality', 'taxonomy singular name', 'doctors-info' ),
                'search_items'      => __( 'Search Speciality', 'doctors-info' ),
                'all_items'         => __( 'All Speciality', 'doctors-info' ),
                'parent_item'       => __( 'Parent Speciality', 'doctors-info' ),
                'parent_item_colon' => __( 'Parent Speciality:', 'doctors-info' ),
                'edit_item'         => __( 'Edit Speciality', 'doctors-info' ),
                'update_item'       => __( 'Update Speciality', 'doctors-info' ),
                'add_new_item'      => __( 'Add New Speciality', 'doctors-info' ),
                'new_item_name'     => __( 'New Speciality Name', 'doctors-info' ),
                'menu_name'         => __( 'Speciality', 'doctors-info' ),
            );

            // Speciality Taxonomy args
            $speciality_args = array(
                'hierarchical'      => true,
                'labels'            => $speciality_labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'speciality' ),
            );

            register_taxonomy( 'doctors-speciality', 'doctors-info' , $speciality_args );
        }
    }

    // callback of wp_enqueue_scripts
    public function doctorInfoSlider_styles(){
        // including fonts
        function doctorInfoSlider_fonts(){
            $custom_fonts = array();
            $custom_fonts[] = "Poppins:300,400,500,600,700,800,900"; 
            $custom_fonts[] = "Playfair+Display:400,400i,700,700i&display=swap"; 

            $doctorInfoSlider = add_query_arg(array(
                'family'    => implode( '|', $custom_fonts )
            ), 'https://fonts.googleapis.com/css');
            return $doctorInfoSlider;
        }
        
        // Adding animate.css
        wp_enqueue_style( 'doctorInfoSlider-animate', PLUGINS_URL('css/animate.css', __FILE__ ) );
        
        // Adding owl.carousel.min.css
        wp_enqueue_style( 'doctorInfoSlider-owl-carousel', PLUGINS_URL('css/owl.carousel.min.css', __FILE__ ) );

        // Adding style.css
        wp_enqueue_style( 'doctorInfoSlider-style', PLUGINS_URL('css/style.css', __FILE__ ) );

        // Adding Fonts
        wp_enqueue_style( 'doctorInfoSlider-fonst' , doctorInfoSlider_fonts() );
    }


    // callback of wp_enqueue_scripts
    public function doctorInfoSlider_scripts(){

        // Adding jquery.min.js 
        wp_enqueue_script('doctorInfoSlider-owl-carousel', PLUGINS_URL('js/owl.carousel.min.js', __FILE__ ), array('jquery'), '', true);

        // Adding main.js 
        wp_enqueue_script('doctorInfoSlider-main', PLUGINS_URL('js/main.js', __FILE__ ), array('jquery', 'doctorInfoSlider-owl-carousel'), '', true);
    }

    // callback of add_meta_boxes hook
    public function doctorInfoSlider_meta_boxes(){
        add_meta_box('dr-information', __( 'Doctor Information', 'dr-info-slider' ), array( $this, 'doctor_info_meta_box' ), 'doctors-info', 'normal');
    }

    // callback of add_meta_box function
    public function doctor_info_meta_box(){ ?>
        
        <p>
            <strong>
                <label for="dr_age">Age: </label>
            </strong>
            <input type="text" name="dr_age" id="dr_age" value="<?php echo get_post_meta( get_the_id(), '_dr_age', true ); ?>" class="widefat">
        </p>
        <p>
            <strong>
                <label for="dr_degree">Medical Degree: </label>
            </strong>
            <input type="text" name="dr_degree" id="dr_degree" value="<?php echo get_post_meta( get_the_id(), '_dr_degree', true ); ?>" class="widefat">
        </p>
        <p>
            <strong>
                <label for="dr_chamber">Chamber: </label>
            </strong>
            <input type="text" name="dr_chamber" id="dr_chamber" value="<?php echo get_post_meta( get_the_id(), '_dr_chamber', true ); ?>" class="widefat">
        </p>
        
    <?php }

    public function doctorInfoSlider_send_meta_box_value_to_database( $post_id ){
        $dr_age = isset( $_POST['dr_age'] ) ? $_POST['dr_age'] : '';
        $dr_degree = isset( $_POST['dr_degree'] ) ? $_POST['dr_degree'] : '';
        $dr_chamber = isset( $_POST['dr_chamber'] ) ? $_POST['dr_chamber'] : '';

        update_post_meta( $post_id, '_dr_age', $dr_age );
        update_post_meta( $post_id, '_dr_degree', $dr_degree );
        update_post_meta( $post_id, '_dr_chamber', $dr_chamber );
    }

    // output of [dr-info-slider] shortcode
    public function doctorInfoSlider_shortcode(){
        ob_start(); ?>
        <section class="ftco-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="featured-carousel owl-carousel">
                            <?php $doctors = new WP_Query(array(
                                'post_type'         => 'doctors-info',
                                'posts_per_page'    => -1
                            ));
                            while( $doctors->have_posts() ) : $doctors->the_post();
                            ?>
							<div class="item">
								<div class="row justify-content-center">
									<div class="col-md-11">
										<div class="testimony-wrap d-md-flex">
											<div class="img" style="background-image: url(<?php the_post_thumbnail_url(); ?>);"></div>
											<div class="text text-center p-4 py-xl-5 px-xl-5 d-flex align-items-center">
												<div class="desc w-100">
													<p class="h3 mb-1 dr-name"><?php the_title() ?></p>
													<div class="pt-2">
														<p class="dr-speciality name mb-0">&mdash; <?php $specialities = get_the_terms( get_the_id(), 'doctors-speciality' );
                                                        foreach( $specialities as $speciality ){
                                                            echo $speciality->name;
                                                        }
                                                        ?></p>
														
													</div>
													<p class="dr-age h6 mt-2">Age: <?php echo get_post_meta( get_the_id(), '_dr_age', true ); ?></p>
													<p class="dr-degree h6 mt-2">Medical Degree: <?php echo get_post_meta( get_the_id(), '_dr_degree', true ); ?></p>
													<p class="dr-chamber h6">Chamber: <?php echo get_post_meta( get_the_id(), '_dr_chamber', true ); ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <?php endwhile; ?>
							
						</div>
					</div>
				</div>
			</div>
		</section>
        <?php return ob_get_clean();
    }
}

// Initializing doctorInfoSlider_Doctor class
$doctor = new doctorInfoSlider_Doctor();