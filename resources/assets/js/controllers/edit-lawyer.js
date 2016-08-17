angular
	.module('inspinia')
	.controller('editLawyerController', function($rootScope, $scope, $http, $stateParams){

		$scope.editLawyerUserURL = 'users/lawyer/'+$stateParams.id;

		$http({
			url: 'users/lawyer/'+$stateParams.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});


	});