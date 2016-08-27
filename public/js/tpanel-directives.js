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
angular
    .module('inspinia')
    .service('polygonMapService', function($rootScope) {

        return {

            map: null,

            selectedPolygon: null,

            selectedShapeIsNew: false,

            construct: function() {

                this.map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 11,
                    center: {
                        lat: 35.758632352057,
                        lng: 51.253672598395
                    },
                });

                var triangleCoords = [];

                var polygonMapService = this;

                jQuery.ajax({
                    url: '/sms/map/polygons',
                    method: 'get',
                    type: 'json',
                    success: function(res) {
                        triangleCoords = res;
                        polygonMapService.constructMap(res);
                    }
                });

                this.constructDrawings();

            },

            constructMap: function(polygons) {

                var polygonMapService = this;

                for (var index in polygons) {
                    var smsPolygons = new google.maps.Polygon({
                        map_state_id: polygons[index].id,
                        clickable: true,
                        paths: polygons[index].polygon,
                        strokeColor: '#FF0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#FF0000',
                        fillOpacity: 0.35
                    });
                    smsPolygons.setMap(polygonMapService.map);

                    google.maps.event.addListener(smsPolygons, 'click', function(event) {

                        polygonMapService.selectedShapeIsNew = false;

                        polygonMapService.selectedPolygon = this.map_state_id;

                        $rootScope.$broadcast('shapeSelected', polygonMapService);

                    });
                }
            },

            constructDrawings: function() {

                var polygonMapService = this;

                var drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.MARKER,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: ['polygon']
                    }
                });

                drawingManager.setMap(polygonMapService.map);

                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
                    var newShape = e.overlay;
                    newShape.type = e.type;
                    google.maps.event.addListener(newShape, 'click', function() {

                        polygonMapService.selectedShapeIsNew = true;
                        polygonMapService.selectedPolygon = polygonMapService.shapeSelected(newShape.getPath().b);

                        $rootScope.$broadcast('shapeSelected', polygonMapService);

                    });
                });
            },

            shapeSelected: function(shape) {
                var polygon = [];
                for (index in shape) {
                    polygon.push({
                        lat: shape[index].lat(),
                        lng: shape[index].lng()
                    });
                }

                return polygon;
            }

        }

    })
    .directive('tDrawing', function() {
        return {
            templateUrl: 'views/common/map.html',
            controller: function($rootScope, $scope, $http, polygonMapService) {

                $rootScope.info = {};

                polygonMapService.construct();

                $rootScope.$on('shapeSelected', function(event, data){
                    
                    $rootScope.info.selectedPolygon = data.selectedPolygon;
                    $rootScope.info.selectedShapeIsNew = data.selectedShapeIsNew;

                });

            },

        }
    });
angular
    .module('inspinia')
    .directive('lines', function(){
    	return {
    		templateUrl: 'views/common/lines.html',
    		controller: function($rootScope, $scope, $http, $attrs){
                $rootScope.lineIdNumbers = [];
                $rootScope.linesRahyab = [];
                var url = 'lines/to-send';
                if($attrs.rahyab){
                    url = 'lines/to-send?rahyab=true';
                }
    			$http({
					url: url,
					method: 'get',
				}).then(function(res){
					$rootScope.linesToSend = res.data;
                    if(typeof $rootScope.linesToSend == 'object'){
                        res.data = $rootScope.linesToSend;
                    }
                    for(key in res.data){
                        $rootScope.lineIdNumbers[$rootScope.linesToSend[key].id] = $rootScope.linesToSend[key].number;
                        $rootScope.linesRahyab[$rootScope.linesToSend[key].id] = $rootScope.linesToSend[key].rahyab;
                    }
                    console.log($rootScope.linesToSend.length);
				});
    		}
    	}
    });
angular
    .module('inspinia')

