angular
    .module('inspinia').directive('persianDaypicker', ['dateFilter', 'PersianDateService', 'persianDateFilter',
    function(dateFilter, PersianDateService, persianDateFilter) {
        return {
            restrict: 'EA',
            replace: true,
            templateUrl: '/src/tpl/persianDatepicker/day.html',
            require: ['?^multiDatepicker', '?^singleDatepicker'],
            link: function(scope, element, attrs, ctrls) {
                if (ctrls[0]) {
                    ctrl = ctrls[0];
                } else {
                    ctrl = ctrls[1];
                }
                scope.showWeeks = ctrl.showWeeks;

                ctrl.step = {
                    months: 1
                };
                ctrl.element = element;

                //var DAYS_IN_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                //function getDaysInMonth( year, month ) {
                //return ((month === 1) && (year % 4 === 0) && ((year % 100 !== 0) || (year % 400 === 0))) ? 29 : DAYS_IN_MONTH[month];
                //}

                function getDates(startDate, n) {
                    var dates = new Array(n),
                        current = new Date(startDate),
                        i = 0;
                    current.setHours(12); // Prevent repeated dates because of timezone bug
                    while (i < n) {
                        dates[i++] = new Date(current);
                        current.setDate(current.getDate() + 1);
                    }
                    return dates;
                }

                ctrl._refreshView = function() {
                    //var year = ctrl.activeDate.getFullYear(),
                    var year = PersianDateService.getFullYear(ctrl.activeDate),


                        //month = ctrl.activeDate.getMonth(),
                        month = PersianDateService.getMonth(ctrl.activeDate),


                        //firstDayOfMonth = new Date(year, month, 1),
                        firstDayOfMonth = PersianDateService.persian_to_gregorian_Date(year, month, 1),

                        difference = ctrl.startingDay - firstDayOfMonth.getDay(),
                        numDisplayedFromPreviousMonth = (difference > 0) ? 7 - difference : -difference,
                        firstDate = new Date(firstDayOfMonth);

                    if (numDisplayedFromPreviousMonth > 0) {
                        firstDate.setDate(firstDate.getDate() - numDisplayedFromPreviousMonth);
                    }

                    // 42 is the number of days on a six-month calendar
                    var days = getDates(firstDate, 42);
                    for (var i = 0; i < 42; i++) {
                        days[i] = angular.extend(ctrl.createDateObject(days[i], ctrl.formatDay), {
                            //secondary
                            //secondary: days[i].getMonth() !== month,
                            secondary: PersianDateService.getMonth(days[i]) !== month,
                            //secondary
                            uid: scope.uniqueId + '-' + i
                        });
                    }

                    scope.labels = new Array(7);
                    for (var j = 0; j < 7; j++) {
                        scope.labels[j] = {
                            // abbr: dateFilter(days[j].date, ctrl.formatDayHeader),
                            //full: dateFilter(days[j].date, 'EEEE')
                            abbr: persianDateFilter(days[j].date, ctrl.formatDayHeader),
                            full: persianDateFilter(days[j].date, 'EEEE')
                        };
                    }

                    //scope.title = dateFilter(ctrl.activeDate, ctrl.formatDayTitle);
                    scope.title = persianDateFilter(ctrl.activeDate, ctrl.formatDayTitle);
                    scope.rows = ctrl.split(days, 7);

                    if (scope.showWeeks) {
                        scope.weekNumbers = [];
                        var weekNumber = getISO8601WeekNumber(scope.rows[0][0].date),
                            numWeeks = scope.rows.length;
                        while (scope.weekNumbers.push((weekNumber <= 53 ? weekNumber++ : weekNumber -= 52)) < numWeeks) {}
                    }
                };

                ctrl.compare = function(date1, date2) {
                    return (new Date(date1.getFullYear(), date1.getMonth(), date1.getDate()) - new Date(date2.getFullYear(), date2.getMonth(), date2.getDate()));
                };

                function getISO8601WeekNumber(date) {
                    var checkDate = new Date(date);
                    checkDate.setDate(checkDate.getDate() + 4 - (checkDate.getDay() || 7)); // Thursday
                    var time = checkDate.getTime();

                    checkDate.setMonth(2); // Compare with 1 farvardin
                    checkDate.setDate(15); // Compare with 1 farvardin

                    if ((time - checkDate) < 0) {
                        return Math.floor(Math.round(((time + (86400000 * 365)) - checkDate) / 86400000) / 7) + 1;
                    }

                    //checkDate.setMonth(0); // Compare with Jan 1
                    //checkDate.setDate(1);
                    return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1;
                }

                ctrl.handleKeyDown = function(key, evt) {
                    var date = ctrl.activeDate.getDate();

                    if (key === 'left') {
                        date = date - 1; // up
                    } else if (key === 'up') {
                        date = date - 7; // down
                    } else if (key === 'right') {
                        date = date + 1; // down
                    } else if (key === 'down') {
                        date = date + 7;
                    } else if (key === 'pageup' || key === 'pagedown') {
                        var month = ctrl.activeDate.getMonth() + (key === 'pageup' ? -1 : 1);
                        ctrl.activeDate.setMonth(month, 1);

                        //date = Math.min(getDaysInMonth(ctrl.activeDate.getFullYear(), ctrl.activeDate.getMonth()), date);
                        date = Math.min(PersianDateService.persianMonthDays(PersianDateService.getFullYear(ctrl.activeDate), PersianDateService.getMonth(ctrl.activeDate)), date);


                    } else if (key === 'home') {
                        date = 1;
                    } else if (key === 'end') {
                        //date = getDaysInMonth(ctrl.activeDate.getFullYear(), ctrl.activeDate.getMonth());
                        date = PersianDateService.persianMonthDays(PersianDateService.getFullYear(ctrl.activeDate), PersianDateService.getMonth(ctrl.activeDate));
                    }
                    ctrl.activeDate.setDate(date);
                };

                // console.log(scope);
               
                ctrl.refreshView();
            }/*,
            controller: function($scope, $rootScope) {
              var init = function() {
                $rootScope.selected = [];
              }
              init();

              $scope.toggleClass = function(uid){
                console.log(uid,$rootScope.selected[uid]);
                $rootScope.selected[uid] = !$rootScope.selected[uid];
                console.log($rootScope.selected[uid]);
              }
            }*/
        };
    }
])