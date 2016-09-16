angular
    .module('inspinia')
    .controller('sendMapSMSController', function($rootScope, $scope, $http, $timeout) {

        $scope.sendMessages = function() {
            $http({
                url: 'sms/send/to/map',
                method: 'post',
                data: {
                    polygon: $rootScope.info.selectedPolygon,
                    amount: $rootScope.info.amount,
                    text: $rootScope.info.text,
                    sendOn: $rootScope.info.sendOn,
                    line: $rootScope.info.line
                }
            }).then(function(res) {
                // alert(res.data.message);
            });
        }
    });