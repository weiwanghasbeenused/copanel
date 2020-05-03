function anchor_offset(){
	var img_loader = new Image();
	var logoImage = document.querySelector('#logo img');
	var ticking = false;

	img_loader.onload = function(){
		var sMasthead = document.getElementById('masthead');
		var offset = sMasthead.offsetHeight;
		var sFilter_ctner = document.querySelector('#filter_ctner');
		var filter_h = sFilter_ctner.offsetHeight;
		var filter_top = offset - filter_h;
		sFilter_ctner.style.top = filter_top-1+'px';

		var referenceP = document.querySelector('.entry-content > p');
		var filter_margin = parseInt(getComputedStyle(sFilter_ctner)['margin-top']);
		var scroll_point = referenceP.offsetTop + referenceP.offsetHeight + filter_margin + offset;
		console.log(scroll_point);
		var isFilterFolded = false;
		var sTop = window.scrollY;
		if(sTop > scroll_point){
			sFilter_ctner.classList.add('folded');
			isFilterFolded = true;
		}
		window.addEventListener('scroll', function(){
			sTop = window.scrollY;
			if (!ticking) {
			    window.requestAnimationFrame(function() {
		    		if(sTop > scroll_point && !isFilterFolded ){
		    			sFilter_ctner.classList.add('folded');
		    			isFilterFolded = true;
		    		}else if(sTop <= scroll_point && isFilterFolded){
		    			sFilter_ctner.classList.remove('folded');
		    			sFilter_ctner.classList.remove('expanded');
		    			isFilterFolded = false;
		    		}
			      	ticking = false;
			    });

			    ticking = true;
			}
		});
		// expand button
		var sFilter_expand_btn = document.getElementById("filter_expand_btn");
		sFilter_expand_btn.addEventListener('click',function(){
			sFilter_ctner.classList.toggle('expanded');
		});
	};
	img_loader.src = logoImage.src;

}
if(!isMobile){
	anchor_offset();
	var sFilter_dash = document.getElementsByClassName('filter_dash');
	for(i = 0 ; i < sFilter_dash.length ; i++){
		var thisParent = sFilter_dash[i].parentElement;
		var temp = document.createElement('br');
		thisParent.insertBefore(temp, sFilter_dash[i]);
	}
}else{
	var sFilter_toggle_btn = document.getElementById('filter_toggle_btn');
	sFilter_toggle_btn.addEventListener('click',function(){
		sBody.classList.add('viewing_filter');
	});
	var sFilter_leave_btn = document.getElementById('filter_leave_btn');
	sFilter_leave_btn.addEventListener('click',function(){
		sBody.classList.remove('viewing_filter');
	});

}

