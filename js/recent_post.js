
function recent_post(parent){
	var recent_post_img = document.querySelectorAll("#"+parent+" img");
	if(recent_post_img && recent_post_img.length>0){
		for(i = 0; i < recent_post_img.length ; i++){
			var temp_el = document.createElement('div');
			var this_el = recent_post_img[i];
			temp_el.style.backgroundImage = 'url("'+recent_post_img[i].src+'")';
			temp_el.className = 'thumbnail';
			this_el.parentNode.replaceChild(temp_el, this_el);
		}
	}
	

	var recent_post_cato = document.querySelectorAll("#"+parent+" .rpwwt-post-categories");
	if(recent_post_cato && recent_post_cato.length>0){
		for(i = 0; i < recent_post_cato.length ; i++){
			recent_post_cato[i].classList.add('cat-links');
			var this_html = recent_post_cato[i].innerHTML;
			this_html = this_html.replace(", ", "");
			this_html = this_html.replace("、", "");
			recent_post_cato[i].innerHTML = this_html;
		}
	}
}