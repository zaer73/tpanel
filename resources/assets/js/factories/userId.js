angular
	.module('inspinia')	
	.factory('userIdFactory', function($rootScope, $http, $state){
		$rootScope.user = {};
		var getUserInfo = function(toState){
			return $http({
				method: 'post',
				url: 'api/users/user-info'
			}).then(function(res){
				$rootScope.user.id = res.data.id;
				if(res.data.id == null) {
					window.location.href = 'users/login';
				}
				$rootScope.user = res.data;
				$rootScope.userTotalCredit = res.data.credit;
				
				$rootScope.controlState(toState, $state);
			}, function error(){
				window.location.href = 'users/login';
			});
		};
		$rootScope.check_permission = function(permission){
			if(typeof $rootScope.user.permissions == 'undefined') return;
			return ($rootScope.user.permissions[permission] == 1);
		};
		$rootScope.controlState = function(toState, $state){
            var permission = toState.permission;
            if(typeof permission != 'undefined' && $rootScope.check_permission(permission) == false){
                $state.go('dashboards.dashboard_1');
            }               
		}
		return {getUserInfo: getUserInfo};
	});