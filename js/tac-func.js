var navheight = "4em";

/* -------------------------------------------------------- */

function showSource(){
    var source = "<html>";
    source += document.getElementsByTagName('html')[0].innerHTML;
    source += "</html>";
    //now we need to escape the html special chars, javascript has escape
    //but this does not do what we want
    source = source.replace(/<\/div>/g, "</div>\n").replace(/\t|\r|\n\n/g,"");
    //source = source.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    //now we add <pre> tags to preserve whitespace
    source = "<xmp>"+source+"</xmp>";
    //now open the window and set the source as the content
    sourceWindow = window.open('','Source of page','height=800,width=800,scrollbars=1,resizable=1');
    sourceWindow.document.write(source);
    sourceWindow.document.close(); //close the document for writing, not the window
    //give source window focus
    if(window.focus) sourceWindow.focus();
}  

/* -------------------------------------------------------- */

Array.prototype.clean = function(deleteValue) {
  for (var i = 0; i < this.length; i++) {
    if (this[i] == deleteValue) {         
      this.splice(i, 1);
      i--;
    }
  }
  return this;
};

Array.prototype.unique = function() {
  return this.filter(function (value, index, self) { 
    return self.indexOf(value) === index;
  });
}

function sfn(s) {
	return s.toLowerCase().replace(/\s/gi,'_').replace(/^\s+|\s+|\W$/gi,'');
}

function build_card_toc(key) {

		var divs = $('body').find(key); 
		var str = ''; var n=0;
		for (i = 0; i < divs.length; i++) { 
			var title = $(divs[i]).find('.card-header span').text();
			//var div_id = sfn(title)+n
			var div_id = $(divs[i]).data('name')+"_toc"+n;
			$(divs[i]).attr('id',div_id); n = n+1;
			$('#card-toc .list-group').append("<a class='toc-item list-group-item list-group-item-action' href='#"+div_id+"'>"+title+"</a>");
		}

		if (('nav.navbar.fixed-top').length>0) {

		$('aside').on( "click", "a", function(e) {
			var a = $(e.target).attr('href');
			var post = $(a).offset().top;

			$('html,body').animate({
				scrollTop: $(a).offset().top - 64
			}, 200);

			var aside = $(this).closest('aside')
			aside.removeClass('show'); 
			$("button[data-target='#"+aside.attr('id')+"']").data('toggle','aside');

		});

		}
}

$(function() {

	$('aside').on('click', 'span', function(e) {
		if ($(e.target).parent('button').hasClass('close')) {
			var parrent = $(e.target).closest('aside')
			$("button[data-target='#"+$(parrent).attr('id')+"']").data('toggle','aside')
			$(parrent).removeClass('show'); 
		}
	});	

	$("button.navbar-toggler[data-toggle='aside']").click(function(e){
		var target = $(this).data('target');
		var toggle = $(this).data('toggle');
		var height = window.innerHeight;
		if (!$(target).hasClass('topz')) {
			var top = $('nav.fixed-top').height();
			if (isNaN(top)) { 
				top = 0; height=height-56;
			} else { 
				top = top + 16; height=height-top;
			}
			$(target).css('top',top+"px");
			$(target).css('height',height+"px");
		} else {
			$(target).css('height',height+"px");
			if ($(target).find('button.close').length <= 0) {
				var title = $(target).data('title');
				var header = "<div class='aside-header'>";
				header += " <button type='button' class='close' data-aside=" + $(target).attr('id') +
					" modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
				if (typeof(title)!=undefined) { header += "<h5>"+title+"</h5>"; }
				header += "</div>"	

				$(target).prepend(header);

			}
		}

		if (toggle=='aside') { 
			$(target).addClass('show'); 
			$(this).data('toggle','show')
		} else { 
			$(target).removeClass('show'); 
			$(this).data('toggle','aside')
		}
	});

	$(".row.swipeable").swipe( {
		swipe:function(event, direction, distance, duration, fingerCount) {
			var divs = $(this).find('.'+$(this).data('swipe'));
			var m = divs.length -1;
			var anim = '';
			for (i = 0; i < divs.length; i++) { 
				$(divs[i]).attr('style','');
				if ( $(divs[i]).hasClass('show') ) { $(divs[i]).removeClass('show'); var c=i }
			}
			if (direction=='right') { 
				c=c-1; anim = 'from_left';
			} else if (direction=='left') { 
				c=c+1; anim = 'from_right';
			}

			if (c > m) { c = 0; } else if (c < 0) { c = m; }

			$(divs[c]).attr('style','animation:'+anim+' .25s')
			$(divs[c]).addClass('show');
		},	
		threshold:100,
		fingers:'all'
	});

	if ($('#card-toc').length>0) {  
		build_card_toc('.card.toc');
	}

	if ($('nav.navbar.fixed-bottom').length>0) {
		$('body').css('margin-bottom',navheight);
	}

	if ($('nav.navbar.fixed-top').length>0) {
		$('body').css('margin-top',navheight);
	}
	if ($('[data-toggle="tooltip"]').length>0) {
		$('[data-toggle="tooltip"]').tooltip();
	}

	if ($('[data-toggle="popover"]').length>0) {
		 $('[data-toggle="popover"]').popover()
	}

});