angular
    .module('inspinia')
    .service('polygonMapDrawingService', function($rootScope) {

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

                var polygonMapDrawingService = this;

                jQuery.ajax({
                    url: '/sms/map/polygons',
                    method: 'get',
                    type: 'json',
                    success: function(res) {
                        triangleCoords = res;
                        polygonMapDrawingService.constructMap(res);
                    }
                });

                this.constructDrawings();

            },

            constructMap: function(polygons) {

                var polygonMapDrawingService = this;

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
                    smsPolygons.setMap(polygonMapDrawingService.map);

                    google.maps.event.addListener(smsPolygons, 'click', function(event) {

                        polygonMapDrawingService.selectedShapeIsNew = false;

                        polygonMapDrawingService.selectedPolygon = this.map_state_id;

                        $rootScope.$broadcast('shapeSelected', polygonMapDrawingService);

                    });
                }
            },

            constructDrawings: function() {

                var polygonMapDrawingService = this;

                var drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.MARKER,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: ['polygon']
                    }
                });

                drawingManager.setMap(polygonMapDrawingService.map);

                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
                    var newShape = e.overlay;
                    newShape.type = e.type;
                    google.maps.event.addListener(newShape, 'click', function() {

                        polygonMapDrawingService.selectedShapeIsNew = true;
                        polygonMapDrawingService.selectedPolygon = polygonMapDrawingService.shapeSelected(newShape.getPath().b);

                        $rootScope.$broadcast('shapeSelected', polygonMapDrawingService);

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
            controller: function($rootScope, $scope, $http, polygonMapDrawingService) {

                $rootScope.info = {};

                polygonMapDrawingService.construct();

                $rootScope.$on('shapeSelected', function(event, data){
                    
                    $rootScope.info.selectedPolygon = data.selectedPolygon;
                    $rootScope.info.selectedShapeIsNew = data.selectedShapeIsNew;

                });

            },

        }
    });