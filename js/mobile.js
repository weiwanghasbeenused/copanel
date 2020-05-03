
var sMenu_toggle = document.querySelector('.menu-toggle');

if(isMobile)
	adjust_menu();

function adjust_menu(){
	if(sMenu_toggle){
		sMenu_toggle.innerText = '';
		sMenu_toggle.innerHTML = '<div class = "menu_bar"></div><div class = "menu_bar"></div><div class = "menu_bar"></div>';
	}
}
window.resize = function(){
	if( isMobile )
		adjust_menu();
}

sMenu_toggle.addEventListener('click',function(){
	sBody.classList.toggle('viewing_menu');
});



