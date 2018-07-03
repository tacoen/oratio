function reader_function() {

	$('ul.browse li').on('click','a',function(e) {
		e.preventDefault;
		var table = $(this).closest('ul.browse').data('table');
		var subject = $(this).data('subject');
		var id = $(this).data('id');
		location.href = 'reader.php?id='+id+'&a='+subject+'&t='+table;
	})

	$('#instant-search').on('keyup input', function(e){
		var filter = $(this).val();
		$('ul.browse li').each(function () {
			if ($(this).text().search(new RegExp(filter, 'i')) < 0) {
				$(this).hide();
			} else {
				$(this).show();
			}
		});
	})

}

function editor_function() {

	$("button.act[data-action='editor']").click( function() {
		var str ='';		
		var state = $(this).data('state');
		var card = $(this).closest('div.card');
		var name = card.data('name')
		var ta = card.find('.card-body .current')
		var table = ta.data('table');
		var id = ta.data('id');
		var topics = ta.data('topics');
		var subject = ta.data('subject');
		var title = card.find('.card-header span').text();
		var content = ta.html();

		if (state=='off') {

			$(this).data('state','on');
			$(this).html("<i class='text-primary icah-edit-3'></i>")

			ta.data('ori',content)
			ta.data('ori_title',title)
			ta.data('ori_id',id)
			ta.data('ori_topic',topics)

			card.find('.card-header span').text("#"+id);

			var form = ""
			form += "<div class='form-group'><div class='input-group mb-3'>"
			form += "<div class='input-group-prepend'><button class='mode btn text-info' data-state='edit'><i class='icah-check-square'></i></button></div>"
			form += "<input type='text' class='form-control editor_title' placeholder='Title' value='"+title+"'>"
			form += "<div class='input-group-append'><button class='save btn text-body'><i class='icah-save'></i></button><button class='del btn text-danger'><i class='icah-x-circle'></i></button></div>"
			form += "</div>"
			form += "<div class='form-group'><textarea rows='12' class='form-control editor'>"+content+"</textarea></div>"
			form += "<div class='form-group'><input type='text' placeholder='topics' value='"+topics+"' class='form-control editor_topics'></div>"
			form += "<div class='form-group'><input type='text' placeholder='subject' value='"+subject+"' class='form-control editor_subject'></div>"

			ta.html(form);

			$('button.mode').click( function(e) {
				if ($(this).data('state')=='edit') {
					$(this).data('state','new');
					$(this).find('i').attr('class','icah-square')
					$(this).find('span').text('New')
					ta.find('.editor').val('');
					ta.find('.editor_title').val('');
					ta.find('.editor_topics').val('');
					ta.find('.editor_subject').val('');
					ta.data('id','')
					ta.find('button.del').prop('disabled',true);
					card.find('.card-header span').text("New Record");
				} else {
					$(this).data('state','edit');
					$(this).find('i').attr('class','icah-check-square')
					$(this).find('span').text('Edit')
					ta.find('.editor').val(ta.data('ori'))
					ta.find('.editor_title').val(ta.data('ori_title'))
					ta.find('.editor_topics').val(ta.data('ori_topic'))
					ta.find('.editor_subject').val(ta.data('ori_subject'))
					card.find('.card-header span').text("#"+ta.data('ori_id'));
					ta.data('id',ta.data('ori_id'))
					ta.find('button.del').prop('disabled',false);
				}
			})

			$('button.save').click( function(e) {
				var txt=ta.find('.editor').val();
				var title=ta.find('.editor_title').val();
				var topic=ta.find('.editor_topics').val();
				var subject=ta.find('.editor_subject').val();
				var id=ta.data('id');
				//console.log(id,title,txt,subject,topic);
				var posting = $.post( "xhr.php", { x:txt, t:title, s:subject, p:topic, i:id, c:'renungan_save' } );
				posting.done ( function(e,d,res) { 
					var alert = "<div class='pop-alert alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Success! </strong>"+e+"</div>";
					$('body').prepend(alert);
				})

			})

			$('button.del').click( function(e) {
				var id=ta.data('id');
				$.get("xhr.php?c=renungan_delete&i="+id, function(r){})
				console.log(ta.data())
			})			

		} else {

			$(this).data('state','off');
			$(this).html("<i class='icah-edit-3'></i>")

			card.find('.card-body .current').html(ta.data('ori'));
			card.find('.card-body .current').data('id',ta.data('ori_id'));
			card.find('.card-header span').text(ta.data('ori_title'));

			ulra();

		}

	})

}

