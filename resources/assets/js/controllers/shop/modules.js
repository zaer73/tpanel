angular
	.module('inspinia')
	.controller('shopModulesController', function($rootScope, $scope, $http, DTOptionsBuilder, notify, $filter){

		$scope.addedModules = [];
		
		$http({
			url: 'shop/modules/list',
			method: 'get'
		}).then(function(res){
			$scope.modules = res.data;
		});

		$scope.buy = function(key, index){
			$scope.addedModules.push(key);
			notify({ message: $filter('translate')('MODULE_ADDED_TO_SHOPPING_INVOICE'), classes: 'alert-info', templateUrl: 'views/common/notify.html'});
			$http({
				url: 'shop/modules/add-to-invoice',
				method: 'post',
				data: {
					module_id: index
				}
			});
		}

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