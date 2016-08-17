angular
	.module('inspinia')
	.controller('editContactController', function($rootScope, $scope, $http, $stateParams){
		
		$scope.id = $stateParams.id;

		$scope.editContactURL = 'contacts/contact/'+$scope.id;

		$http({
			url: 'contacts/contact/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	