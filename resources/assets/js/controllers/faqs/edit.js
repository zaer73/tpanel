angular
	.module('inspinia')
	.controller('editFAQSController', function($rootScope, $scope, $http, $stateParams){

		$scope.id = $stateParams.id;
		
		$scope.editFAQSURL = 'faqs/'+$scope.id;

		$http({
			url: 'faqs/'+$scope.id+'/edit',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
		});

	});	