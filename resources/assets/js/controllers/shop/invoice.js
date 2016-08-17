angular
	.module('inspinia')
	.controller('invoiceController', function($rootScope, $scope, $http){
		
		$http({
			url: 'financial/invoice',
			mehtod: 'get'
		}).then(function(res){
			$scope.invoice = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				url: 'shop/modules/remove-from-invoice/'+index,
				method: 'delete'
			});
			$http({
				url: 'financial/invoice',
				mehtod: 'get'
			}).then(function(res){
				$scope.invoice = res.data;
			});
		}

		$scope.checkout = function(){
			$http({
				url: 'financial/invoice/offline-checkout',
				method: 'post'
			}).then(function(res){
				$scope.shopping_result = res.data;
				if(res.data.result == 'success'){
					$http({
						url: 'financial/invoice',
						mehtod: 'get'
					}).then(function(res){
						$scope.invoice = res.data;
					});
				}
			});
		}

	});	