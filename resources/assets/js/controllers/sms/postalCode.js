angular
	.module('inspinia')
	.controller('sendPostalCodeSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		
		$scope.messageCharacters = 0;

		$scope.sendPostalCodeSMSURL = 'sms/send/to/postal-code';

		$scope.postalCodes = [];

		$scope.province = $scope.city = null;
		$scope.provinces = [];

		$scope.cityChanged = function(city){
			$scope.city = city;
			$http({
				url: 'postal-code?city='+city,
				method: 'get',
			}).then(function(res){
				$scope.postalCodes = res.data
			});
		}

		$scope.provinceChanged = function(province){
			$scope.province = province.id;
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
				$scope.cityChanged($rootScope.info.city);
			});
		}

	});