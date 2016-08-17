angular
	.module('inspinia')
	.controller('editSpecialsController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editSpecialsURL = 'specials/'+$scope.id;

		$http({
			url: 'specials/'+$scope.id+'/edit',
			method: 'get',
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	