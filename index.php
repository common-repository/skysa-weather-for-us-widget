<?php
/*
Plugin Name: Skysa weatherfor.us Application
Description: Skysa port of weather for us widget.
Version: 1.0
Author: Zohaib 
Author URI: http://www.weatherfor.us
*/

/*
*************************************************************
*                 This app was made using the:              *
*                       Skysa App SDK                       *
*    http://wordpress.org/extend/plugins/skysa-app-sdk/     *
*************************************************************
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) exit;

// Skysa App plugins require the skysa-req subdirectory,
// and the index file in that directory to be included.
// Here is where we make sure it is included in the project.
include_once dirname( __FILE__ ) . '/skysa-required/index.php';


// Weather for us widget for skysa APP
$GLOBALS['SkysaApps']->RegisterApp(array( 
    'debug' => 1, // 'debug' => 1 for outputting errors, remove this or set to 0 for production
    'id' => '5050862ca8c1e',
    'label' => 'Weather for us',
	'options' => array(
        'icon' => array(
            'label' => 'Button Icon URL',
            'info' => 'Enter a URL for the an Icon Image. (You can leave this blank for none)',
			'type' => 'image',
			'value' => plugins_url( '/icons/weather-icon.png', __FILE__ ),
			'size' => '50|1'
        ),
        'title' => array(
            'label' => 'App Title',
            'info' => 'What would you like to set as the title for the app window?',
			'type' => 'text',
			'value' => 'Weather forecast by weatherfor.us',
			'size' => '30|1'
        ),
        'option1' => array(
            'label' =>  'Weather location',
            'info' =>   'Enter location city name followed by state and country name (e.g. Palo Alto, California, USA), leave empty to autodetect ',
            'type' =>   'text',
            'value' =>  '',
            'size' =>   '100|1'
        
        )
	),
    'window' => array(
        'width' => '720',
        'height' => '350',
        'position' => 'Above the Bar'
    ),
    'views' => array( // Each view can be an html string or a function which returns an html string. Link to other views using href="#view=view&queryparams"
        'main' => skysa_app_weatherforus_view_main

    ), 
    'html' => '<div id="$button_id" class="bar-button" apptitle="$app_title" w="$app_width" h="$app_height" bar="$app_position">$app_icon<span class="label">Weather</span></div>',
    'js' => "
        S.on('click',function(){S.open('window','main')});
     "
));

function skysa_app_weatherforus_view_main($rec){
    
    $loc = $rec['option1'];
    $params = '';
    if( !empty($loc) ) {
        $params = array();
        $params['location'] = $loc;
        $params = '?'.http_build_query($params);
    }
    return '<iframe id="explicit" src="http://www.weatherfor.us/load.php'.$params.'" scrolling="no" frameborder="0" allowtransparency="true" style="background: transparent; width: 720px; height: 250px; overflow: hidden;"></iframe>';
}

