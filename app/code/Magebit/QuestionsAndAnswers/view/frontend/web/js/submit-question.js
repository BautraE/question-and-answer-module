require([
    "jquery"
], function ($) {
    'use strict';

    var maxLength = 200;
    var saveChangesButton = $('.question-submit-button');

    $('#question-input').on('input', function () {
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