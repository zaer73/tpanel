angular
	.module('inspinia')
	.controller('editPreTextGroupController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.group_id;

		$scope.editPreTextGroupURL = 'pre-texts/group/'+$scope.id;

		$http({
			url: 'pre-texts/group/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	