angular
    .module('inspinia')
    .directive('socket', function(){
    	return {
    		controller: ['$rootScope', '$scope', 'SweetAlert', '$filter', function($rootScope, $scope, SweetAlert, $filter){
    			var socket = io('158.58.185.50:8890');
    			$rootScope.$watch('user', function(user){
    				if(typeof user.id == 'undefined') return;

    				socket.on('received_'+user.id, function(data){
						SweetAlert.swal({
						    title: $filter('translate')('NEW_MESSAGE'),
						    text: data.message,
						});
					});

    			}, true);
    		}],
    	}
    });