angular
	.module('inspinia')
	.controller('editOccupationsController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editOccupationsURL = 'occupations/'+$scope.id;

		$http({
			url: 'occupations/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	