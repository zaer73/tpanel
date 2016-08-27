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