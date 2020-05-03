function title_control(){
	var body = document.body;
	if(body.classList.contains('home')){
		var sTitle = document.getElementsByClassName("entry-title");
		if(sTitle.length != 0)
			sTitle[0].style.display = 'none';
	}
}
title_control();