angular
	.module('inspinia')
	.controller('ContactController', function($rootScope, $scope, $http, $modal, DTOptionsBuilder, charactersFactory){

		$rootScope.contactNumber = '';
		$scope.messageCharacters = 0;

		$scope.calculateCharacters = function(text){
			$scope.messageCharacters = (typeof text != 'undefined') ? text.length : 0;
			$scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
		}

		$rootScope.sendSingleSMSURL = 'sms/send/to';
		$rootScope.sendGroupSMSURL =  'sms/send/to/group';
		$scope.selectedRows = [];
		
		$scope.getContacts = function()
		{
			$http({
				url: 'contacts/contact',
				method: 'get'
			}).then(function(res){
				$scope.contacts = res.data;
				$scope.selectedRows = [];
			});
		}

		$scope.getContacts();

		$scope.delete = function(key, index, multi){
			$http({
				'method': 'delete',
				'url': 'contacts/contact/'+index
			});
		}

		$scope.sendMessage = function(key, contact){
			$modal.open({
                templateUrl: 'views/contacts/sendMessage.html',
            });
            $rootScope.contactNumber = contact.number;
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
	    		$scope.delete($scope.selectedRows[selected], selected);
	    	}
	    	$scope.getContacts();
	    }

	    $scope.resendSelected = function(){
	    	var numbers = '';
	    	for(selected in $scope.selectedRows){
	    		numbers += selected + ',';
	    	}
	    	$rootScope.contactsNumbers = numbers;
	    	$scope.selectedRows = [];
	    	$modal.open({
                templateUrl: 'views/contacts/sendMessageGroup.html',
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

        	jQuery('body').on('click', '#selectAllRows', function(){
        		jQuery('input[type=checkbox].selectRow').each(function(){
        			
				jQuery(this).trigger('click');
			});
        	});

	});	