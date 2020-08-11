<?php
/**
 * Plugin Name:     Achtvier Cookie Optin
 * Plugin URI:      Cookie Popup (2020 August)
 * Description:     Cookie Popup 
 * Author:          84GHz
 * Author URI:      https://84ghz.de
 * Text Domain:     achtvier-cookie-optin
 * Domain Path:     /languages
 * Version:         0.16.0
 *
 * @package         Achtvier_Cookie_Optin
 */

// Your code starts here.




function head_content() {
    ob_start();
    do_action('wp_footer');
    return ob_get_clean();
}
function all_hooks() {
    ob_start();
    var_dump($GLOBALS['wp_filter']);
    return ob_get_clean();
}

// contents

function av_cookie_optin_shortcode() {
    

    $output = ("<h1>84GHz Script manager</h1>");
    global $wp_scripts;
    $output .= "<ul>";
    foreach( $wp_scripts->queue as $handle ) {

        $obj = $wp_scripts->registered [$handle];
        $filename = $obj->src;
        $output .= "<li>" . $handle . ": " . $filename . '</li>';
    }
    $output .= "</ul>";
    $output .= "<h1>Wp-Head</h1>";
    //$output .= all_hooks();
    return $output;     
}

add_action('get_header', 'av_remove_trackers');

add_action('get_footer', 'av_remove_footer_trackers');

function av_remove_footer_trackers () {
    if (get_option('av_has_matomo')) {
        if(!($_COOKIE['av_cookie_optin']=="2")) {
        $beremed = remove_action('wp_footer', array($GLOBALS['wp-piwik'], 'addJavascriptCode'));
        if (!($beremed)) {
            wp_mail(get_bloginfo('admin_email'), '84GHz Cookie Plugin muss angepasst werden', '84GHz Cookie Plugin muss angepasst werden (Matomo). Bitte ans Entwicklungsteam weiterleiten.');
            echo "GOogle analytics function not found!";
          }
        }     
    }
    
}

function av_remove_trackers () {
    if (get_option('av_has_ga')) {
        if(!($_COOKIE['av_cookie_optin']=="2")) {
          $beremed = remove_action('wp_head', 'ga_google_analytics_tracking_code');
        if (!($beremed)) {
            wp_mail(get_bloginfo('admin_email'), '84GHz Cookie Plugin muss angepasst werden', '84GHz Cookie Plugin muss angepasst werden (Google) . Bitte ans Entwicklungsteam weiterleiten.');
            echo "GOogle analytics function not found!";
          }
        }     
    }
    
    }
    


require_once(dirname(__FILE__) . "/inc/adminmenu.php");
/**
 * Renders a cookie baner with settings
 */
function av_cookie_banner() {
 if(!isset($_COOKIE['av_cookie_optin'])) {
    $impressum_link = "";
    $dsvgo_link="";
    if(strlen(get_option('av_impressum_link'))> 2) {
        $impressum_link = '<a class="av-dsvgo" href="' . get_option('av_impressum_link') . '" >Impressum</a> | ';
    }
    if(strlen(get_option('av_dsvgo_link'))> 2) {
        $dsvgo_link = '<a class="av-dsvgo" href="' . get_option('av_dsvgo_link') . '" >Datenschutz</a>';
    }

  $output = '<div class ="av-cookie-banner-wrapper" id ="av-cbnwr">';
  $output .= '<div class ="av-cookie-banner">';
  $output .= '<div class="av-cookie-banner-header">';
  $output .= '<h3 class="av-cookie-banner-h">';
  $output .= get_option('av_cookie_header');
  $output .= '</h3>';
  $output .= '<div class="av-cookie-banner-info">';
  $output .= get_option('av_cookie_subheader');
  $output .= '</div>';
  $output .= '</div>';
  $output .= '<form>';
  $output .= '<div class="av-cookie-banner-boxes">';
  $output .= '<label></span><input type="checkbox" name="check-ess" id="av-cookie-ess" value="1" checked disabled>Essentiell<span class="checkmark alon"></label> ';
  $output .= '<label><input type="checkbox" name="check-trk" id="av-cookie-trak" value="1" >Statistik<span class="checkmark"></span></label> ';
  $output .= '</div>';
  $output .= '<div class="av-cookie-button-outer-wrapper">';
  $output .= '<div class="av-cookie-button-wrapper">';
  $output .= '<a href="#" id="av-all-cookie-acpt" class="btn btn-primary">Alle akzeptieren</a>';
  $output .= '</div>';
  $output .= '<div class="av-cookie-button-wrapper">';
  $output .= '<a href="#" id="av-cookie-save" class="btn btn-primary">Auswahl speichern</a>';
  $output .= '</div>';
  $output .= '</div>';
  $output .= '</form>';
  $output .= '<div class="av-cookie-banner-bottom">';
  $output .= get_option('av_cookie_bottom');  
  $output .= '</div>';
  $output .= '<div class="av-cookie-links-bottom">';
  $output .= $impressum_link  . $dsvgo_link;  
  $output .= '</div>';

  $output .= '</div>';
  $output .= '</div>';
    echo $output;
  } 

}

add_action( 'wp_footer', 'av_cookie_banner' );

add_action('wp_enqueue_scripts', 'av_cookie_opt_in_scripts');

function av_cookie_opt_in_scripts() {
    wp_enqueue_script( 'av-cookie-meldung', plugin_dir_url( __FILE__ ) . '/assets/av-cookie.js' );
    wp_register_style( 'av-cookie-opt-in-css', plugin_dir_url( __FILE__ ) . '/assets/av-cookie.css' );
    wp_enqueue_style( 'av-cookie-opt-in-css');
}

add_shortcode( 'av_script_check', 'av_cookie_optin_shortcode' );

if (!(class_exists("Puc_v4_Factory"))) {
    require 'plugin-update-checker/plugin-update-checker.php';
  }
  $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
      'https://github.com/84GHz/achtvier-cookie-optin/',
      __FILE__,
      'achtvier-cookie-optin'
  );