function personalize_function() {

	$("#personalize-form button.personalize-submit").click( function(e) {

	e.preventDefault();

	var p = $('body').find('p');
	var nama_input = $("#personalize-form input.nama").val();

	$.each(p, function(i,d) {
		str = $(this).html()
		var str = str.replace(/\[nama\]/g, "<span class='pray-for'></span>");
		$('span.pray-for').text(nama_input);
		$(this).html(str)
	})

	var aside = $("#personalize");
	aside.removeClass('show'); 
	$("button[data-target='#"+aside.attr('id')+"']").data('toggle','aside');

	})

}	

function randomo(total,current) {
	if (current < 0) { current = total; }
	var r = Math.floor((Math.random() * total));
	if (r==current) { r = r + 1; }
	if (r==total) { r = 0; }
	return r;
}

function get_bucket(obj, bucket, current, chains) {	
	var total = bucket.children('li').length;
	var r = randomo(total,current);
	obj.data('li',r);
	var html = bucket.find("li:eq("+r+")").html();
	obj.html(html)
	if (chains!='') {
		var bucket_chains = $("#bucket ol[data-name='"+chains+"']");
		var html_chained = bucket_chains.find("li:eq("+r+")").html();
		$(".chains[data-name='"+chains+"'] span.ask").html(html)		
		$(".chains[data-name='"+chains+"'] span.answer").html(html_chained)
	}
}

function keeps_function() {

	$('.keeps a.save').unbind();
	$('.keeps_list a span.delete').unbind();
	$('.keeps_list').unbind();

	$("div.keeps input[type='text'").click( function(e) {
		var keeps = $(this).closest('div.keeps')
		var subject = keeps.data('subject');
		if (keeps.find ('.keeps_list').length<=0) {
			keeps.find('.dropdown-menu').append("<div class='keeps_list'></div>")
			var list = keeps.find ('.keeps_list');
			$.getJSON( "xhr.php?c=keeps_list&s="+subject, function(res) {
				$.each(res, function(i,d) {
					list.append("<a class='dropdown-item' data-id='"+d['id']+"' href='#'><span class='float-right text-danger delete'>&times;</span><span class='text'>"+d['html']+"</span></a>") 
				});
			})
		}

	});

	$('.keeps_list').on('click','a', function(e) {
		e.preventDefault();
		var id = $(this).data('id');
		var html = $(this).find('.text').text()
		var input = $(this).closest('div.keeps').find("input[type='text']")
		input.val(html);
	})

	$('.keeps_list a span.delete').click(function(e) {
		e.preventDefault();
		var id = $(this).parent('a').data('id');
		$.get("xhr.php?c=keeps_delete&i="+id, function(r){})
		$(this).parent('a').remove();
	})

	$('.keeps a.save').on('click', function(e) {
		e.preventDefault()
		var input = $(this).closest('div.keeps').find("input[type='text']")
		var newkeeps = input.val();
		$(this).closest('div.keeps').find(".keeps_list").append("<a href='#' class='dropdown-item'><span class='text'>"+newkeeps+"</span></a>")
		var subject = $(this).closest('div.keeps').data('subject');
		$.get( "xhr.php?c=keeps_save&s="+subject+"&t="+newkeeps, function(r){})
	})

}

