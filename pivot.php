<?php

/**
 * Pivot Skin
 *
 * @file Since Version 1.0
 * @ingroup Skins
 * @author Garrick Van Buren, Jamie Thingelstad
 * @author Tom Hutchison
 * @license 2-clause BSD
 */

if ( ! defined('MEDIAWIKI'))
{
	die("Not Directly Called So What Are You Doing");
}


$wgExtensionCredits['skin'][] = array(
	'path'		 => __FILE__,
	'name'		 => 'skinname-pivot',
	'url'		 => 'http://github.com/hutchy68/pivot/',
	'author'	 => array(
		'Tom Hutchison',
		'...'
		),
	'version' => '1.0.0 rc',
	'descriptionmsg' => 'pivot-desc'
);

$wgValidSkinNames['pivot'] = 'Pivot';

$wgAutoloadClasses['SkinPivot'] = __DIR__.'/Pivot.skin.php';

$wgMessagesDirs['SkinPivot'] = __DIR__.'/i18n';

$wgResourceModules['skins.pivot'] = array(
	'styles'         => array(
		'pivot/assets/stylesheets/normalize.css',
		'pivot/assets/stylesheets/font-awesome.css',
		'pivot/assets/stylesheets/foundation.css',
		'pivot/assets/stylesheets/pivot.css',
		'pivot/assets/stylesheets/pivot-print.css',
		'pivot/assets/stylesheets/jquery.autocomplete.css'
	),
	'scripts'        => array(
		'pivot/assets/scripts/vendor/jquery.cookie.js',
		'pivot/assets/scripts/vendor/modernizr.js',
		'pivot/assets/scripts/vendor/fastclick.js',
		'pivot/assets/scripts/vendor/placeholder.js',
		'pivot/assets/scripts/foundation/foundation.js',
		'pivot/assets/scripts/foundation/foundation.topbar.js',
		'pivot/assets/scripts/foundation/foundation.tooltip.js',
		'pivot/assets/scripts/foundation/foundation.tab.js',
		'pivot/assets/scripts/foundation/foundation.slider.js',
		'pivot/assets/scripts/foundation/foundation.reveal.js',
		'pivot/assets/scripts/foundation/foundation.orbit.js',
		'pivot/assets/scripts/foundation/foundation.offcanvas.js',
		'pivot/assets/scripts/foundation/foundation.magellan.js',
		'pivot/assets/scripts/foundation/foundation.joyride.js',
		'pivot/assets/scripts/foundation/foundation.interchange.js',
		'pivot/assets/scripts/foundation/foundation.equalizer.js',
		'pivot/assets/scripts/foundation/foundation.dropdown.js',
		'pivot/assets/scripts/foundation/foundation.clearing.js',
		'pivot/assets/scripts/foundation/foundation.alert.js',
		'pivot/assets/scripts/foundation/foundation.accordion.js',
		'pivot/assets/scripts/foundation/foundation.abide.js',
		'pivot/assets/scripts/pivot.js',
	),
	'remoteBasePath' => &$GLOBALS['wgStylePath'],
	'localBasePath'  => &$GLOBALS['wgStyleDirectory']
);
