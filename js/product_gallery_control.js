var gallery_a = document.querySelectorAll(".woocommerce-product-gallery__wrapper a");
Array.prototype.forEach.call(gallery_a, function(el, i){
	var thisImgSrc = gallery_a[i].firstChild.getAttribute('src');
	gallery_a[i].classList.add('gallery_image_holder');
	gallery_a[i].style.backgroundImage = 'url('+thisImgSrc+')';

});

var sPosted_in = document.getElementsByClassName("posted_in")[0];
var sPosted_in_a = document.querySelectorAll(".posted_in a");
var temp_element = document.createElement('div');
Array.prototype.forEach.call(sPosted_in_a, function(el, i){
	el.classList.add('post_list_cate');
	temp_element.appendChild(el);
});
sPosted_in.innerHTML = temp_element.innerHTML;

var sWoocommerce_tabs = document.getElementsByClassName('woocommerce-tabs')[0];
sWoocommerce_tabs.classList.add('concentrated-box');

var current_lang = document.getElementsByTagName('html')[0].getAttribute('lang');
var lang_var = {
	'en-US': {
 		'bathroom': 'bathroom(s)',
 		'bedroom': 'bedroom(s)',
 		'housing-type': ''
	},
	'zh-TW': {
		'bathroom': '衛',
 		'bedroom': '臥',
 		'housing-type': ''
	},
	'zh-CN': {
		'bathroom': '卫',
 		'bedroom': '臥',
 		'housing-type': ''
	}
};

var sTr = document.querySelectorAll('table.woocommerce-product-attributes tr');
var sTr_parent = sTr[0].parentNode;
Array.prototype.forEach.call(sTr, function(el, i){
	var thisTag = el.children[0].innerText;
	if( thisTag != 'bathroom' && thisTag != 'bedroom' && thisTag != 'housing-type' ){
		sTr_parent.removeChild(el);
	}else{
		el.children[0].innerText = '';
		el.children[1].innerText = el.children[1].innerText+' '+lang_var[current_lang][thisTag];
	}
});


var sPrice = document.getElementsByClassName('price')[0];
var price = sPrice.innerText;
if(price.indexOf('.') != -1)
	sPrice.innerText = price.substring(0, price.indexOf('.'));