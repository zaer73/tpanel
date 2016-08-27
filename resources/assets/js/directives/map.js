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