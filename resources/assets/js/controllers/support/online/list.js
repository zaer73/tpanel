angular
	.module('inspinia')
	.controller('onlineSupportHomeController', ['$rootScope', '$scope', '$state', '$http', function($rootScope, $scope, $state, $http){
		$rootScope.$watch('user', function(val){
			if(typeof val == 'undefined') return;
			if($rootScope.user.role == 'user') {
				$state.go('app.support.online.chat', {id: $rootScope.user.agent_id});
			}
		});

		$http({
			url: 'support/chat/chats',
			method: 'get'
		}).then(function(res){
			$scope.chats = res.data;
		})
	}]);	