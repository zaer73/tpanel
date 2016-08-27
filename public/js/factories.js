angular
	.module('inspinia')	
	.factory('charactersFactory', function(){
		return {
			calculate : function(number, text){
				if(!text || !text.length) return 0;
				var length = text.length;
				if(number.match(/^50001/)){
					if(text.match(/^[ا-ی]/)){
						return this.gamaPersian(length);
					}
					return this.gamaLatin(length);
				} else {
					if(text.match(/^[ا-ی]/)){
						return this.otherPersian(length);
					}
					return this.otherLatin(length);
				}
			},

			gamaPersian : function(length){
				if(length <= 70) return 1;
				if(length <= 132) return 2;
				if(length <= 198) return 3;
				if(length <= 264) return 4;
				if(length <= 330) return 5;
				if(length <= 396) return 6;
				if(length <= 462) return 7;
				if(length <= 528) return 8;
				if(length <= 594) return 9;
				if(length <= 660) return 10;
				return false;
			},

			gamaLatin : function(length){
				if(length <= 140) return 1;
				if(length <= 264) return 2;
				if(length <= 396) return 3;
				if(length <= 528) return 4;
				if(length <= 660) return 5;
				if(length <= 792) return 6;
				if(length <= 924) return 7;
				if(length <= 1056) return 8;
				if(length <= 1188) return 9;
				if(length <= 1320) return 10;
				return false;
			},

			otherPersian : function(length){
				if(length <= 70) return 1;
				if(length <= 134) return 2;
				if(length <= 201) return 3;
				if(length <= 268) return 4;
				if(length <= 335) return 5;
				if(length <= 402) return 6;
				if(length <= 469) return 7;
				if(length <= 536) return 8;
				if(length <= 603) return 9;
				if(length <= 670) return 10;
				return false;
			},

			otherLatin : function(length){
				if(length <= 160) return 1;
				if(length <= 306) return 2;
				if(length <= 459) return 3;
				if(length <= 612) return 4;
				if(length <= 765) return 5;
				if(length <= 918) return 6;
				if(length <= 1071) return 7;
				if(length <= 1224) return 8;
				if(length <= 1377) return 9;
				if(length <= 1530) return 10;
				return false;
			}
		}
	});
angular
	.module('inspinia')	
	.factory('initialsFactory', ['$http', function($http){
		var makeRequest = function(url, data){
			return $http({
				method: 'post',
				url: url,
				data: data
			});
		}
		var get = function(url, data){
			return this.makeRequest(url, data);
		}
		return {get: get, makeRequest:makeRequest};
	}]);
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
				var socket = io('192.168.33.21:8890');
				socket.on('notification_'+res.data.id, function(data){
					$rootScope.$broadcast('notification', data);
				    // notify({ message: 'Info - This is a Inspinia info notification', classes: 'alert-info', templateUrl: 'views/common/notify.html'});
				});
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
//# sourceMappingURL=factories.js.map
