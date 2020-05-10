function anchor_offset(post_type){
	var sPost_anchor = document.getElementsByClassName('post-anchor');
	if(sPost_anchor.length != 0){
		var sPage = document.getElementById('page');
		var anchor_nav_ctner = document.createElement('div');
		anchor_nav_ctner.className = 'anchor-nav-ctner';
		anchor_nav_ctner.classList.add('anchor-nav-ctner_'+post_type);
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
		if(isMobile){
			var bookmark_toggle = document.createElement('div');
			bookmark_toggle.setAttribute('id', 'bookmark_toggle');
			var svg_ns = 'http://www.w3.org/2000/svg';
			var bookmark_svg = document.createElementNS(svg_ns, 'svg');
			bookmark_svg.setAttributeNS(null, 'viewBox', '0 0 100 100');
			var bookmark_polygon = document.createElementNS(svg_ns, 'polygon');
			bookmark_polygon.setAttribute('points', '78.7,100 50,70 21.3,100 21.3,0 78.7,0 ');
			bookmark_svg.appendChild(bookmark_polygon);
			bookmark_toggle.appendChild(bookmark_svg);
			anchor_nav_ctner.appendChild(bookmark_toggle);
			bookmark_toggle.addEventListener('click', function(){
				anchor_nav_ctner.classList.toggle('expanded');
			});
			var links = document.querySelectorAll('.anchor-nav a');
			Array.prototype.forEach.call(links, function(el, i){
				el.addEventListener('click', function(){
					anchor_nav_ctner.classList.remove('expanded');
				});
			});
		}
		var img_loader = new Image();
		var logoImage = document.querySelector('#logo img');

		var sMasthead = document.getElementById('masthead');
		var offset = sMasthead.offsetHeight;
		if(isMobile)
			anchor_nav_ctner.style.top = offset-2+'px';
		else
			anchor_nav.style.top = offset-2+'px';

		img_loader.onload = function(){
			var sMasthead = document.getElementById('masthead');
			var offset = sMasthead.offsetHeight;
			if(isMobile)
				anchor_nav_ctner.style.top = offset-2+'px';
			else
				anchor_nav.style.top = offset-2+'px';
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
				if(footer){
					newAnchor_position.push(entry_content_top + footer.offsetTop);
					return newAnchor_position;
					
				}else{
					newAnchor_position.push(entry_content_top + sEntry_content.clientHeight);
					return newAnchor_position;
				}				
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
		// if(isMobile)
	}
}
// if(!isMobile){
	var sBody = document.body;
	var post_type = '';
	if(sBody.classList.contains('page'))
		post_type = 'page';
	else if(sBody.classList.contains('single'))
		post_type = 'post';
	anchor_offset(post_type);
// }
