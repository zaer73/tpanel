angular
	.module('inspinia')	
	.factory('roleFactory', ['$rootScope', '$http', function($rootScope, $http, userIdFactory){
		$rootScope.requestForUserRole = function(){
			return $http({
				url: 'api/users/role',
				method: 'post',
				data: {id: $rootScope.user.id}
			});
		}
		var get = function(){
			$rootScope.$watch('user', function(userId){
				if(typeof userId == 'undefined') return;
				return $rootScope.requestForUserRole().then(function(res){
					$rootScope.user.role = res.data;
				});
			});
		}
		return {get: get, request: $rootScope.request};
	}]);