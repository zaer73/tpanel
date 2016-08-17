angular
	.module('inspinia')	
	.controller('profileController', ['$scope', '$rootScope', '$http', '$stateParams', function($scope, $rootScope, $http, $stateParams){
		$scope.canChangePassword = true;
		$rootScope.$watch('user', function(user){
			if(user.id){
				$scope.changePasswordURL = "users/profile/" + user.id + "/password";
				$scope.changeBirthdayURL = "users/profile/" + user.id + "/birth";
				$scope.changeInfoURL = 'users/profile';
				if(!$stateParams.id){
					$rootScope.info = user;
				} else {
					$scope.changeBirthdayURL = "users/profile/" + $stateParams.id + "/birth";
					$http({
						url: 'users/'+$stateParams.id,
						method: 'get'
					}).then(function(res){
						$rootScope.info = res.data;
					});
					$scope.canChangePassword = false;
					$scope.changeInfoURL = 'users/profile/'+$stateParams.id;
				}
			}
		}, true);

	}]);