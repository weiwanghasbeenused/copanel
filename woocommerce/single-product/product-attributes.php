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
	$lang_var['en-US']['apartment'] = 'apartment';
	$lang_var['en-US']['studio'] = 'studio';
	$lang_var['en-US']['condo'] = 'condo';
	$lang_var['en-US']['coop'] = 'coop';
	$lang_var['en-US']['house'] = 'house';
	$lang_var['en-US']['multifamily'] = 'multifamily';

	$lang_var['zh-TW']['bathroom'] = '衛';
	$lang_var['zh-TW']['bedroom'] = '臥';
	$lang_var['zh-TW']['housing-type'] = '';
	$lang_var['zh-TW']['apartment'] = '公寓';
	$lang_var['zh-TW']['studio'] = '工作室';
	$lang_var['zh-TW']['condo'] = '獨立產權公寓';
	$lang_var['zh-TW']['coop'] = '合作公寓';
	$lang_var['zh-TW']['house'] = '獨棟別墅';
	$lang_var['zh-TW']['multifamily'] = '多單元房';

	$lang_var['zh-CN']['bathroom'] = '卫';
	$lang_var['zh-CN']['bedroom'] = '臥';
	$lang_var['zh-CN']['housing-type'] = '';
	$lang_var['zh-CN']['apartment'] = '公寓';
	$lang_var['zh-CN']['studio'] = '工作室';
	$lang_var['zh-CN']['condo'] = '独立产权公寓';
	$lang_var['zh-CN']['coop'] = '合作公寓';
	$lang_var['zh-CN']['house'] = '独栋别墅';
	$lang_var['zh-CN']['multifamily'] = '多单元房';
	
	$product_attr_filtered = array();
	$product_attr_filtered[] = str_replace(' ', '', strip_tags($product_attributes['attribute_pa_bedroom']['value'])).' '.$lang_var[$current_lang]['bedroom'];
	$product_attr_filtered[] = str_replace(' ', '', strip_tags($product_attributes['attribute_pa_bathroom']['value'])).' '.$lang_var[$current_lang]['bathroom'];
	$value_housing = str_replace(' ', '', strip_tags($product_attributes['attribute_pa_housing-type']['value']));
	$product_attr_filtered[] = $lang_var[$current_lang][$value_housing];

}
?>
<div class="woocommerce-product-attributes shop_attributes">
	<?php foreach ( $product_attr_filtered as $paf ) : ?>
		<span class = 'woocommerce-product-attributes-item'><?php echo $paf; ?></span>
	<?php endforeach; ?>
</div>
