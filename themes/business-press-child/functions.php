<?php

// add_action('wp_enqueue_scripts', 'addIcon');
// function addIcon() {
//     // On ajoute le css general du theme
//     wp_register_style('fontawesome-5.3.1', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css','',false,'screen');
//     wp_enqueue_style( 'fontawesome-5.3.1' );
// }

// add_action('wp_enqueue_scripts', 'addAllScripts');
// function addAllScripts() {
// 	//JQUERY
// 	wp_deregister_script('jquery');
// 	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), '3.3.1', false);
// 	//SCRIPT DU SITE
// 	wp_register_script( 'js_script', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0', false);
// 	wp_enqueue_script( 'js_script' );
// }

function child_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'child_custom_excerpt_length', 9998 );

function child_pdocs_excerpt_more( $more ) {
    return '';
}
add_filter( 'excerpt_more', 'child_pdocs_excerpt_more', 9998 );