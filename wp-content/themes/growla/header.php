<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package growla
 */

if ( ! class_exists( 'Redux' ) ) {
	$growla_opt                               = array();
} else {
	global $growla_opt;
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<div class="back-to-top">
		<div class="back-to-top-inner">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-up</title><path d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z" /></svg>
		</div>
	</div>

	<div class="main-wrapper">

        <?php get_template_part( 'inc/template-parts/header/header', 'handler' ); ?>