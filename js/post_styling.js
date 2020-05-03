
function post_styling(concentrated = false){
	var bodyList = document.body.classList;
	if(bodyList.contains('single-post')){
		var sPosted_on = document.getElementsByClassName("posted-on");
		if(sPosted_on && sPosted_on.length > 0){
			for(i = 0; i < sPosted_on.length ; i++){
				var this_html = sPosted_on[i].innerHTML;
				this_html = this_html.replace("Posted on", "");
				sPosted_on[i].innerHTML = this_html;
			}
		}
		if(concentrated){
			var sEntry_content = document.getElementsByClassName("entry-content");
			if(sEntry_content && sEntry_content.length > 0){
				for(i = 0 ; i< sEntry_content.length ; i++){
					sEntry_content[i].classList.add('concentrated-box');
					sEntry_content[i].classList.add('p-mid');
					sEntry_content[i].classList.add('p-article');
					sEntry_content[i].classList.add('color-grey');
				}
			}
		}
		var sSubtitle = document.querySelectorAll(".entry-content h5");
		if(sSubtitle && sSubtitle.length > 0){
			for(i = 0 ; i<sSubtitle.length ; i++){
				sSubtitle[i].classList.add('post-subtitle');
			}
		}
	}
}

if(isMobile){
	post_styling();
}else{
	post_styling(true);
}