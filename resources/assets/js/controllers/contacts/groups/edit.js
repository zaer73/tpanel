angular
	.module('inspinia')
	.controller('editContactGroupController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editContactGroupURL = 'contacts/groups/'+$scope.id;

		$http({
			url: 'contacts/groups/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	