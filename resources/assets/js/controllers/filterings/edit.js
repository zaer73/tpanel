angular
	.module('inspinia')
	.controller('editFilteringsController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editFilteringsURL = 'filterings/'+$scope.id;

		$http({
			url: 'filterings/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	