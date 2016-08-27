function initMap(rootScope) {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {
            lat: 35.758632352057 ,
            lng: 51.253672598395
        },
    });

    var triangleCoords = [];

    jQuery.ajax({
      url: '/sms/map/polygons',
      method: 'get',
      type: 'json',
      success: function(res){
        triangleCoords = res;
        constructMap(res);
      }
    });

    function constructMap(polygons) {

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
        smsPolygons.setMap(map);

        google.maps.event.addListener(smsPolygons, 'click', function (event) {

          rootScope.selectedShapeIsNew = false;

          rootScope.selectedPolygon = this.map_state_id;

        }); 
      }
    }

    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.MARKER,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['polygon']
        }
    });
    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
        var newShape = e.overlay;
        newShape.type = e.type;
        google.maps.event.addListener(newShape, 'click', function() {

            rootScope.selectedShapeIsNew = true;
            rootScope.selectedPolygon = shapeSelected(newShape.getPath().b);
            
        });
    });

    return rootScope;
}

function shapeSelected(shape) {
  var polygon = [];
  for (index in shape) {
    polygon.push({
      lat: shape[index].lat(),
      lng: shape[index].lng()
    });
  }

  return polygon;
}