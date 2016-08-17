angular
    .module('inspinia').directive('datepickerPopupPersian', ['$compile', '$parse', '$document', '$position', 'dateFilter', 'dateParser', 'datepickerPopupConfig', 'PersianDateService', 'persianDateFilter', 'EnToFaNumberFilter',
    function($compile, $parse, $document, $position, dateFilter, dateParser, datepickerPopupConfig, PersianDateService, persianDateFilter, EnToFaNumberFilter) {
        return {
            restrict: 'EA',
            require: 'ngModel',
            scope: {
                isOpen: '=?',
                currentText: '@',
                clearText: '@',
                closeText: '@',
                dateDisabled: '&'
            },
            link: function(scope, element, attrs, ngModel) {
                var dateFormat,
                    closeOnDateSelection = angular.isDefined(attrs.closeOnDateSelection) ? scope.$parent.$eval(attrs.closeOnDateSelection) : datepickerPopupConfig.closeOnDateSelection,
                    appendToBody = angular.isDefined(attrs.datepickerAppendToBody) ? scope.$parent.$eval(attrs.datepickerAppendToBody) : datepickerPopupConfig.appendToBody;
                dateFormat = attrs.datepickerPopupPersian || datepickerPopupConfig.datepickerPopupPersian;

                scope.showButtonBar = angular.isDefined(attrs.showButtonBar) ? scope.$parent.$eval(attrs.showButtonBar) : datepickerPopupConfig.showButtonBar;

                scope.getText = function(key) {
                    return scope[key + 'Text'] || datepickerPopupConfig[key + 'Text'];
                };

                attrs.$observe('datepickerPopupPersian', function(value) {
                    dateFormat = value || datepickerPopupConfig.datepickerPopupPersian;
                    ngModel.$render();
                });

                // popup element used to display calendar
                var popupEl = angular.element('<div persian-datepicker-popup-wrap><div persian-datepicker></div></div>');
                popupEl.attr({
                    'ng-model': 'date',
                    'ng-change': 'dateSelection()'
                });

                function cameltoDash(string) {
                    return string.replace(/([A-Z])/g, function($1) {
                        return '-' + $1.toLowerCase();
                    });
                }

                // datepicker element
                var datepickerEl = angular.element(popupEl.children()[0]);
                if (attrs.datepickerOptions) {
                    angular.forEach(scope.$parent.$eval(attrs.datepickerOptions), function(value, option) {
                        datepickerEl.attr(cameltoDash(option), value);
                    });
                }

                scope.watchData = {};
                angular.forEach(['minDate', 'maxDate', 'datepickerMode'], function(key) {
                    if (attrs[key]) {
                        var getAttribute = $parse(attrs[key]);
                        scope.$parent.$watch(getAttribute, function(value) {
                            scope.watchData[key] = value;
                        });
                        datepickerEl.attr(cameltoDash(key), 'watchData.' + key);

                        // Propagate changes from datepicker to outside
                        if (key === 'datepickerMode') {
                            var setAttribute = getAttribute.assign;
                            scope.$watch('watchData.' + key, function(value, oldvalue) {
                                if (value !== oldvalue) {
                                    setAttribute(scope.$parent, value);
                                }
                            });
                        }
                    }
                });
                if (attrs.dateDisabled) {
                    datepickerEl.attr('date-disabled', 'dateDisabled({ date: date, mode: mode })');
                }

                function parseDate(viewValue) {
                    if (!viewValue) {
                        ngModel.$setValidity('date', true);
                        return null;
                    } else if (angular.isDate(viewValue) && !isNaN(viewValue)) {
                        ngModel.$setValidity('date', true);
                        return viewValue;
                    } else if (angular.isString(viewValue)) {
                        var date = dateParser.parse(viewValue, dateFormat) || new Date(viewValue);
                        if (isNaN(date)) {
                            ngModel.$setValidity('date', false);
                            return undefined;
                        } else {
                            ngModel.$setValidity('date', true);
                            return date;
                        }
                    } else {
                        ngModel.$setValidity('date', false);
                        return undefined;
                    }
                }
                ngModel.$parsers.unshift(parseDate);
                ngModel.$formatters.push(function(value) {
                    return ngModel.$isEmpty(value) ? value : persianDateFilter(value, dateFormat);
                });
                // Inner change
                scope.dateSelection = function(dt) {
                    if (angular.isDefined(dt)) {
                        scope.date = dt;
                    }
                    ngModel.$setViewValue(scope.date);
                    ngModel.$render();

                    if (closeOnDateSelection) {
                        scope.isOpen = false;
                        element[0].focus();
                    }
                };

                element.bind('input change keyup', function() {
                    scope.$apply(function() {
                        scope.date = ngModel.$modelValue;
                    });
                });

                // Outter change
                ngModel.$render = function() {

                    //var date = ngModel.$viewValue ? dateFilter(ngModel.$viewValue, dateFormat) : '';
                    var date = ngModel.$viewValue ? EnToFaNumberFilter(persianDateFilter(ngModel.$viewValue, dateFormat)) : '';

                    element.val(date);
                    scope.date = parseDate(ngModel.$modelValue);
                };

                var documentClickBind = function(event) {
                    if (scope.isOpen && event.target !== element[0]) {
                        scope.$apply(function() {
                            scope.isOpen = false;
                        });
                    }
                };

                var keydown = function(evt, noApply) {
                    scope.keydown(evt);
                };
                element.bind('keydown', keydown);

                scope.keydown = function(evt) {
                    if (evt.which === 27) {
                        evt.preventDefault();
                        evt.stopPropagation();
                        scope.close();
                    } else if (evt.which === 40 && !scope.isOpen) {
                        scope.isOpen = true;
                    }
                };

                scope.$watch('isOpen', function(value) {
                    if (value) {
                        scope.$broadcast('datepicker.focus');
                        scope.position = appendToBody ? $position.offset(element) : $position.position(element);
                        scope.position.top = scope.position.top + element.prop('offsetHeight');

                        $document.bind('click', documentClickBind);
                    } else {
                        $document.unbind('click', documentClickBind);
                    }
                });

                scope.select = function(date) {
                    if (date === 'today') {
                        var today = new Date();
                        if (angular.isDate(ngModel.$modelValue)) {
                            date = new Date(ngModel.$modelValue);
                            date.setFullYear(today.getFullYear(), today.getMonth(), today.getDate());
                        } else {
                            date = new Date(today.setHours(0, 0, 0, 0));
                        }
                    }
                    scope.dateSelection(date);
                };

                scope.close = function() {
                    scope.isOpen = false;
                    element[0].focus();
                };

                var $popup = $compile(popupEl)(scope);
                if (appendToBody) {
                    $document.find('body').append($popup);
                } else {
                    element.after($popup);
                }

                scope.$on('$destroy', function() {
                    $popup.remove();
                    element.unbind('keydown', keydown);
                    $document.unbind('click', documentClickBind);
                });
            }
        };
    }
])