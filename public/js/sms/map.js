function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {
            lat: 35.758632352057 ,
            lng: 51.253672598395
        },
        mapTypeId: google.maps.MapTypeId.TERRAIN
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

      var selectedPolygons = [];

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

          if (this.fillColor == '#FF0000') {

            selectedPolygons.push(this.map_state_id);

            this.setOptions({fillColor: 'green'});

          } else {

            selectedPolygons.splice(selectedPolygons.indexOf(this.map_state_id), 1)

            this.setOptions({fillColor: '#FF0000'});

          }

          

          console.log(selectedPolygons);

          // console.log(this.map_state_id)

        }); 
      }
    }

}