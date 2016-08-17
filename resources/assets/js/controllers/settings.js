angular
	.module('inspinia')
	.controller('settingsController', function($rootScope, $scope, $rootScope, $http){
		$rootScope.$watch('user', function(userId){
			$scope.changeSettingsURL = "users/setting/"+$rootScope.user.id;
		});

		$rootScope.info = [];

		$http({
			url: 'api/users/settings',
			method: 'post'
		}).then(function(res){
			$scope.userSettings = res.data;
			for(var key in res.data){
				$rootScope.info[key] = res.data[key];
			}
		});

		$http({
			url: 'api/info',
			method: 'get'
		}).then(function(res){
			$scope.apiKey = res.data;
		});

	});