function topic_pick_function() {

	$('.words_topics_list').on('click','a', function(e) {

	e.preventDefault()

	if ($(this).hasClass('topic')) {
		var sta = 'none'; var new_sta = 'in text-primary';
		if ( $(this).hasClass('none') ) { $(this).removeClass('none'); }
		if ( $(this).hasClass('in') ) { sta = 'in'; new_sta = 'out text-danger'; $(this).removeClass('in'); }
		if ( $(this).hasClass('out') ) { sta = 'out'; new_sta = 'none text-body'; $(this).removeClass('out'); }
		$(this).attr('class', new_sta+" topic list-group-item d-flex justify-content-between align-items-center");
	}

	});

	$('.words_topics_list').on('click','button', function(e) {
		var list = $(this).closest('.words_topics_list').find('.list-group');
		var a = list.find('a.topic')
		var topic_in = ""
		var topic_out = ""
		a.each(function(i){
			if ( $(this).hasClass('in') ) { topic_in += $(this).data('topic')+"," }
			if ( $(this).hasClass('out') ) { topic_out += $(this).data('topic')+"," }
		})
		topic_in = topic_in.replace(/,$/,"")
		topic_out = topic_out.replace(/,$/,"")

		var name = $(this).closest('div.modal').attr('id');

		$(".words[data-name='"+name+"']").data('topic_in',topic_in)
		$(".words[data-name='"+name+"']").data('topic_out',topic_out)

		$(".words[data-name='"+name+"']").attr('data-topic_out',topic_out)
		$(".words[data-name='"+name+"']").attr('data-topic_in',topic_in)

		$("#bucket ol[data-name='"+name+"']").remove();

		if ( $(this).closest('.words_topics_list').hasClass('chains') ) {
			var chains = name.replace(/_ask/,"_answer")
			$("#bucket ol[data-name='"+chains+"']").remove();
		}

		random_words( $(".words[data-name='"+name+"'] p.random") )

		$("#"+name).modal('hide');

	});
}

function random_words(obj) {
	var par = obj.parent('.words');
	var name = par.data('name');
	var subject = par.data('subject');
	var topic_in = par.data('topic_in');
	var topic_out = par.data('topic_out');

	 if (subject===undefined ) { subject=''; }
	 if (topic_in===undefined ) { topic_in=''; }
	 if (topic_out===undefined ) { topic_out=''; }
	 if (name===undefined ) { name=subject; }

	var current = obj.data('li'); if ((current===undefined)||(current=='')) { current = 0; }
	var bucket = $("#bucket ol[data-name='"+name+"']");
	var table = 'words';
	var chains ='';
	var scope ='';

	if (bucket.length<=0) { 

		if (par.hasClass('chains')) { table = 'chains'; scope='ask'; }

		chains = name.replace(/_ask/,"_answer");

		$.getJSON("xhr.php?c="+table+"&s="+subject+"&i="+topic_in+"&o="+topic_out+"&x="+scope, function(result){
			$('#bucket').append("<ol data-name='"+name+"'></ul>")
			var bucket = $("#bucket ol[data-name='"+name+"']");
			$.each(result, function(i,d){ bucket.append("<li data-id='"+d['id']+"'>"+d['words']+"</li>"); });

			if (table=='chains') {
				$.getJSON("xhr.php?c="+table+"&s="+subject+"&i="+topic_in+"&o="+topic_out+"&x="+'answer', function(result){
					$('#bucket').append("<ol data-name='"+chains+"'></ul>")
					var bucket_chains = $("#bucket ol[data-name='"+chains+"']");
					$.each(result, function(i,d){ bucket_chains.append("<li data-id='"+d['id']+"'>"+d['words']+"</li>"); });
					return get_bucket(obj,bucket,current,chains);
				})
			}

			return get_bucket(obj,bucket,current,chains);

		});

	} else {

		if (par.hasClass('chains')) { 
			chains = name.replace(/_ask/,"_answer");
		}

		return get_bucket(obj,bucket,current,chains);
	}
}

function clean_text(str) {
	return str.replace(/\W$/,"").replace(/\s+$|^\s+/,"");
}

function pick(obj) {
	var data_str = obj.parent('.words').data('words');
	var data = data_str.split(',');
	var current=obj.data('nth');
	if (current<0) { 
		data.push(obj.text()); 
		var data_str = data.join(',');
		obj.parent('li').data('words',data_str);
	}
	var r = randomo(data.length,current);
	obj.html(data[r]);
	obj.data('nth',r);
}	

