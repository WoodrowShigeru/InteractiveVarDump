(function($){

	$(document)
		 // overhead: inline togglers
		.on('click', '.ivd--toggle-inline', function(e){
			var
				tree = $(this).closest('.ivd--tree'),
				inliners = $('.ivd--scalar', tree)
			;
			if (inliners.first().is('.ivd--inline')) {
				inliners.removeClass('ivd--inline');
			} else {
				inliners.addClass('ivd--inline');
			}
		})


		 // overhead: protected property togglers
		.on('click', '.ivd--toggle-protected-properties', function(e){
			var
				tree = $(this).closest('.ivd--tree'),
				set = $('.ivd--protected', tree)
			;
			if (set.first().is('.ivd--hidden')) {
				set.removeClass('ivd--hidden');
			} else {
				set.addClass('ivd--hidden');
			}
		})


		 // overhead: private property togglers
		.on('click', '.ivd--toggle-private-properties', function(e){
			var
				tree = $(this).closest('.ivd--tree'),
				set = $('.ivd--private', tree)
			;
			if (set.first().is('.ivd--hidden')) {
				set.removeClass('ivd--hidden');
			} else {
				set.addClass('ivd--hidden');
			}
		})


		 // overhead: batch-collaps0rs (but exclude root-lvl-content)
		.on('click', '.ivd--batch-collapse', function(e){
			var
				tree = $(this).closest('.ivd--tree')
			;
			$('.ivd--item .ivd--content', tree).addClass('ivd--collapsed');
		})


		 // overhead: batch-expand0rs (but exclude root-lvl-content)
		.on('click', '.ivd--batch-expand', function(e){
			var
				tree = $(this).closest('.ivd--tree')
			;
			$('.ivd--item .ivd--content', tree).removeClass('ivd--collapsed');
		})


		 // depth controllers
		.on('click', '.ivd--controller', function(e){
			var
				controller = $(this),
				content = controller.nextAll('.ivd--content:first')
			;

			if (content.is('.ivd--collapsed')) {
				content.removeClass('ivd--collapsed');
			} else {
				content.addClass('ivd--collapsed');
			}
		})


		.ready(function(){

			 // overhead controllers.
			$('.ivd--tree').each(function(){
				var
					tree = $(this),
					html = ''
				;

				 // only add the overhead to items with complexity (depth).
				if (tree.find('.ivd--key').length) {
					html =
						'<ul class="ivd--overhead">'
					+   '<li class="ivd--toggle-inline">toggle-break inline</li>'
					;
					if ( $('.ivd--protected', tree).length ) {
						html += '<li class="ivd--toggle-protected-properties">toggle-show protected properties</li>';
					}

					if ( $('.ivd--private', tree).length ) {
						html += '<li class="ivd--toggle-private-properties">toggle-show private properties</li>';
					}
					if ( $('.ivd--content .ivd--controller', tree).length ) {
						html +=
								'<li class="ivd--batch-collapse">batch-collapse</li>'
						+   '<li class="ivd--batch-expand">batch-expand</li>'
						;
					}
					html += '</ul><!-- /.ivd--overhead -->';

					tree.prepend(html);
				}


				 // comfort-wrap for CSS.
				$('.ivd--controller, .ivd--overhead li', tree).wrapInner('<span class="ivd--clickable"></span>');


			});  // end of ( init trees )


		})  //__ end of ( READY )
	;  // end of ( document )

}(jQuery));
