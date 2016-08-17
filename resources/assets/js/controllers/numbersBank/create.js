angular
	.module('inspinia')
	.controller('createNumbersBankController', function($rootScope, $scope, $http, $stateParams){
		
  		$scope.createNumbersBankURL = 'numbers-bank/define';

  		if($stateParams.id){
  			$http({
  				url: 'numbers-bank/'+$stateParams.id+'/edit',
  				method: 'get'
  			}).then(function(res){
  				$rootScope.info = res.data;
  			})
  		}

	});	