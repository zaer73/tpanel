angular
	.module('inspinia')
	.controller('editAutoreplyController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editAutoreplyURL = 'autoreplies/'+$scope.id;

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'autoreplies/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	