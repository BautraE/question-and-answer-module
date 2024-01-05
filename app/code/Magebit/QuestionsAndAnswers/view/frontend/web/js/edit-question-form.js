require([
    "jquery",
    "Magento_Ui/js/modal/modal"
],function($, modal) {
    'use strict';

    var maxLength = 200;

    var options = {
        type: 'popup',
        responsive: true,
        title: 'Edit Question Text',
        buttons: [{
            text: $.mage.__('Cancel'),
            click: function () {
                this.closeModal();
            }
        },
        {
            text: $.mage.__('Save Changes'),
            class: 'save-changes',
            click: function () {
                $('#edit-question-by-owner').submit();
                this.closeModal();
            }
        }]
    };
    modal(options, $('#modal'));
    var saveChangesButton = $('.save-changes');

    $(".edit-question").click(function() {
        var questionText = $(this).data('question');
        var questionId = $(this).data('question-id');
        $('#modal textarea[name="question"]').val(questionText);
        $('#modal input[name="question_id"]').val(questionId);
        $('#modal textarea[name="question"]').trigger('input');
        $('#modal').modal('openModal');
    });

    $('#modal textarea[name="question"]').on('input', function () {
        var remainingChars = maxLength - $(this).val().length;
        $('#char-count').text('Characters remaining: ' + remainingChars);
        saveChangesButton.prop('disabled', remainingChars < 0 || remainingChars === maxLength);

        if (remainingChars === maxLength) {
            $('#length-error-message').text('The question text cannot be empty!');
            $('#question-input').addClass('edit-form-input-error');
            $('#char-count').addClass('edit-form-char-count-error');
        } else if (remainingChars < 0) {
            $('#length-error-message').text('The question text exceeds the maximum length!');
            $('#question-input').addClass('edit-form-input-error');
            $('#char-count').addClass('edit-form-char-count-error');
        } else {
            $('#length-error-message').text('');
            $('#question-input').removeClass('edit-form-input-error');
            $('#char-count').removeClass('edit-form-char-count-error');
        }
    });
});
