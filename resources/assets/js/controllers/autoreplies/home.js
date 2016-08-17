angular
	.module('inspinia')
	.controller('autorepliesController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$scope.selectedRows = [];
		
		$http({
			url: 'autoreplies',
			method: 'get'
		}).then(function(res){
			$scope.autoreplies = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				url: 'autoreplies/'+index,
				method: 'delete'
			});
			$scope.autoreplies[key].status = -1;
		};

		$scope.activate = function(key, index){
			$http({
				url: 'autoreplies/enable/'+index,
				method: 'put'
			});
			$scope.autoreplies[key].status = 0;
		};

		$scope.trash = function(key, index){
			$http({
				url: 'autoreplies/trash/'+index,
				method: 'delete'
			});
			$scope.autoreplies.splice(key, 1);
		}

		$scope.selectRow = function(key, id){
	    	if($scope.selectedRows.indexOf(key) !== -1){
	    		delete($scope.selectedRows[$scope.selectedRows.indexOf(key)]);
	    		return;
	    	}
	    	$scope.selectedRows[id] = key;
	    }

	    $scope.removeSelected = function(){
	    	for(selected in $scope.selectedRows){
	    		$scope.delete($scope.selectedRows[selected], selected, true);
	    	}
	    	setTimeout(function(){
	    		$scope.selectedRows = [];
		    	$http({
					url: 'autoreplies',
					method: 'get'
				}).then(function(res){
					$scope.autoreplies = res.data;
				});
	    	}, 500);
	    }

		jQuery('body').on('click', '#selectAllRows', function(){
    		jQuery('input[type=checkbox].selectRow').trigger('click');
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
	});	