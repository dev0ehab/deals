/**
 * @name laravelMediaUploaderValidator
 * @description function that validate user input file in the runtime.
 *
 * @param {string} mimeTypes            String that contains allowed mime types like: "image/*,audio/mp3".
 * @param {number} fileMaxSizeInBytes   Maximum file size in bytes.
 * @param {string} mimeTypeErrorMsg     Mime type error message.
 * @param {string} fileSizeErrorMsg     File size error message.
 * @param {string} validFileMsg         Valid file message.
 *
 * @author Mohamed Marzouk | m.marzouk@CodeClouders.com
 */

const { waitForElement } = require("./waitForElement");

document.laravelMediaUploaderValidator = function (mimeTypes, fileMaxSizeInBytes, mimeTypeErrorMsg, fileSizeErrorMsg, validFileMsg) {

    // adding parsley custom attributes
    let fileUploader = document.querySelector(".uploader-hidden");
    fileUploader.setAttribute('id',  'parsley-file-validation');
    fileUploader.setAttribute('data-parsley-filemaxmegabytes', (fileMaxSizeInBytes / (1024 * 1024)).toString());
    fileUploader.setAttribute('data-parsley-trigger', 'change');
    fileUploader.setAttribute('data-parsley-filemimetypes',  mimeTypes);

    let app = {};

    // Utils
    (function ($, app) {
        app.utils = {};

        app.utils.formDataSuppoerted = (function () {
            return ('FormData' in window);
        }());

    }(jQuery, app));

    // Parsley validators
    (function ($, app) {

        let error = document.querySelector('small[class=uploader-text-gray-600]');
        error.style.fontSize    = '13px';
        error.style.fontWeight  = 'bold';

        window.Parsley
            .addValidator('filemaxmegabytes', {
                requirementType: 'string',
                validateString: function (value, requirement, parsleyInstance) {

                    if (!app.utils.formDataSuppoerted) return true;

                    const files = parsleyInstance.$element[0].files;

                    if (files.length === 0) return true;

                    if(files[0].size > fileMaxSizeInBytes){
                        error.style.color       = 'red';
                        error.textContent       = fileSizeErrorMsg
                            .replace(
                                ':size',
                                (files[0].size / (1024 * 1024)).toFixed(2).toString()
                            );
                    }
                    else {
                        error.style.color = 'green';
                        error.textContent = validFileMsg;
                    }
                }
            })
            .addValidator('filemimetypes', {
                requirementType: 'string',
                validateString: function (value, requirement, parsleyInstance) {

                    if (!app.utils.formDataSuppoerted) return true;

                    const files = parsleyInstance.$element[0].files;

                    if (files.length === 0) return true;

                    if ( files[0].type.match( mimeTypes.replaceAll(',', '|')) ){
                        error.style.color = 'red';
                        error.textContent = mimeTypeErrorMsg;
                    }
                    else {
                        error.style.color = 'green';
                        error.textContent = validFileMsg;
                    }
                }
            });

    }(jQuery, app));

    // Parsley Init
    (function ($) {
        $('#parsley-file-validation').parsley();
    }(jQuery, app));


    waitForElement('a[title="Delete"]').then(function () {

        $('a[title="Delete"]').on('click', function () {
            let fileUploader = document.querySelector(".uploader-hidden");
            fileUploader.setAttribute('id',  'parsley-file-validation');
            fileUploader.setAttribute('data-parsley-filemaxmegabytes', (fileMaxSizeInBytes / (1024 * 1024)).toString());
            fileUploader.setAttribute('data-parsley-trigger', 'change');
            fileUploader.setAttribute('data-parsley-filemimetypes',  mimeTypes);

            // Parsley Init
            (function ($) {
                $('#parsley-file-validation').parsley();
            }(jQuery, app));
        });

    });
}
