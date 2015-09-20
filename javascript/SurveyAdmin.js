/**
 * File: SurveyAdmin.js
 */

(function($) {
	$.entwine('ss', function($){

		$('select[name=Type]').entwine({
			onchange: function(e) {
				if($(e.target).val()) {
					var questionType = $(e.target).val();
					$('.specific-fields').hide();
					$('.specific-fields.' + questionType).show();
				} else {
					$('.specific-fields').hide();
				}
			}
		});

		$('.json-generation').entwine({
			onclick: function(e) {
				var fileName = $(e.target).parents('button').attr('data-survey-filename'),
					surveyID = $(e.target).parents('button').attr('data-survey-id');

				$.ajax({
					type: "POST",
					url: 'generate-json-file',
					data: {'filename' : fileName, 'surveyID' : surveyID},
					success: function() {
						$(".cms-container").refresh();
						return 'ok';
					}
				});
				return false;
			}
		});
	});
})(jQuery);