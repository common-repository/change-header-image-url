<?php
/**
 * @package Change_WP_HDR_IMAGE
 * @author Veaceslav Mindru
 * @version 1.1.1
 */
/*
Plugin Name: Change header image url
Plugin URI: http://efiopko.com/2011/10/change-header-image-url/
Description: When you transfer your WP from one domain to another, you might want to update theme header image,background image url option from  theme_mods_theme inside wp_options.
Author: Veaceslav Mindru
Version: 1.1.1
Author URI: http://efiopko.com
*/
function admin_cwpd_options(){
echo '<div class="wrap"><h2>Change WP header image url</h2>';
if($_REQUEST['submit']){
	exec_cwpd();
} else {print_cwpd_form();}
echo '</div>';
}

function insert_new_menu(){
	add_options_page(
	'Header image url',
	'Header image url',
	'manage_options',
	__FILE__,
	'admin_cwpd_options'
	);
}

function exec_cwpd() {
        $newhdrimg = $_REQUEST['newheaderimage'];
	$newbgrimage = $_REQUEST['newbgrimage'];
	$newbgrimagethumb = $_REQUEST['newbgrimagethumb'];
	if (! empty($newhdrimg)){
	set_theme_mod(header_image,$newhdrimg); echo "<p>New headr image is <b>$newhdrimg </b><br>"; }
	if (! empty($newbgrimage)){
	set_theme_mod(background_image,$newbgrimage); echo "New background image is <b>$newbgrimage </b><br>"; }
	if (! empty($newbgrimagethumb)){
	set_theme_mod(background_image_thumb,$newbgrimagethumb); echo " New background image thumb is  <b>$newbgrimagethumb </b></p><br>"; }
	echo '<h3>Your database has been updated!</h3><br>';
	print_cwpd_form();
}

function print_cwpd_form(){
	$default = defined( 'HEADER_IMAGE' ) ? HEADER_IMAGE : '';
	$newhdrimg_old=get_header_image();
	$newbgrimage_old=get_theme_mod( 'background_image', $default );
	$newbgrimagethumb_old=get_theme_mod( 'background_image_thumb', $default );
	$yourblogurl = parse_url(get_site_url(),PHP_URL_HOST);

	$newhdrimg_sugest = str_replace(parse_url($newhdrimg_old,PHP_URL_HOST),$yourblogurl,$newhdrimg_old);
	$newbgrimage_sugest = str_replace(parse_url($newbgrimage_old,PHP_URL_HOST),$yourblogurl,$newbgrimage_old);
	$newbgrimagethumb_sugest = str_replace(parse_url($newbgrimagethumb_old,PHP_URL_HOST),$yourblogurl,$newbgrimagethumb_old);
?>

<P>Your blog dom is: <b><?=$yourblogurl; ?></b><br>
Old header Image: <b><?=$newhdrimg_old; ?></b><br>
Old Backgroud Image: <b><?=$newbgrimage_old; ?></b><br>
Old Backgroud Image thumb: <b><?=$newbgrimagethumb_old; ?></b></p>

Review sugested value or modify them as needed.

<form method="post">
	<label for="link">New header Image:</label>
	<input type="text" name="newheaderimage" value="<?=$newhdrimg_sugest ;?>" style="width:500px" />
	<br><label for="link">New background  Image:</label>
	<input type="text" name="newbgrimage" value="<?=$newbgrimage_sugest ;?>" style="width:500px" />
	<br><label for="link">New background image thumb:</label>
	<input type="text" name="newbgrimagethumb" value="<?=$newbgrimagethumb_sugest ;?>" style="width:500px" />
	<br><input type="submit" name="submit" value="Update WP" />
</form>
<h3><span style="color:red">BE CAREFUL:</span> I recomend to run a backup of WP mysql before runing this</h3>
<?
} 
add_action('admin_menu','insert_new_menu');
?>
