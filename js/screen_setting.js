var wW = window.innerWidth,
	wH = window.innerHeight;
var sBody = document.getElementsByTagName('body')[0];

var isMobile = false;

if(wW <= 813){
	isMobile = true;
	sBody.classList.add('isMobile');
}else{
	sBody.classList.add('hover');
}

window.resize = function(){
	wW = window.innerWidth;
	if( isMobile && wW>813){
		isMobile = false;
	}else if(!isMobile && wW<=813){
		isMobile = true;
	}
}


var sMenu_toggle = document.querySelector('.menu-toggle');

sMenu_toggle.addEventListener('click',function(){
	sBody.classList.toggle('viewing_menu');
});





