(function($){

	$(document)
		 // overhead: inline togglers
		.on('click', '.ivd__toggle-inline', function(e){
			var
				tree = $(this).closest('.ivd__tree'),
				inliners = $('.ivd__scalar', tree)
			;
			if (inliners.first().is('.ivd--inline')) {
				inliners.removeClass('ivd--inline');
			} else {
				inliners.addClass('ivd--inline');
			}
		})


		 // overhead: protected property togglers
		.on('click', '.ivd__toggle-protected-properties', function(e){
			var
				tree = $(this).closest('.ivd__tree'),
				set = $('.ivd--protected', tree)
			;
			if (set.first().is('.ivd--hidden')) {
				set.removeClass('ivd--hidden');
			} else {
				set.addClass('ivd--hidden');
			}
		})


		 // overhead: private property togglers
		.on('click', '.ivd__toggle-private-properties', function(e){
			var
				tree = $(this).closest('.ivd__tree'),
				set = $('.ivd--private', tree)
			;
			if (set.first().is('.ivd--hidden')) {
				set.removeClass('ivd--hidden');
			} else {
				set.addClass('ivd--hidden');
			}
		})


		 // overhead: batch-collaps0rs (but exclude root-lvl-content)
		.on('click', '.ivd__batch-collapse', function(e){
			var
				tree = $(this).closest('.ivd__tree')
			;
			$('.ivd__item .ivd__content', tree).addClass('ivd--collapsed');
		})


		 // overhead: batch-expand0rs (but exclude root-lvl-content)
		.on('click', '.ivd__batch-expand', function(e){
			var
				tree = $(this).closest('.ivd__tree')
			;
			$('.ivd__item .ivd__content', tree).removeClass('ivd--collapsed');
		})


		 // depth controllers
		.on('click', '.ivd__controller', function(e){
			var
				controller = $(this),
				content = controller.nextAll('.ivd__content:first')
			;

			if (content.is('.ivd--collapsed')) {
				content.removeClass('ivd--collapsed');
			} else {
				content.addClass('ivd--collapsed');
			}
		})


		 // rccleanup -- new feature: key , path , traverse up
		.on('click', '.ivd__key', (ev) => {
			let
				$self = $(ev.currentTarget),
				parents = $self.parents('.ivd__item').get(),
				path = 'root'
			;
			parents.reverse();

			parents.forEach((item) => {
				let
					$key = $('.ivd__key:first', item),
					type = $key.attr('data-type'),
					text = $key.find('.ivd__key-core').text()
				;
				path += type === 'array-key'   ? `['${text}']`   : `->${text}`;
			});

			console.log('key-clicked.', path);
			// TODO  great. Now display nicely, plz.
		})


		.ready(function(){

			 // overhead controllers.
			$('.ivd__tree').each(function(){
				var
					tree = $(this),
					html = ''
				;

				 // only add the overhead to items with complexity (depth).
				if (tree.find('.ivd__key').length) {
					html =
						'<ul class="ivd__overhead">'
					+   '<li class="ivd__toggle-inline">toggle-break inline</li>'
					;
					if ( $('.ivd--protected', tree).length ) {
						html += '<li class="ivd__toggle-protected-properties">toggle-show protected properties</li>';
					}

					if ( $('.ivd--private', tree).length ) {
						html += '<li class="ivd__toggle-private-properties">toggle-show private properties</li>';
					}
					if ( $('.ivd__content .ivd__controller', tree).length ) {
						html +=
								'<li class="ivd__batch-collapse">batch-collapse</li>'
						+   '<li class="ivd__batch-expand">batch-expand</li>'
						;
					}
					html += '</ul><!-- /.ivd__overhead -->';

					tree.prepend(html);
				}


				 // comfort-wrap for CSS.
				$('.ivd__controller, .ivd__overhead li', tree).wrapInner('<span class="ivd--clickable"></span>');

				if (tree.is('.ivd--start-collapsed')) {
					tree.find('.ivd__controller:first').trigger('click');
				}

			});  // end of ( init trees )


		})  //__ end of ( READY )
	;  // end of ( document )

}(jQuery));
