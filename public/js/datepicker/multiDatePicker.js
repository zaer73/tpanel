angular
    .module('inspinia').directive('multiDatepicker', function() {
    return {
        restrict: 'EA',
        replace: true,
        templateUrl: '/src/tpl/persianDatepicker/datepicker.html',
        scope: {
            datepickerMode: '=?',
            dateDisabled: '&',
        },
        require: ['multiDatepicker', '?^ngModel'],
        controller: 'ui.bootstrap.persian.datepicker.DatepickerController',
        link: function(scope, element, attrs, ctrls) {
            jQuery('body').on('click', '.multi-datepicker button', function(){
                jQuery(this).toggleClass('active');
            })
            var datepickerCtrl = ctrls[0],
                ngModelCtrl = ctrls[1];

            if (ngModelCtrl) {
                datepickerCtrl.init(ngModelCtrl);
            }
        }
    };
})