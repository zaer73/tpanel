angular
    .module('inspinia')
    .service('DataTableService', function(DTOptionsBuilder, $rootScope, $compile, $ocLazyLoad) {

        return {

            build: function(url, cols, $scope, className) {

                setTimeout(function () {

                    if (!className) {
                        className = 'DataTable';
                    }

                    $.fn.dataTable.ext.errMode = 'none';

                    $('.'+className).DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": url
                        },
                        select: {
                            style:    'os',
                            selector: 'td:first-child'
                        },
                        columns: cols,
                        buttons: ['copy', 'csv', 'excel'],
                        fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            $compile(nRow)($scope);
                        }
                    });
                }, 20);
            },

            destroy: function()
            {
            	$('.DataTable').dataTable().fnDestroy();
            }

        }

    });