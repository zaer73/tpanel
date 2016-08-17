angular
	.module('inspinia')
	.controller('checkoutController', function($rootScope, $scope, $http){

		$scope.selectedGate = '';
		$scope.movingInProgress = false;
		$scope.movingURL = 'financial/checkout/moving-to-gateway';
		
		$http({
			url: 'financial/checkout/gateways',
			method: 'get'
		}).then(function(res){
			$scope.gateways = res.data;
		});

		$scope.gatewaySelected = function(gateway){
			$scope.selectedGate = gateway;
			var id = 'gateway-'+gateway;
			jQuery('#'+id).trigger('submit');
		}

		// $scope.goToGateway = function(){
		// 	$scope.movingInProgress = true;
		// 	$http({
		// 		url: 'financial/checkout/moving-to-gateway',
		// 		method: 'post',
		// 		data: {
		// 			gateway: $scope.selectedGate,
		// 		}
		// 	}).then(function(res){
		// 		window.location.href = res.data.url;
		// 	});
		// }

	});	