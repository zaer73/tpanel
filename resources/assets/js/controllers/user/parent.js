angular
	.module('inspinia')
	.controller('changeUserParentController', function($scope, $http, $rootScope, $stateParams){
		
		$scope.changeUserParentURL = 'api/users/change-parent';

		$http({
			url: 'api/users/available-to-parent/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$scope.parents = res.data.users;
			$scope.currentUser = res.data.userInfo;
		});

		$scope.submitForm = function(){
			$rootScope.info.target = $stateParams.id;
		}

	});	