(function($) {
	$.fn.explorer = function() {
		return this.each(function() {
			var field = $(this);
			var fieldname = 'explorer';

			if(field.data( fieldname )) {
				return true;
			} else {
				field.data( fieldname, true );
			}
			// Put you code here
			//console.log('Hello from Javascript!');
			//console.log(field.attr('data-url'));

			var browse = field.attr('data-browse');
			//console.log(browse);

			// Ajax call - Ajax is optional
			$.fn.explorerAjax(field, browse);
		});
	};

	// Ajax function - Ajax is optional
	$.fn.explorerAjax = function(field, browse) {
		var url = field.attr('data-url') + '/plugin.explorer';
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				path: browse
			},
			success: function(result) {
				$(field.find('.explorer-result')).html(result);
				$.fn.explorerClick(field);
			}
		});
	};

	// Ajax function - Ajax is optional
	$.fn.explorerAjaxView = function(field, browse) {
		var url = field.attr('data-url') + '/plugin.explorer.view';
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				path: browse
			},
			success: function(result) {
				field.find('.explorer-preview').html(result);
				field.find('.explorer-preview textarea').autosize();
				$.fn.explorerClick(field);
			}
		});
	};

	$.fn.explorerClick = function(field) {
		field.find('.explorer-name, .explorer-icon').on( "click", function() {
			var browse = $(this).parent().attr('data-browse');
			var value = $(this).parent().attr('data-value');

			$.fn.explorerAjax(field, browse);

			field.find('input').val(decodeURIComponent(value));
			field.find('input').attr('data-browse', browse);
			$(field.find('.explorer-preview')).html('');
		});

		field.find('.explorer-breadcrumb-item').on( "click", function() {
			var browse = $(this).attr('data-browse');
			
			$.fn.explorerAjax(field, browse);

			field.find('input').val(decodeURIComponent(browse));
			field.find('input').attr('data-browse', browse);

			$(field.find('.explorer-preview')).html('');
		});

		field.find('.explorer-view').on( "click", function() {
			var value = $(this).parent().attr('data-value');
			console.log(value);

			$.fn.explorerAjaxView(field, value);
		});

		field.find('.explorer-refresh').on( "click", function() {
			console.log('test');
			var browse = field.find('input').attr('data-browse');
			console.log(browse)
			$.fn.explorerAjax(field, browse);
		});
	};
})(jQuery);