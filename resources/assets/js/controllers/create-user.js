angular
	.module('inspinia')
	.controller('createUserController', function($rootScope, $scope, $http){

		$scope.createUserURL = 'users';
		$scope.createLawyerUserURL = 'users/lawyer';

		$http({
			url: 'plans',
			method: 'get'
		}).then(function(res){
			$scope.plans = res.data;
		})

	});