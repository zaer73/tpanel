angular
	.module('inspinia')	
	.factory('initialsFactory', ['$http', function($http){
		var makeRequest = function(url, data){
			return $http({
				method: 'post',
				url: url,
				data: data
			});
		}
		var get = function(url, data){
			return this.makeRequest(url, data);
		}
		return {get: get, makeRequest:makeRequest};
	}]);