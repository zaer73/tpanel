angular
	.module('inspinia')
	.controller('sendMapSMSController', function($rootScope, $scope, $http){

		$scope.provinceName = '';
		$rootScope.info = [];

		jQuery(document).ready(function(){
			$('#IranMap .map .province path').click(function() {
                var province = $(this).attr('class');
                var provinceName = $('#IranMap .list>ul>li>ul>li.' + province + ' a').html();
                if (provinceName) {
                    $('#IranMap .city').html('نمایش شهرهای استان ' + provinceName);
                    $scope.$broadcast('provinceChanged', provinceName);
                }
            });
            $('#IranMap .list li.province>ul>li>a').click(function(e) {
                var provinceName = $(this).html();
                if (provinceName) {
                    $('#IranMap .city').html('نمایش شهرهای استان ' + provinceName);
                    $scope.$broadcast('provinceChanged', provinceName);
                }
                e.preventDefault();
            });
        });

        $scope.$on('provinceChanged', function(event, msg){
        	$scope.$apply(function(){
        		$scope.provinceName = msg;
        	})
        });

        $scope.sendMessages = function(){
        	$http({
        		url: 'sms/send/to/map', 
        		method: 'post',
        		data: {
        			province: $scope.provinceName,
        			text: $rootScope.info.text,
        			sendOn: $rootScope.info.sendOn,
        			line: $rootScope.info.line
        		}
        	}).then(function(res){
        		alert(res.data.message);
        	});
        }
	});	