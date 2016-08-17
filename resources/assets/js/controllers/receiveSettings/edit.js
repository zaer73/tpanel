angular
	.module('inspinia')
	.controller('smsReceiversEditController', function($rootScope, $scope, $http, $stateParams){

		$scope.editReceiveSettingURL = 'receive-sms/'+$stateParams.id;

		$http({
			url: 'receive-sms/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});