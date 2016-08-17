angular
	.module('inspinia')
	.controller('lineExtensionController', function($rootScope, $scope, $http, DTOptionsBuilder, SweetAlert, $filter){

		$scope.addedLines = [];
		
		$http({
			url: 'shop/lines/extension/list',
			method: 'get'
		}).then(function(res){
			$scope.lines = res.data;
		});

		$scope.buy = function(key, line){
			$scope.addedLines.push(key);
			SweetAlert.swal({ 
				title: '',
				text: $filter('translate')('LINE_ADDED_TO_SHOPPING_INVOICE')
			});
			$http({
				url: 'shop/lines/add-to-invoice',
				method: 'post',
				data: {
					line_id: line.id
				}
			})
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