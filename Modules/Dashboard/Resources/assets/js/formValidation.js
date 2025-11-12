$(document).ready(function () {
    // bind parsley to the form
    $('form').parsley();

    // field error
    window.Parsley.on('field:error', function () {
            // This global callback will be called for any field that fails validation.
            this.$element.closest('.tab-pane').addClass('validation_error');
            $('.tab-content .tab-pane.validation_error:eq(0)').addClass('first_tab_with_errors');
            let current_tab_id = $('.tab-content .tab-pane.validation_error.first_tab_with_errors').attr('id');
            $('.nav-tabs a[href="' + '#' + current_tab_id + '"]').tab('show');
            $('.nav-tabs a[href="' + '#' + (this.$element.closest('.tab-pane').attr('id')) + '"]').addClass('validation_errors')
        }
    );
    // field success
    window.Parsley.on('field:success', function () {
        // This global callback will be called for any field that fails validation.
        if (this.$element.closest('.validation_error').children().find('.parsley-error').length) {
        } else {
            $('.nav-tabs a[href="' + '#' + (this.$element.closest('.tab-pane').attr('id')) + '"]').removeClass('validation_errors');
        }
    });
});
