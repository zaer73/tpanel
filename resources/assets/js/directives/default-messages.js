angular
    .module('inspinia')
    .directive('defaultMessages', function(){
    	return {
    		templateUrl: 'views/common/default_messages.html',
    		controller: function($rootScope, $scope, $http){
    			$http({
    				url: 'sms/default-messages?type=directive',
    				method: 'get'
    			}).then(function(res){
    				$rootScope.defaultMessages = res.data;
    			});

    			$rootScope.defaultMessageChanged = function(val){
    				$rootScope.info.text = val;
    			}
    		}
    	}
    });