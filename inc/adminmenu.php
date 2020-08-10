<?php

add_action('admin_menu', 'av_cookie_optin_admin_menu');

function av_cookie_optin_admin_menu() {
    add_menu_page( '84GHz Cookie Opt-In', '84GHz Cookie Opt In', 'manage_options', 'achtvier-cookie-optin', 'av_cookie_optin_admin_page' );
	add_action( 'admin_init', 'register_achtvier_cookie_optin_settings' );
}
function register_achtvier_cookie_optin_settings() {
	//register our settings
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_cookie_header');
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_cookie_subheader');
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_cookie_bottom');
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_impressum_link');
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_dsvgo_link');
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_has_ga');
	register_setting( 'achtvier-cookie-optin-settings-group', 'av_has_matomo');
}

function av_cookie_optin_admin_page() {
    echo '<div class="wrap">';
    echo '<h2>84GHz Cookie Optin Settings</h2>';
    echo'<form method="post" action="options.php">';
        settings_fields( 'achtvier-cookie-optin-settings-group' ); 
        do_settings_sections( 'achtvier-cookie-optin-settings-group' );
        $ga_checked = "";
        $matomo_checked = "";
        if (get_option('av_has_ga')) {
            $ga_checked = "checked";
        }
        if (get_option('av_has_matomo')) {
            $matomo_checked = "checked";
        }
        echo '<table class="form-table">';
            echo '<tr valign="top">';
            echo '<th scope="row">Cookie Header</th>';
            echo '<td><input type="text" name="av_cookie_header" value="' . esc_attr( get_option('av_cookie_header') ) . '" /></td>';
            echo '</tr>';
            echo '<tr valign="top"><th scope="row">Cookie SubHeader</th>';
            echo '<td><textarea name="av_cookie_subheader" value="' . esc_attr( get_option('av_cookie_subheader') ) . '" >' .esc_attr( get_option('av_cookie_subheader') ) . '</textarea></td>';
            echo '</tr><tr valign="top"><th scope="row">Cookie Bottom</th>';
            echo '<td><textarea name="av_cookie_bottom" value="' . esc_attr( get_option('av_cookie_bottom') ) . '" >' .esc_attr( get_option('av_cookie_bottom') ) . '</textarea></td>';
            echo '</tr><tr valign="top"><th scope="row">Impressum Link</th>';
            echo '<td><input type="text" name="av_impressum_link" value="' . esc_attr( get_option('av_impressum_link') ) . '" /></td>';
            echo '</tr><tr valign="top"><th scope="row">Datenschutz Link</th>';
            echo '<td><input type="text" name="av_dsvgo_link" value="' . esc_attr( get_option('av_dsvgo_link') ) . '"/ ></td>';
            echo '</tr><tr valign="top"><th scope="row">Matomo( wenn nicht aktiviert -> cookies bleiben) ?</th>';
            echo '<td><input type="checkbox" name="av_has_matomo" value="1" ' . $matomo_checked . '/ >Matomo</td>';
            echo '</tr><tr valign="top"><th scope="row">Google Analytics? (wenn nicht aktiviert - cookies bleiben)</th>';
            echo '<td><input type="checkbox" name="av_has_ga" value="1" ' . $ga_checked . '/ >Google Analytics</td>';
            echo '</tr></table>    ';
        submit_button();     
    echo '</form></div>';
    }   
?>