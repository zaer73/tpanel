angular
    .module('inspinia').directive('persianMonthpicker', ['dateFilter', 'PersianDateService', 'persianDateFilter',
    function(dateFilter, PersianDateService, persianDateFilter) {
        return {
            restrict: 'EA',
            replace: true,
            templateUrl: '/src/tpl/persianDatepicker/month.html',
            require: ['?^multiDatepicker', '?^singleDatepicker'],
            link: function(scope, element, attrs, ctrls) {
                if (ctrls[0]) {
                    ctrl = ctrls[0];
                } else {
                    ctrl = ctrls[1];
                }
                ctrl.step = {
                    years: 1
                };
                ctrl.element = element;

                ctrl._refreshView = function() {
                    var months = new Array(12),
                        //year = ctrl.activeDate.getFullYear();
                        year = PersianDateService.getFullYear(ctrl.activeDate);


                    for (var i = 0; i < 12; i++) {
                        //months[i] = angular.extend(ctrl.createDateObject(new Date(year, i, 1), ctrl.formatMonth), {
                        months[i] = angular.extend(ctrl.createDateObject(PersianDateService.persian_to_gregorian_Date(year, i, 1), ctrl.formatMonth), {
                            uid: scope.uniqueId + '-' + i
                        });
                    }

                    //scope.title = dateFilter(ctrl.activeDate, ctrl.formatMonthTitle);
                    scope.title = persianDateFilter(ctrl.activeDate, ctrl.formatMonthTitle);


                    scope.rows = ctrl.split(months, 3);
                };

                ctrl.compare = function(date1, date2) {
                    return new Date(date1.getFullYear(), date1.getMonth()) - new Date(date2.getFullYear(), date2.getMonth());
                };

                ctrl.handleKeyDown = function(key, evt) {
                    var date = ctrl.activeDate.getMonth();

                    if (key === 'left') {
                        date = date - 1; // up
                    } else if (key === 'up') {
                        date = date - 3; // down
                    } else if (key === 'right') {
                        date = date + 1; // down
                    } else if (key === 'down') {
                        date = date + 3;
                    } else if (key === 'pageup' || key === 'pagedown') {
                        var year = ctrl.activeDate.getFullYear() + (key === 'pageup' ? -1 : 1);
                        ctrl.activeDate.setFullYear(year);
                    } else if (key === 'home') {
                        date = 0;
                    } else if (key === 'end') {
                        date = 11;
                    }
                    ctrl.activeDate.setMonth(date);
                };

                ctrl.refreshView();
            }
        };
    }
])