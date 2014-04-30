$(document).on('ready', function() {
	
	// Transform every single <select> into the select2 plugin
	$('select').select2();

	// Add datepicker
	$('.datepicker').datepicker({ format: "yyyy-mm-dd" });

	// Init dropdowns
	$('.dropdown-toggle').dropdown();

	// Init colorpicker
	$('.color-picker').colorpicker();

	// Set iphone checkboxes
	$('.iphone-checkbox').bootstrapSwitch({
		onText: 'Да',
		offText: 'Нет'
	});

	// Two way data-binding (secondary type)
	window.init2wayBinding = function() {
		$('.2way-binding').each(function(index, el) {
			var $el = $(el),
				bindingClass = '.' + $el.data('binding'),
				$binding = $(bindingClass),
				bindingDefaultValue = $binding.html();

			// Set default value (value to be dropped)
			$binding.data('default', bindingDefaultValue)

			$el.on('keyup', function(e) {
				$binding.html($el.val());
			});
		});
	};

	window.drop2wayBinding = function() {
		$('.2way-binding').each(function(index, el) {
			var $el = $(el);

			var bindingClass = '.' + $el.data('binding'),
				$binding = $(bindingClass);

			$binding.html($binding.data('default'));
		});
	};

	window.init2wayBinding();
});