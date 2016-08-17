angular
	.module('inspinia')
	.controller('createContactController', function($rootScope, $scope, $http, $modal, SweetAlert, $filter){
		
		$scope.createContactURL = 'contacts/contact';
		$scope.contacts = [{name: '', number: ''}];

		$http({
			url: 'contacts/groups',
			method: 'get'
		}).then(function(res){
			$scope.groups = res.data;
		});

		$scope.importContacts = function($event){
			$event.preventDefault();
			$modal.open({
                templateUrl: 'views/contacts/import_contacts.html',
            });
		}

		$rootScope.$on('fileUploaded', function(){
			SweetAlert.swal({
	            title: $filter('translate')('CONTACTS_IMPORTED'),
	        });
	        location.reload();
		});

		$scope.addNewContactRow = function($event){
			$event.preventDefault();
			$scope.contacts.push({name: '', number: ''});
		}

		$scope.removeContactRow = function($event, key){
			$event.preventDefault();
			$scope.contacts.splice(key, 1);
		}

	});	