<?php
/*-----------------------------------------------------------------------------------*/
/* Register Navigation Menus
/*-----------------------------------------------------------------------------------*/
function navigation_menus() {
    
        $locations = array(
            'Header Menu' => __( 'Header Menu', 'text_domain' ),
            'Mobile Menu' => __( 'Mobile Menu', 'text_domain' ),
            'Footer Company Menu' => __( 'Footer Company Menu', 'text_domain' ),
            'Footer Support Menu' => __( 'Footer Support Menu', 'text_domain' ),
        );
        register_nav_menus( $locations );
    
    }
	add_action( 'init', 'navigation_menus' );