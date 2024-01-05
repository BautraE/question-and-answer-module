define([
    'jquery',
    'Magento_Ui/js/modal/confirm'
], function ($, confirm) {
    'use strict';

    return function () {

        function handleDeleteAction(questionId, deleteUrl) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    question_id: questionId,
                },
                success: function(response) {
                    location.reload();
                },
            });
        }

        $(document).on('click', '.delete-link', function (event) {
            event.preventDefault();

            var questionId = $(this).data('question-id');
            var deleteUrl = $(this).data('deleteurl');

            confirm({
                title: 'Confirm Deletion',
                content: 'Are you sure you want to delete this question?',
                actions: {
                    confirm: function () {
                        handleDeleteAction(questionId, deleteUrl);
                    },
                    cancel: function () {}
                }
            });
        });
    };
});
