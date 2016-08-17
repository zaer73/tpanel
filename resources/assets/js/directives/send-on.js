angular
    .module('inspinia')
    .directive('sendOn', function(){
    	return {
    		templateUrl: 'views/common/scheduled_sms.html',
    		link: function($scope, element, attrs){
    			$scope.showScheculedSMS = false;

    			$scope.monthes = ['farvardin', 'ordibehesht', 'khordad', 'tir', 'mordad', 'shahrivar', 'mehr', 'aban', 'azar', 'dey', 'bahman', 'esfand'];

    			$scope.$root.$on('datetimeChanged', function(event, message){
    				$scope.$root.sendOnRootScope = message;
    			});
    		}
    	}
    });