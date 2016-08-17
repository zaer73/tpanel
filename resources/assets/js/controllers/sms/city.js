angular
	.module('inspinia')
	.controller('sendCitySMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		$scope.province = $scope.city = null;
		
		$scope.messageCharacters = 0;
		// $scope.maxSendingCount = 0;

		$scope.sendCitySMSURL = 'sms/send/to/city';

		$scope.provinces = [];

		$scope.cityChanged = function(city){
			$scope.city = city;
		}

		$scope.provinceChanged = function(province){
			$scope.province = province.id;
		}

		$scope.cityChanged = function(city){
			$http({
				url: 'numbers-bank/count/'+city,
				method: 'get'
			}).then(function(res){
				$scope.sendingCountRelative = res.data.ranges;
				$scope.maxSendingCount = res.data.max;
			});
		}

		$http({
			url: 'numbers-bank/cities',
			method: 'post'
		}).then(function(res){
			$scope.provinces = res.data;
		});

		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

		if($stateParams.id){
			$http({
				url: 'sms/input/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
				$scope.calculateCharacters($rootScope.info.text);
				$scope.provinceChanged($rootScope.info.province);
				$scope.cityChanged($rootScope.info.city);
			});
		}

	});