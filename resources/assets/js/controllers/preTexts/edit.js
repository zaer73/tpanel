angular
	.module('inspinia')
	.controller('editPreTextController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;
		$scope.editPreTextURL = 'pre-texts/'+$scope.id;

		$http({
			url: 'pre-texts/'+$scope.id+'/edit',
			method: 'get',
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			url: 'pre-texts/api',
			method: 'get',
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	