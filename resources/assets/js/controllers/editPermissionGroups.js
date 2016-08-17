angular
	.module('inspinia')
	.controller('editPermissionGroupsController', function($rootScope, $scope, $http, $stateParams){
		$scope.id = $stateParams.group_id
		$scope.editPermissionGroupURL = 'permissions/groups/' + $scope.id;
		$http({
			method: 'get',
			url: 'permissions/groups/' + $scope.id + '/edit',
			data: []
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			method: 'post',
			url: 'api/permissions/groups',
			data: []
		}).then(function(res){
			$scope.permissions = res.data;
		});
	});