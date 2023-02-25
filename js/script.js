;(function( $ ) {

// TODO  phpdoc to Node and Tree methods, and classes themselves.


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


	// overhead: batch-collaps0rs.
	.on('click', '.ivd__batch-collapse', (ev) => {

		$(ev.currentTarget).closest('.ivd__tree')
			// exclude root-lvl-content.
			.find('.ivd__item .ivd__content').addClass('ivd--collapsed')
		;
	})


	// overhead: batch-expand0rs.
	.on('click', '.ivd__batch-expand', (ev) => {

		$(ev.currentTarget).closest('.ivd__tree')
			// include root-lvl-content.
			.find('.ivd__content.ivd--collapsed').removeClass('ivd--collapsed')
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
	.on('click', '.ivd__key', (ev) => {
		let
			$self = $(ev.currentTarget),
			$prepend_here = $self.parent('.ivd__item'),
			parents = $self.parents('.ivd__item').get(),
			path = 'root'
		;
		// reset.
		$self.closest('.ivd__tree').find('.ivd__injected-notice').remove();

		// we went up but we are writing LTR.
		parents.reverse();

		// traverse, process.
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


	// test: start z-indexer.
	.on('click', '.ivd__z-indexer-start', (ev) => {
		let
			$body = $('body'),
			$z_indexer = $('#ivd__z-indexer'),
			$tree = $(ev.currentTarget).closest('.ivd__tree')
		;
		if (!$z_indexer.length) {
			$body.append(
				`<div id="ivd__z-indexer" class="ivd--dismissable">
					<span class="ivd__dismiss">&times;</span>
					<span class="ivd__label">Mousewheel</span>
					<input type="text" name="ivd__z_indexer" class="ivd__form-control" />
				</div>`
			);
			$z_indexer = $('#ivd__z-indexer');
		}


		$z_indexer.find('[name="ivd__z_indexer"]').val(
			$tree.css('z-index')
		);

		// TODO  +temp-id.

	})  // end of ( on-click z-indexer-start )


	// // test: operate z-indexer.
	// .on('wheel', '#ivd__z-indexer-start', (ev) => {
	// 	console.log('delta oer someth', ev);

	// 	let
	// 		$z_indexer = $('#ivd__z-indexer'),
	// 		$tree = $('.ivd__tree').eq(2)
	// 	;
	// 	if (!$z_indexer.length || !$tree.length) {
	// 		return;
	// 	}

	// 	let
	// 		z_index = $z_indexer.find('[name="ivd__z_indexer"]').val()
	// 	;

	// 	$z_indexer.find('[name="ivd__z_indexer"]').val(
	// 		$tree.css('z-index', z_index)
	// 	);

	// })  // end of ( on-click z-indexer-start )


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
					'<div class="ivd__overhead">',
						'<span class="ivd__overhead-item  ivd__toggle-inline">toggle-break inline</span>',
						'<span class="ivd__overhead-item  ivd__z-indexer-start">z-index-test</span>'
				);
				if ($tree.find('.ivd--protected').length) {
					html.push(
						'<span class="ivd__overhead-item  ivd__toggle-protected-properties">toggle-show protected properties</span>'
					);
				}

				if ($tree.find('.ivd--private').length) {
					html.push(
						'<span class="ivd__overhead-item  ivd__toggle-private-properties">toggle-show private properties</span>'
					);
				}
				if ($tree.find('.ivd__content .ivd__controller').length) {
					html.push(
						'<span class="ivd__overhead-item  ivd__batch-collapse">batch-collapse</span>',
						'<span class="ivd__overhead-item  ivd__batch-expand">batch-expand</span>'
					);
				}
				html.push('</div><!-- /.ivd__overhead -->');

				$tree.prepend(html.join(''));
			}


			// comfort-wrap for CSS.
			$tree.find('.ivd__controller, .ivd__overhead-item')
				.wrapInner('<span class="ivd--clickable"></span>')
			;

			if ($tree.is('.ivd--start-collapsed')) {
				$tree.find('.ivd__controller:first').trigger('click');
			}

		});  // end of ( init trees )


	})  //__ end of ( READY )
;  // end of ( document )


window.addEventListener('wheel', (ev) => {
	let
		$z_indexer = $('#ivd__z-indexer'),
		$tree = $('.ivd__tree').eq(2)
	;
	if (
		!$z_indexer.length
	||	!$tree.length
	||	!$(ev.target).closest($z_indexer).length
	) {
		return;
	}


	console.log('delta oer someth', ev);

	let
		z_index = Number($z_indexer.find('[name="ivd__z_indexer"]').val())
	;
	if (Number.isNaN(z_index)) {
		z_index = 0;
	}

	z_index += ev.wheelDelta;
	console.log('z_index', z_index);

	$tree.css('z-index', z_index);

	$z_indexer.find('[name="ivd__z_indexer"]').val(z_index);

	ev.preventDefault();
	ev.stopPropagation();
	return false;

}, { passive: false });

//	// test: operate z-indexer.
//	.on('wheel', '#ivd__z-indexer-start', )  // end of ( on-click z-indexer-start )



}(jQuery));
