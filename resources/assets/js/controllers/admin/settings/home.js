angular
	.module('inspinia')
	.controller('adminSettingController', function($rootScope, $scope, $http){

		$scope.adminSettingsURL = 'admin/update';
		$scope.changeGatewaySettingURL = 'users/setting/gateway';

		$http({
			url: 'admin/info',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$rootScope.info.gateway = [];
			$http({
				url: 'users/setting/gateway',
				method: 'get'
			}).then(function(res){
				$rootScope.info.gateway = res.data.gateway;
			});
			console.log($rootScope.info);
		});

		if($rootScope.user.role == 'agent'){
			$http({
				url: 'users/setting/gateway',
				method: 'get'
			}).then(function(res){
				$rootScope.info.gateway = res.data.gateway;
			});
		}

	});