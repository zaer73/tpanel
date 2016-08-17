angular
	.module('inspinia')
	.controller('priceGroupHomeController', function($rootScope, $scope, $filter, $http, DTOptionsBuilder, SweetAlert){
		
		$http({
			url: 'price-group',
			'method': 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$scope.dtOptions = DTOptionsBuilder.newOptions()
	        .withDOM('<"html5buttons"B>lTfgitp')
	        .withButtons([
	            {extend: 'copy'},
	            {extend: 'csv'},
	            {extend: 'excel', title: 'ExampleFile'},
	            

	            {extend: 'print',
	                customize: function (win){
	                    $(win.document.body).addClass('white-bg');
	                    $(win.document.body).css('font-size', '10px');

	                    $(win.document.body).find('table')
	                        .addClass('compact')
	                        .css('font-size', 'inherit');
	                }
	            }
	        ]);

	    $scope.delete = function(key, group){
	    	SweetAlert.swal({
				title: $filter('translate')("ARE_YOU_SURE?"),
				type: "warning",
    			showCancelButton: true,
    			closeOnConfirm: true,
    			closeOnCancel: true,
    			confirmButtonText: $filter('translate')('YES_DELETE_IT'),
    			cancelButtonText: $filter('translate')('NO'),
			}, function(isConfirm){
				if(isConfirm){
			    	$http({
			    		method: 'delete', 
			    		url: 'price-group/'+group
			    	}).then(function(){
			    		$scope.groups.splice(key,1);
			    	});
			    }
			});
	    }

	});	