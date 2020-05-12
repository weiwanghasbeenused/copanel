// var gallery_a = document.querySelectorAll(".woocommerce-product-gallery__wrapper a");
// Array.prototype.forEach.call(gallery_a, function(el, i){
// 	var thisImgSrc = gallery_a[i].firstChild.getAttribute('src');
// 	gallery_a[i].classList.add('gallery_image_holder');
// 	gallery_a[i].style.backgroundImage = 'url('+thisImgSrc+')';

// });

var sPrice = document.getElementsByClassName('price')[0];
var price = sPrice.innerText;
if(price.indexOf('.') != -1)
	sPrice.innerText = price.substring(0, price.indexOf('.'));