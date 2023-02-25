;(function( $ ) {
	// TODO  add change-log.
	// TODO  nocolors × new features (dismiss, show-path).

	$(document)
		// dismiss things.
		.on('click', '.ivd__dismiss', (ev) => {
			let
				$dismissable = $(ev.currentTarget).closest('.ivd--dismissable')
			;
			if (!$dismissable.length) {
				return;
			}

			$dismissable.remove();
		})


		// overhead: inline togglers.
		.on('click', '.ivd__toggle-inline', (ev) => {
			let
				$inliners = $(ev.currentTarget).closest('.ivd__tree')
					.find('.ivd__scalar')
			;
			if ($inliners.first().is('.ivd--inline')) {
				$inliners.removeClass('ivd--inline');

			} else {
				$inliners.addClass('ivd--inline');
			}
		})


		// overhead: protected property togglers.
		.on('click', '.ivd__toggle-protected-properties', (ev) => {
			let
				$set = $(ev.currentTarget).closest('.ivd__tree')
					.find('.ivd--protected')
			;
			if ($set.first().is('.ivd--hidden')) {
				$set.removeClass('ivd--hidden');

			} else {
				$set.addClass('ivd--hidden');
			}
		})


		// overhead: private property togglers.
		// TODO  broken.
		.on('click', '.ivd__toggle-private-properties', (ev) => {
			let
				$set = $(ev.currentTarget).closest('.ivd__tree')
					.find('.ivd--private')
			;
			if ($set.first().is('.ivd--hidden')) {
				$set.removeClass('ivd--hidden');

			} else {
				$set.addClass('ivd--hidden');
			}
		})


		// overhead: batch-collaps0rs (but exclude root-lvl-content).
		.on('click', '.ivd__batch-collapse', (ev) => {

			$(ev.currentTarget).closest('.ivd__tree')
				.find('.ivd__item .ivd__content').addClass('ivd--collapsed')
			;
		})


		// overhead: batch-expand0rs (but exclude root-lvl-content).
		.on('click', '.ivd__batch-expand', (ev) => {

			$(ev.currentTarget).closest('.ivd__tree')
				.find('.ivd__item .ivd__content').removeClass('ivd--collapsed')
			;
		})


		// depth controllers.
		.on('click', '.ivd__controller', (ev) => {
			let
				$content = $(ev.currentTarget).nextAll('.ivd__content:first')
			;
			if ($content.is('.ivd--collapsed')) {
				$content.removeClass('ivd--collapsed');

			} else {
				$content.addClass('ivd--collapsed');
			}
		})


		// show path of potentially deep elements.
		.on('click', '.ivd__key-core', (ev) => {
			let
				$self = $(ev.currentTarget).closest('.ivd__key'),
				$prepend_here = $self.parent('.ivd__item'),
				parents = $self.parents('.ivd__item').get(),
				path = 'root'
			;
			$self.closest('.ivd__tree').find('.ivd__injected-notice').remove();
			parents.reverse();

			parents.forEach((item) => {
				let
					$key = $('.ivd__key:first', item),
					type = $key.attr('data-type'),
					text = $key.find('.ivd__key-core').text()
				;
				path += type === 'array-key'   ? `['${text}']`   : `->${text}`;
			});


			// inject.
			$prepend_here.prepend(
				`<span class="ivd__injected-notice  ivd--dismissable">
					<span class="ivd__injected-notice-bubble">
						<span class="ivd__injected-notice-text">${path}</span>
						<span class="ivd__dismiss">&times;</span>
					</span>
				</span>`
			);
		})  // end of ( on-click key )


		.ready((ready_ev) => {

			// build overhead controllers.
			$('.ivd__tree').each((index, tree) => {
				let
					$tree = $(tree),
					html = []
				;
				// only add the overhead to items with complexity (depth).
				if ($tree.find('.ivd__key').length) {
					html.push(
						'<ul class="ivd__overhead">',
							'<li class="ivd__toggle-inline">toggle-break inline</li>'
					);
					if ($tree.find('.ivd--protected').length) {
						html.push(
							'<li class="ivd__toggle-protected-properties">toggle-show protected properties</li>'
						);
					}

					if ($tree.find('.ivd--private').length) {
						html.push(
							'<li class="ivd__toggle-private-properties">toggle-show private properties</li>'
						);
					}
					if ($tree.find('.ivd__content .ivd__controller').length) {
						html.push(
							'<li class="ivd__batch-collapse">batch-collapse</li>',
							'<li class="ivd__batch-expand">batch-expand</li>'
						);
					}
					html.push('</ul><!-- /.ivd__overhead -->');

					$tree.prepend(html.join(''));
				}


				// comfort-wrap for CSS.
				$tree.find('.ivd__controller, .ivd__overhead li')
					.wrapInner('<span class="ivd--clickable"></span>')
				;

				if ($tree.is('.ivd--start-collapsed')) {
					$tree.find('.ivd__controller:first').trigger('click');
				}

			});  // end of ( init trees )


		})  //__ end of ( READY )
	;  // end of ( document )

}(jQuery));