.service('polygonMapService', function($rootScope) {

    return {

        map: null,

        selectedPolygon: [],

        selectedShapeIsNew: false,

        construct: function() {

            this.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: {
                    lat: 35.758632352057,
                    lng: 51.253672598395
                },
            });

            var triangleCoords = [];

            var polygonMapService = this;

            jQuery.ajax({
                url: '/sms/map/polygons',
                method: 'get',
                type: 'json',
                success: function(res) {
                    triangleCoords = res;
                    polygonMapService.constructMap(res);
                }
            });

        },

        constructMap: function(polygons) {

            var polygonMapService = this;

            for (var index in polygons) {
                var smsPolygons = new google.maps.Polygon({
                    map_state_id: polygons[index].id,
                    clickable: true,
                    paths: polygons[index].polygon,
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35
                });
                smsPolygons.setMap(polygonMapService.map);

                google.maps.event.addListener(smsPolygons, 'click', function(event) {

                    if (this.fillColor == '#FF0000') {

                        polygonMapService.selectedPolygon.push(this.map_state_id);

                        this.setOptions({
                            fillColor: 'green'
                        });

                    } else {

                        polygonMapService.selectedPolygon.splice(polygonMapService.selectedPolygon.indexOf(this.map_state_id), 1)

                        this.setOptions({
                            fillColor: '#FF0000'
                        });

                    }

                    $rootScope.$broadcast('shapeSelected', polygonMapService);

                });
            }
        }

    }

})

.directive('tMap', function() {
    return {
        templateUrl: 'views/common/map.html',
        controller: function($rootScope, $scope, $http, polygonMapService, $http) {

            $rootScope.info = {};

            polygonMapService.construct();

            $rootScope.selectedShapesCount = 0;

            $rootScope.$on('shapeSelected', function(event, data) {

                $rootScope.info.selectedPolygon = data.selectedPolygon;
                $rootScope.info.selectedShapeIsNew = data.selectedShapeIsNew;

                $http({

                    url: '/sms/map/count',
                    method: 'post',
                    type: 'json',
                    data: {
                        regions: $rootScope.info.selectedPolygon
                    }
                }).then(function(res)
                {
                    $rootScope.selectedShapesCount = res.data;
                    console.log($rootScope);
                });

            });

        },

    }
});
angular
    .module('inspinia')
    .directive('persianDatePicker', function(){

    	return {
    		// templateUrl: 'views/persian-date-picker.html',

    		restrict: 'AEC',

    		replace: true,

    		link: function($scope, element, attrs){

    			jQuery(element).attr('id', "datepicker-"+$scope.datepickerId);

	    		setTimeout(function(){
	    			jQuery("#datepicker-"+$scope.datepickerId).pDatepicker({
	    				timePicker: {
	    					enabled: true,
	    					showMeridian: false
	    				},
	    			});
	    		}, 100);

    		},
    		controller: function($scope){

    			$scope.datepickerId = Math.floor((Math.random() * 10000) + 10000);

    		},
    		scope: {

    		}
    	}

    });
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
angular
    .module('inspinia')
    .directive('testSms', function(){
    	return {
    		templateUrl: 'views/common/test_sms_template.html',
    		controller: function($rootScope, $scope, $modal, $attrs, charactersFactory){
                var brand = ($attrs.brand == 'true') ? true : false;
                var international = ($attrs.international == 'true') ? true : false;

                // $scope.testMessageCharacters = 0;
                // $scope.testMessagePages = 0;

                // $scope.calculateCharactersTest = function(text){
                //     $scope.testMessageCharacters = (typeof text != 'undefined') ? $rootScope.info.text.length : 0;
                //     $scope.messagePages = charactersFactory.calculate($rootScope.lineIdNumbers[$rootScope.info.line], $rootScope.info.text);
                // }

    			$scope.openTestSMSModal = function(){
                    console.log($scope);
                    if(brand){
                        $modal.open({
                            templateUrl: 'views/common/test_sms_brand.html',
                        });
                    } else{ 
                        if(international){
                            $modal.open({
                                templateUrl: 'views/common/test_sms_international.html',
                            });
                        } else {
                            $modal.open({
                                templateUrl: 'views/common/test_sms.html',
                            });
                        }
                    }
                }

                $rootScope.sendTestMessageURL = 'sms/test';
    		}
    	}
    });
//# sourceMappingURL=tpanel-directives.js.map
