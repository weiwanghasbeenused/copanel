<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}else{
	global $current_lang;
	// var_dump($product_attributes);

	$lang_var = array();
	$lang_var['en-US']['bathroom'] = 'bathroom(s)';
	$lang_var['en-US']['bedroom'] = 'bedroom(s)';
	$lang_var['en-US']['housing-type'] = '';
	$lang_var['zh-TW']['bathroom'] = '衛';
	$lang_var['zh-TW']['bedroom'] = '臥';
	$lang_var['zh-TW']['housing-type'] = '';
	$lang_var['zh-CN']['bathroom'] = '卫';
	$lang_var['zh-CN']['bedroom'] = '臥';
	$lang_var['zh-CN']['housing-type'] = '';
	
	$product_attr_filtered = array();
	$product_attr_filtered[] = str_replace(' ', '', strip_tags($product_attributes['attribute_pa_bedroom']['value'])).' '.$lang_var[$current_lang]['bedroom'];
	$product_attr_filtered[] = str_replace(' ', '', strip_tags($product_attributes['attribute_pa_bathroom']['value'])).' '.$lang_var[$current_lang]['bathroom'];
	$product_attr_filtered[] = str_replace(' ', '', strip_tags($product_attributes['attribute_pa_housing-type']['value'])).' '.$lang_var[$current_lang]['housing-type'];

}
?>
<div class="woocommerce-product-attributes shop_attributes">
	<?php foreach ( $product_attr_filtered as $paf ) : ?>
		<span class = 'woocommerce-product-attributes-item'><?php echo $paf; ?></span>
	<?php endforeach; ?>
</div>
