<?php
/*
Plugin Name: Deplace connexion
Plugin URI:  http://dfarnier.fr/modifier-wp-login/
Description: modifier l'adresse de connexion pour éviter un piratage
Version:     4
Author:      Daniel Farnier
Author URI:  http://dfarnier.fr
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

*/

//	Vérifier que l'extension est appelée depuis WordPress et non directement via internet
if ( !defined('ABSPATH') ) exit ('Faites demi-tour !');

//	définir la nouvelle adresse de connexion
define('WPDF_ADRESSE_CONNEXION', 'sdfglmknpmjnf654654sdfsdfsdfsdf---sdfsdf--99aze');
//	définir l'adresse de retour quand la connexion est refusée (exemple : la page d'accueil)
define('WPDF_ADRESSE_CONNEXION_REFUSEE', network_site_url());

//	rediriger vers le fichier programme wp-login.php si la nouvelle adresse est appelée correctement
//  pour se connecter / déconnecter, réinitialiser le mot de passe
//	ou se reconnecter après une déconnexion automatique
add_action( 'init', 'wpdf_redirige_login' );

function wpdf_redirige_login()  {

	$wpdf_adresse_connexion = '/'.WPDF_ADRESSE_CONNEXION;	//	adresse de base

	$wpdf_patron='#' . $wpdf_adresse_connexion.'$|' . $wpdf_adresse_connexion . '/?\?action=rp&?|' . $wpdf_adresse_connexion.'/?\?loggedout=true$|' . $wpdf_adresse_connexion . '/?\?checkemail=confirm$|' . $wpdf_adresse_connexion.'/?\?checkemail=registered$|' . $wpdf_adresse_connexion . '/?\?action=lostpassword&?$|' . $wpdf_adresse_connexion . '/?\?action=lostpassword&error=expiredkey$|' . $wpdf_adresse_connexion . '/?\?action=lostpassword&error=invalidkey$|' . $wpdf_adresse_connexion . '/?\?action=resetpass$|' . $wpdf_adresse_connexion.'/?\?registration=disabled$|' . $wpdf_adresse_connexion . '/?\?action=register|' . $wpdf_adresse_connexion . '/?\?checkemail=registered$|' . $wpdf_adresse_connexion . '/?\?interim-login=1$|' . $wpdf_adresse_connexion . '/?\?redirect_to=|' . $wpdf_adresse_connexion . '\?action=lostpassword&error=expiredkey|' . $wpdf_adresse_connexion . '\?action=lostpassword&error=invalidkey|' . $wpdf_adresse_connexion . '\?registration=disabled|' . $wpdf_adresse_connexion . '/?\?action=logout&_wpnonce=#';

	if (preg_match($wpdf_patron, untrailingslashit( $_SERVER['REQUEST_URI'])) === 1 ) {
		error_reporting(E_ALL & ~E_NOTICE);
		require_once(ABSPATH . 'wp-login.php');
		exit();
	}	//	fin test si nouvelle url de connexion
}	//	fin fonction wpdf_redirige_login

//---------------------------------------------------------------------
//	rediriger les connexions ne venant pas de la nouvelle adresse
add_action( 'login_init', 'wpdf_refuse_connexion' );

function wpdf_refuse_connexion() {
	if ( strpos( $_SERVER['REQUEST_URI'], '/'.WPDF_ADRESSE_CONNEXION ) === false ) {
		wp_redirect( WPDF_ADRESSE_CONNEXION_REFUSEE );
		exit();
	}	// fin test si nouvelle adresse de connexion non trouvée
}	//	fin fonction wpdf_refuse_connexion


//---------------------------------------------------------------------
//	modifier l'adresse de connexion affichée sur le site (forumulaires, liens)
add_filter( 'site_url', 'wpdf_modifie_adresse_connexion', 10, 3 );
if (is_multisite()) add_filter( 'network_site_url', 'wpdf_modifie_adresse_connexion', 10, 3 );

