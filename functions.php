<?php 

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' ); 

function my_enqueue_assets() { 

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' ); 

} 

// One click demo import activation
require_once get_stylesheet_directory() . '/auto-install/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'freelancer_pro_register_required_plugins' );

// Register the required plugins for this theme
function freelancer_pro_register_required_plugins() {
    $plugins = array( // Include the One Click Demo Import plugin from the WordPress repo
        array(
            'name' => 'One Click Demo Import',
            'slug' => 'one-click-demo-import',
            'required' => true,
        ) ,
    );
    $config = array(
        'id'           => 'divi_freelancer_pro',       // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                    // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa($plugins, $config);
}

// Import all the files
function ocdi_import_files() {
    return array(
        array(
            'import_file_name' => 'Divi Freelancer Pro Import',
            'import_file_url' => get_stylesheet_directory_uri() . '/content/content.xml',
            'import_customizer_file_url' => get_stylesheet_directory_uri() . '/content/customizer.dat',
            // 'import_preview_image_url' => 'YOUR_URL/screenshot.png',
            'import_notice' => __( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'your_theme_name' ),
        ),
    );
}
add_filter('pt-ocdi/import_files', 'ocdi_import_files');

// create the menus.
function ocdi_after_import_setup() {
  $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
  // $secondary_menu = get_term_by( 'name', 'Secondary Menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
'primary-menu' => $main_menu->term_id,
// 'secondary-menu' => $secondary_menu->term_id,
    )
    );
        // Assign home page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Start Bootstrap' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );

?>