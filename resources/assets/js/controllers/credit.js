angular
	.module('inspinia')	
	.controller('creditController', ['$scope', '$rootScope', '$stateParams', '$http', function($scope, $rootScope, $stateParams, $http){
		$scope.changeCreditURL = "users/credit/" + $stateParams.id;
		$scope.creditURL = "api/users/credit/" + $stateParams.id;

		$http({
			url: $scope.creditURL,
			method: 'post'
		}).then(function(res){
			$rootScope.info = res.data;
		})
	}]);