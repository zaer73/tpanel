angular
	.module('inspinia')
	.controller('onlineSupportController', function($rootScope, $scope, $http, $stateParams){

		$scope.messages = [];

		$http({
			url: 'support/chat/with/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$scope.messages = res.data;
		});

		$rootScope.$on('notification', function(event, data){
			$scope.$apply(function(){
				$scope.messages.push(data.message);
			});
		});

		$scope.sendMessage = function(){
			$scope.messages.push($scope.message);
			$http({
				url: 'support/chat/new-message',
				method: 'post', 
				data: {
					message: $scope.message,
					receiver: $stateParams.id
				}
			});

			$scope.message = '';

		}
	});	