function wpdf_modifie_adresse_connexion( $wpdf_aff_login_url, $wpdf_path, $wpdf_orig_scheme ) {

	if ( $wpdf_orig_scheme === 'login' || $wpdf_orig_scheme === 'login_post' ){
		$wpdf_aff_login_url = preg_replace( '/wp-login\.php/', WPDF_ADRESSE_CONNEXION, $wpdf_aff_login_url, 1 );
	}	//	fin test si scheme égal login ou login_post

	$wpdf_siteurl_patron = '#wp-login.php\?action=lostpassword&error=expiredkey$|wp-login.php\?action=lostpassword&error=invalidkey$|wp-login.php\?registration=disabled$#';

	if ( preg_match($wpdf_siteurl_patron, $wpdf_aff_login_url) === 1  )
		$wpdf_aff_login_url = preg_replace( '/wp-login\.php/', WPDF_ADRESSE_CONNEXION, $wpdf_aff_login_url, 1 );
	return $wpdf_aff_login_url;
}	// fin fonction wpdf_modifie_adresse_connexion


// modifie l'adresse après demande de déconnexion ou de modification du mot de passe
add_filter ('wp_redirect', 'wpdf_redirect_mdpout', 10, 2);

function wpdf_redirect_mdpout ( $wpdf_location, $wpdf_status ) {
	$wpdf_redirect_mdpout = array (
		'wp-login.php?loggedout=true',
		'wp-login.php?checkemail=confirm',
		'wp-login.php?checkemail=registered'
	);
	if ( in_array( $wpdf_location, $wpdf_redirect_mdpout ) )
		$wpdf_location = preg_replace( '/wp-login\.php/', WPDF_ADRESSE_CONNEXION, $wpdf_location, 1 );
	return $wpdf_location;
}	// fin fonction wpdf_redirect_mdpout

//	modifie le message de bienvenue pour un nouveau site
add_filter ('update_welcome_email', 'wpdf_update_welcome_email', 10, 6);

function wpdf_update_welcome_email ( $wpdf_welcome_email, $wpdf_blog_id, $wpdf_user_id, $wpdf_password, $wpdf_title, $wpdf_meta) {
	$wpdf_welcome_email = preg_replace( '/wp-login\.php/', WPDF_ADRESSE_CONNEXION, $wpdf_welcome_email, 1 );
	return $wpdf_welcome_email;
}	// fin fonction wpdf_update_welcome_email

//-----------------------------------------------------------------------------------------------
//	renvoyer vers WPDF_ADRESSE_CONNEXION_REFUSEE si adresse = 'wp-login.php' ou 'login'
add_filter( 'login_url', 'wpdf_filtre_adresse_login', 10, 3 );

function wpdf_filtre_adresse_login( $wpdf_login_url, $wpdf_redirect, $wpdf_force_reauth ) {
	$wpdf_logins = array(
		home_url( 'wp-login.php', 'relative' ),
		home_url( 'login', 'relative' ),
		network_site_url( 'login', 'relative' ),
	);
	if ( in_array( untrailingslashit( $_SERVER['REQUEST_URI'] ), $wpdf_logins ) ) {
		wp_redirect( WPDF_ADRESSE_CONNEXION_REFUSEE );
		exit();
	}

	return $wpdf_login_url;
}	// fin fonction wpdf_filtre_adresse_login

//	renvoyer vers WPDF_ADRESSE_CONNEXION_REFUSEE si adresse alias d'administration
add_filter( 'admin_url', 'wpdf_filtre_adresse_admin', 10, 3 );

function wpdf_filtre_adresse_admin( $wpdf_login_url, $wpdf_redirect, $wpdf_force_reauth ) {
	if ( (function_exists('is_user_logged_in')) &&!( is_user_logged_in ()) ) {
		$wpdf_admins = array(
	home_url( 'wp-admin', 'relative' ),
			home_url( 'dashboard', 'relative' ),
			home_url( 'admin', 'relative' ),
			network_site_url( 'dashboard', 'relative' ),
			network_site_url( 'admin', 'relative' ),
		);
		if ( in_array( untrailingslashit( $_SERVER['REQUEST_URI'] ), $wpdf_admins ) ) {
			wp_redirect( WPDF_ADRESSE_CONNEXION_REFUSEE );
			exit();
		}
	}	//	fin test si utilisateur connecté
	return $wpdf_login_url;
}	// fin fonction wpdf_filtre_adresse_admin

?>