function ulra () {
	$('.words').on('click','p',function(e) {
		if ( $(this).hasClass('random') ) { random_words($(this)); }
		if ( $(this).hasClass('pick') ) { pick($(this)); }
	});	

	$('a.can-delete').click( function(e) {
		e.preventDefault();
		$(this).closest('li').remove();
	});

}

function clipboard_html(name,str,title,id) {
	var html = 	"<div class='clipboard' data-name='"+name+"'>" +
			"<ul class='nav nav-tabs'>" +
			"<li class='nav-item'><a class='nav-link view active' data-toggle='tab' href='#view_"+name+"'>View</a></li>" +
			"<li class='nav-item'><a class='nav-link edit' data-toggle='tab' href='#edit_"+name+"'>Edit</a></li>" +
			"<li class='nav-item'><a class='nav-link browse' data-toggle='tab' href='#browse_"+name+"'>Browse</a></li>" +
			"</ul>" +
			"<div id='TabContent_"+name+"' class='tab-content bg-white text-body'>" +
			"<form class='tab-pane fade edit' id='edit_"+name+"' data-id='"+id+"'>" +
			"<textarea class='form-control mb-3 text' rows='11'>" + 
			str +
			"</textarea>"+
			"<div class='input-group'>";
		if (id!='') {
			html += "<div class='input-group-prepend'><button class='btn doa-delete text-danger'><i class='icah-x-circle'></i></button></div>";
		}

	html +=	"<input type='text' class='form-control saveas' placeholder='Save as...' value='"+title+"'aria-label='FileName'>" +
			"<div class='input-group-append'><button class='btn doa-save '><i class='icah-save'></i></button></div>" + 
			"</div>";
	html +=	"</form>" +
			"<div class='tab-pane fade show view active' id='view_"+name+"'>" +
			"<div class='text-body'><h5 class='doa-title text-muted'>"+title+"</h3>"+str +"</div>" +
			"</div>" +
			"<div class='tab-pane fade browse' id='browse_"+name+"'>" +
			"<ul class='filelist'></ul>" +
			"</div>" +
			"</div>" +
			"</div>"
	return html
}

function clipboard_browse(card, name) {

	$.getJSON("xhr.php?c=clips_list&s="+name, function(r){

		var html = '';
		$.each(r, function(i,d){ 
			html += "<li class='file'><a href='#' data-id='"+d['id']+"'>"+d['title']+"<span class='text-muted float-right small'>"+d['datetime']+"</span></a></li>";
		});

		list = card.find('div.browse').find('ul.filelist')
		list.html(html);

		$('button.doa-save').click( function(e) {
			e.preventDefault();
			var form = $(this).closest('form');
			var txt = form.find('textarea.text').val();
			var title = form.find('input.saveas').val();
			var id = form.data('id');
			posting = $.post( "xhr.php", { x:txt, t:title, s:name, i:id, c:'clip_save' } );
			posting.done ( function(e,d,res) { 
				var alert = "<div class='pop-alert alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Success! </strong>"+e+"</div>";
				$('body').prepend(alert);
			})

		});

		$('button.doa-delete').click( function(e) {
			e.preventDefault();
			var form = $(this).closest('form');
			var id = form.data('id');
			$.get("xhr.php?c=clip_delete&i="+id, function(r){})

		});

		$('.clipboard li.file').on('click','a', function(e) {
			e.preventDefault()
			$.getJSON("xhr.php?c=clips&i="+$(this).data('id'), function(r){
				card.find('.card-body').html( clipboard_html(name,r['words'],r['title'],r['id']) )
				clipboard_browse (card,name)
			})
		});

	});
}

function change_doa(div,res,index,id,d) {
	div.children('h5').html(res['title']);
	div.children('div').html(res['html']);
	div.data('current_id',id);
	index.find('.item').removeClass('text-danger');
	index.find(".item:nth-child("+(d+1)+")").addClass('text-danger');
}

