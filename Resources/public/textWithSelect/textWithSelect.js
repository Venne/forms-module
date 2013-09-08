(function ($) {
	$.fn.textWithSelect = function () {

		$(this).find('.dropdown-menu li a').on('click', function(){
			$(this).parent().parent().parent().find("span.textWithSelect-text").text($(this).text());
			$(this).parent().parent().parent().parent().find("input").val($(this).text());
		});


		$(this).parent().find("input").on('change', function () {
			var text = $(this).val();

			var $span = $(this).parent().parent().parent().find("span.textWithSelect-text");
			$span.text('');

			$(this).parent().find('.dropdown-menu li a').each(function(){
				if ($(this).text() == text) {
					$span.text(text);
				}
			});
		});
	};
})(jQuery);
