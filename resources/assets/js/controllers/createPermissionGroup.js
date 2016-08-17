angular
	.module('inspinia')
	.controller('createPermissionGroupsController', function($rootScope, $scope, $http){
		$scope.createPermissionGroupURL = 'permissions/groups';
		$http({
			method: 'post',
			url: 'api/permissions/groups',
			data: []
		}).then(function(res){
			$scope.permissions = res.data;
		});
	});