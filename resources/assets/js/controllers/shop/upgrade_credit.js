angular
	.module('inspinia')
	.controller('upgradeCreditController', function($rootScope, $scope, $http, $state, SweetAlert){
		
		$scope.upgradeByCodeURL = 'shop/charge/upgrade/code';
		$scope.fluentCredits = [];

		$http({
			url: 'shop/charge/upgrade/fluent-credits',
			method: 'get'
		}).then(function(res){
			for(ceil in res.data){
				$scope.fluentCredits[ceil] = res.data[ceil];
			}
		});

		$scope.submitChargingBill = function(){
			$http({
				url: 'shop/charge/upgrade/cash',
				method: 'post',
				data: {
					credit: $rootScope.info.credit
				}
			}).then(function(res){
				if(res.data.result == 'success'){
					$state.go('app.shop.checkout');
				} else {
					SweetAlert.swal({ 
						title: '',
						text: res.data.errors,
						type: 'warning'
					});
				}
			}, function(err){
				SweetAlert.swal({ 
					title: '',
					text: err.data.credit[0],
					type: 'warning'
				});
			})
		}

		$scope.calculateSMSFee = function(credit){
			var fee = 0;
			credit = parseInt(credit);
			var length = $scope.fluentCredits.length;
			for(ceil in $scope.fluentCredits){
				if(credit <= ceil) {
					fee = parseInt($scope.fluentCredits[ceil]);
					break;
				} else {
					fee = parseInt($scope.fluentCredits[length-1]);
				}
			}
			$scope.smsFee = fee;
		}

	});	