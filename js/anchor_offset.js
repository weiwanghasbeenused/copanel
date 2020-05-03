function anchor_offset(){
	var sPost_anchor = document.getElementsByClassName('post-anchor');
	if(sPost_anchor.length != 0){
		var sPage = document.getElementById('page');
		var anchor_nav_ctner = document.createElement('div');
		anchor_nav_ctner.className = 'anchor-nav-ctner';
		var anchor_nav = document.createElement('ul');
		var anchor_num = sPost_anchor.length;
		anchor_nav.className = 'anchor-nav'; 
		for(i = 0; i< anchor_num ; i++){
			var li = document.createElement('li');
			var thisAnchor = sPost_anchor[i].id;
			var thisText = sPost_anchor[i].innerText;
			li.innerHTML = '<a href = "#'+thisAnchor+'">'+thisText+'</a>'
			anchor_nav.appendChild(li);
		}
		anchor_nav_ctner.appendChild(anchor_nav);
		sEntry_content = document.getElementsByClassName('entry-content')[0];
		sEntry_content.style.position = 'relative';
		sEntry_content_firstChild = sEntry_content.children[1];
		sEntry_content.insertBefore(anchor_nav_ctner, sEntry_content_firstChild);
		entry_content_top = sEntry_content.offsetTop;
		var img_loader = new Image();
		var logoImage = document.querySelector('#logo img');

		img_loader.onload = function(){
			var sMasthead = document.getElementById('masthead');
			var offset = sMasthead.offsetHeight;
			anchor_nav.style.top = offset-2+'px';
			var before = document.querySelectorAll('.post-anchor')
			for(i = 0 ; i < anchor_num ; i ++){
				sPost_anchor[i].query
			}
		};

		
		if(sPost_anchor && sPost_anchor.length > 0){
			var anchor_position = [];
			var sAnchor_nav_li = document.querySelectorAll('.anchor-nav > li');
			var observer = [];
			var options = [];

			var contentStable = false;
			var ticking = false;
			var current_section = -1;

			function updateAnchorPosition(){
				sPost_anchor = document.getElementsByClassName('post-anchor');
				var newAnchor_position = [];
				Array.prototype.forEach.call(sPost_anchor, function(el, i){
					newAnchor_position[i] = entry_content_top + el.offsetTop;
				});
				var footer = document.querySelector(".footer-meta.post-meta");
				newAnchor_position.push(entry_content_top + footer.offsetTop);
				console.log(newAnchor_position);
				return newAnchor_position;
			}

			anchor_position = updateAnchorPosition();

			window.addEventListener('scroll', function(){
				sTop = window.scrollY;
				if (!ticking) {
				    window.requestAnimationFrame(function() {
			    		if(updateAnchorPosition() == anchor_position && !contentStable){
			    			contentStable = true;
			    		}else{
			    			anchor_position = updateAnchorPosition();
			    		}
			    		// anchor_position = updateAnchorPosition();
			    		if(sTop < anchor_position[0] || sTop > anchor_position[anchor_position.length-1]){
			    			var sActive = document.querySelector('.anchor-nav > li.active');
			    			if(sActive)
			    				sActive.classList.remove('active');
			    			current_section = -1;
			    		}else{
				    		for( i = 0 ; i < anchor_position.length ; i ++ ){
				    			if( sTop >= anchor_position[i] && sTop < anchor_position[i+1] && i != current_section){
				    				var sActive = document.querySelector('.anchor-nav > li.active');
					    			if(sActive)
					    				sActive.classList.remove('active');
					    			sAnchor_nav_li[i].classList.add('active');
					    			current_section = i;
					    			break;
				    			}
				    		}
			    		}

				      	ticking = false;
				    });

				    ticking = true;
				}
			});
			}
		img_loader.src = logoImage.src;
	}
}

if(!isMobile){
	anchor_offset();
}
