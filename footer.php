<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package copanel
 */
global $current_lang;

$site_info = array();

$site_info['zh-TW']['author'] = "Jerry C. Wang 王傳詠<br>紐約市前1%房產經紀人";
$site_info['zh-TW']['credit'] = "Copyright &copy; 2020 JERRY WANG 紐約曼哈頓地產經紀 | Credits<br>Powered by JERRY WANG 紐約曼哈頓地產經紀";

$site_info['zh-CN']['author'] = "Jerry C. Wang 王传咏<br>纽约市前1%房产经纪人";
$site_info['zh-CN']['credit'] = "Copyright &copy; 2020 JERRY WANG 纽约曼哈顿地产经纪 | Credits<br>Powered by JERRY WANG 纽约曼哈顿地产经纪";

$site_info['en-US']['author'] = "Jerry C. Wang 王傳詠<br>紐約市前1%房產經紀人";
$site_info['en-US']['credit'] = "Copyright &copy; 2020 JERRY WANG 紐約曼哈頓地產經紀 | Credits<br>Powered by JERRY WANG 紐約曼哈頓地產經紀";

?>

	</div><!-- #content -->
	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<p id = "site-info-author"><?php echo $site_info[$current_lang]['author']; ?></p>
			<p id = "site-info-credit"><?php echo $site_info[$current_lang]['credit']; ?></p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
