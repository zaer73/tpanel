angular
	.module('inspinia')
	.controller('editBlacklistController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editBlacklistURL = 'blacklist/'+$scope.id;

		$http({
			url: 'blacklist/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$scope.createBlacklistURL = 'blacklist';

	});	