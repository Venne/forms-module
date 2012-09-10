(function ($) {
	$.fn.textWithSelect = function () {
		$(this).each(function () {
			$(this).change(function () {
				var text = $(this).find("option:selected").val();
				$(this).parent().find("input").val(text);
			});
			$(this).parent().find("input").change(function () {
				var text = $(this).val();
				$(this).parent().find("option[value='']").attr('selected', 'selected');
				$(this).parent().find("option").each(function () {
					if (text == $(this).text()) {
						$(this).attr('selected', 'selected');
					}
				});
			});
		});
	};
})(jQuery);
