angular
    .module('inspinia').directive('singleDatepicker', function() {
    return {
        restrict: 'EA',
        replace: true,
        templateUrl: '/src/tpl/persianDatepicker/datepicker.html',
        scope: {
            datepickerMode: '=?',
            dateDisabled: '&'
        },
        require: ['singleDatepicker', '?^ngModel'],
        controller: 'ui.bootstrap.persian.datepicker.DatepickerController',
        link: function(scope, element, attrs, ctrls) {
            var datepickerCtrl = ctrls[0],
                ngModelCtrl = ctrls[1];

            if (ngModelCtrl) {
                datepickerCtrl.init(ngModelCtrl);
            }
        }
    };
})