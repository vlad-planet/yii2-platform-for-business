const UserUploadForm = {
    selectors: {
        importFileField: '.js-import-file-field',
        importFileForm: '.js-import-form',
    },
    events: function () {
        $(document).on('change', UserUploadForm.selectors.importFileField, function () {
            $(UserUploadForm.selectors.importFileForm).submit();
        });
    },
    init: function () {
        this.events();
    }
};

$(function () {
    UserUploadForm.init();
});