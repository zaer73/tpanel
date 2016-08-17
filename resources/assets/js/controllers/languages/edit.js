angular
	.module('inspinia')
	.controller('editLanguageController', function($rootScope, $scope, $http, $stateParams){

		$scope.key = $stateParams.id;

		$scope.editLanguageURL = 'languages/'+$scope.key;
		
		$http({
			url: 'languages/'+$scope.key+'/edit',
			method: 'get'
		}).then(function(res){
			$scope.items = $rootScope.info = res.data;
			$rootScope.info.titleOfLanguage = $scope.key;
			
		});

	});	