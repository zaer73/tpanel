angular
	.module('inspinia')
	.controller('sendGenderSMSController', function($rootScope, $scope, $http, $stateParams, charactersFactory){

		$scope.messageCharacters = 0;
		$scope.availableNumbers = 0;
		
		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}
		
		$scope.sendGenderSMSURL = 'sms/send/to/gender';

		if($stateParams.id){
			$http({
				url: 'sms/input/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$rootScope.info = res.data;
				$scope.calculateCharacters($rootScope.info.text);
			});
		}

		$scope.provinces = [];

		$http({
			url: 'api/rahyabbulk/provinces',
			method: 'get'
		}).then(function(res){
			$scope.provinces = res.data;
		});

		$scope.getCities = function(){
			$http({
				url: 'api/rahyabbulk/cities?province='+$rootScope.info.province,
				method: 'get',
			}).then(function(res){
				$scope.cities = res.data;
			});
		}

		$scope.agesFrom = [];
		$scope.agesTo = [];
		for(var i=1320;i<=1380;i++){
			$scope.agesFrom.push(i);
		}

		$scope.ageFromChanged = function(){
			for(var i=$rootScope.info.fromAge;i<=1380;i++){
				$scope.agesTo.push(i);
			}
		}

		$scope.preNumberInvalid = false;
		$scope.checkPreNumber = function(){
			$scope.preNumberInvalid = (!$rootScope.info.preNumber.match(/^91[1-9]{0,2}$/)) ? true : false;
		}

		$scope.calculateMessageCount = function($event){
			$event.preventDefault();
			$http({
				url: 'api/rahyabbulk/count',
				method: 'post',
				data: $rootScope.info
			}).then(function(res){
				$scope.availableNumbers = res.data;
			})
		}

	});	