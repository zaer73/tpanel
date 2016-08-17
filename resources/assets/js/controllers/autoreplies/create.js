angular
	.module('inspinia')
	.controller('createAutoreplyController', function($rootScope, $scope, $http){
		
		$scope.createAutoreplyURL = 'autoreplies';

		$http({
			url: 'lines',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	