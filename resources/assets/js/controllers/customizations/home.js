angular
	.module('inspinia')
	.controller('customizationController', function($rootScope, $scope, $http){
		
		$rootScope.$watch('user.id', function(res){	
			if(typeof res == 'undefined') return;
			$scope.customizationURL = 'customization/'+$rootScope.user.id;

			$http({
				url: 'customization/' + $rootScope.user.id + '/edit',
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
			});
		});

	});	