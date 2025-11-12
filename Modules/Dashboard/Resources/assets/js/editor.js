$(function () {
    // Summernote
    $('.textarea').summernote({
        height: 150,
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                console.log(files[0], this);
            }
        },
        placeholder: 'Start typing your text...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['ltr', 'rtl']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
});