function cache_doa(name,id,res) {
	if ($("div#cache ol."+name).length < 1) { $('div#cache').append("<ol class='"+name+"'></ol>"); }
	$("div#cache ol."+name).append("<li data-id='"+id+"' data-title='"+res['title']+"'>"+res['html']+"</li>");
}

$(function() {

	ulra();

	$("select.pickline").change( function(e) {
		var str =''
		var nfor = $(this).data('for');
		$(this).find("option:selected" ).each(function() { str = $(this).text(); })
		var card = $(this).closest('div.card');
		card.find('p.'+nfor).html(str);
 });		

	$(".bacaan_pick a").click( function(e) {
		e.preventDefault();
		var id = $(this).data('id')
		var subject = $(this).data('subject')
		var name = $(this).closest('.bacaan_pick').data('name')
		var prepend = '';
		var append = '';
		if (subject=='injil') {
			prepend = "<p class='g mb-2'>Berdiri untuk pembacaan Injil</p>"
			prepend += "<p class='p'>Tuhan beserta mu...</p><p class='u'>Beserta mu juga.</p>"
			prepend += "<p class='p'>Inilah injil menurut <span class='who'>[who]</span></p><p class='c'>Dimuliakanlah Tuhan</p>";
			append = "<p class='p mt-2'>Demikianlah injil Tuhan</p><p class='u'>Terpujilah Kristus</p>";
		} else if (subject=='bacaan') {
			prepend = "<p class='which'>[which]</p>";
			append = "<p class='p mt-2'>Demikianlah sabda Tuhan</p><p class='u'>Syukur kepada Allah</p>";
		}

		$.getJSON("xhr.php?c=bacaan&i="+id, function(res){
			var div = $(".card li.oratio .bacaan[data-name='"+name+"'] div.current");
			div.data('id',id);
			div.children('h5').html(res['title']);
			div.children('div').html(prepend + res['html'] + append);
			$("#"+name).modal('hide');
			$('span.who').text( div.find('p.i').data('who'));
			$('span.which').text( div.find('p.i').data('which'));
		})

	});

		$(".renungan_pick a").click( function(e) {
		e.preventDefault();
		var id = $(this).data('id')
		var subject = $(this).data('subject')
		var name = $(this).closest('.renungan_pick').data('name')
		var prepend = '';
		var append = '';
		if (subject=='injil') {
			prepend = "<p class='g mb-2'>Berdiri untuk pembacaan Injil</p>"
			prepend += "<p class='p'>Tuhan beserta mu...</p><p class='u'>Beserta mu juga.</p>"
			prepend += "<p class='p'>Inilah injil menurut <span class='who'>[who]</span></p><p class='c'>Dimuliakanlah Tuhan</p>";
			append = "<p class='p mt-2'>Demikianlah injil Tuhan</p><p class='u'>Terpujilah Kristus</p>";
		} else if (subject=='bacaan') {
			prepend = "<p class='which'>[which]</p>";
			append = "<p class='p mt-2'>Demikianlah sabda Tuhan</p><p class='u'>Syukur kepada Allah</p>";
		}

		$.getJSON("xhr.php?c=renungan&i="+id, function(res){
			var div = $(".card li.oratio .renungan[data-name='"+name+"'] div.current");
			div.data('id',id);
			div.children('h5').html(res['title']);
			div.children('div').html(prepend + res['html'] + append);
			$("#"+name).modal('hide');
			$('span.who').text( div.find('p.i').data('who'));
			$('span.which').text( div.find('p.i').data('which'));
		})

	});

	$(".swipeable.doa .index .item").on('click',function (e) {

		var id = $(this).data('id'); var obj = $(this);
		var c = $(this).closest(".swipeable.doa");
		var name = $(this).closest('div.card').data('name')
		var current = c.children('div.current');
		var index = c.children('div.index');
		var cache = $('div#cache ol.'+name+' li[data-id='+id+']');
		if (cache.length < 1) {
			$('body').append("<div id='cache' style='display:none'></div>");
			$.getJSON("xhr.php?c=doa&i="+id, function(res){
				change_doa(current,res,index,id,obj.index());
				cache_doa(name,id,res);
			})
		} else {
			id = cache.data('id');
			res = Object;
			res['title'] = cache.data('title');
			res['html'] = cache.html();
			change_doa(current,res,index,id,obj.index());
		}

	});

	$("button.act[data-action='swipe']").click( function() {
		var state = $(this).data('state');
		var card = $(this).closest('div.card');
		if(state=='on') {
			card.find(".swipeable.doa").swipe('disable');
			$(this).data('state','off')
			$(this).addClass('text-light');
		} else {
			card.find(".swipeable.doa").swipe('enable');
			$(this).data('state','on')
			$(this).removeClass('text-light');
		}
	});

	$(".swipeable.doa").swipe( {

		swipeStatus:function(event, phase, direction, distance, duration, fingers, fingerData, currentDirection) {
			var current = $(this).children('div.current')
			if ((phase=="move") && (distance>64)) {
				if ((direction=='left') || (direction=='right')) {
					current.attr("style",direction+": -"+distance+"px;opacity:.6");
				}
			} else {
				current.attr('style',"");
			}
		},

		swipe:function(event, direction, distance, duration, fingerCount) {
			var list = $(this).data('list').split(',')
			var current = $(this).children('div.current')
			var name = $(this).closest('div.card').data('name')
			var index = $(this).children('div.index');
			var m = list.length
			var c = list.indexOf(current.data('current_id').toString());

			current.attr('style','');

			if (direction=='left') { d=c+1; anim = 'from_right'; } 
			else if (direction=='right') { d=c-1; anim = 'from_left'; }

			if (d>=m) { d=0 }
			if (d<0) { d=m-1 }

			var id = list[d];			

			//console.log( direction, id, 'start', c, d, m );
			//current.attr('style','animation:'+anim+ " .25s 1s");

			var cache = $('div#cache ol.'+name+' li[data-id='+id+']');

			if (cache.length < 1) {
				$('body').append("<div id='cache' style='display:none'></div>");
				$.getJSON("xhr.php?c=doa&i="+id, function(res){
					change_doa(current,res,index,id,d);
					cache_doa(name,id,res);
				})
			} else {
				id = cache.data('id');
				res = Object;
				res['title'] = cache.data('title');
				res['html'] = cache.html();
				change_doa(current,res,index,id,d);

			}
		},	

		threshold:window.innerWidth/4,
		fingers:'all'
	});		

	$("button.act[data-action='href']").click( function(e) {
		var url = $(this).data('ori');
		location.href=url;
	});

	$("button.act[data-action='collapse']").click( function() {
		var state = $(this).data('state');
		var card = $(this).closest('div.card');
		var body = card.find('.card-body');
		if (state=='on') {
			body.addClass('collapse')
			 $(this).data('state','off');
			 $(this).html("<i class='icah-plus-square'></i>")
		} else {
			body.removeClass('collapse')
			 $(this).data('state','on');
			 $(this).html("<i class='icah-minus-square'></i>")
		}

	});

	$("button.act[data-action='clipboard']").click( function() {
		var str ='';
		var state = $(this).data('state');
		var card = $(this).closest('div.card');
		var name = card.data('name')

		if (state=='off') {

			$(this).data('state','on');
			$(this).html("<i class='text-primary icah-clipboard'></i>")
			$(this).data('ori', card.find('.card-body').html());

			var p = card.find('p');
			p.each( function(i) { str += clean_text( $(this).not('.noclip').text() ) +". "; })
			var str = str.replace(/^\W\s+/,'');
			card.find('.card-body').html( clipboard_html(name, str, '','') )
			var list = card.find('div.browse').find('ul.filelist');

			clipboard_browse(card, name, list);

		} else {

			$(this).data('state','off');
			$(this).html("<i class='icah-clipboard'></i>")
			card.find('.card-body').html($(this).data('ori'));
			$(this).data('ori','');
			ulra();

		}

	})

	topic_pick_function();
	keeps_function();
	editor_function();
	reader_function();

	if ($('#personalize').length>0) { 
		//build_personalize();
		personalize_function();
	}

});

