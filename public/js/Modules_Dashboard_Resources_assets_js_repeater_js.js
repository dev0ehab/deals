(self["webpackChunk"] = self["webpackChunk"] || []).push([["Modules_Dashboard_Resources_assets_js_repeater_js"],{

/***/ "./Modules/Dashboard/Resources/assets/js/repeater.js":
/*!***********************************************************!*\
  !*** ./Modules/Dashboard/Resources/assets/js/repeater.js ***!
  \***********************************************************/
/***/ (() => {

$('.repeater').repeater({
  initEmpty: false,
  defaultValues: {
    'text-input': 'phone'
  },
  show: function show() {
    $(this).slideDown();
  },
  hide: function hide(e) {
    var _this = this;

    toast.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this",
      type: "warning",
      showCancelButton: !0,
      confirmButtonColor: "#3b5de7",
      cancelButtonColor: "#f46a6a",
      confirmButtonText: "Confirm"
    }).then(function (result) {
      $(_this).fadeOut(1000, e);
    });
  },
  isFirstItemUndeletable: true
});

/***/ })

}]);
