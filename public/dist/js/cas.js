function getReverseGeocodingData(){
	var lat = document.getElementById('lat').value;
	var lng = document.getElementById('lng').value;
  var latlng = new google.maps.LatLng(lat, lng);
  // This is making the Geocode request
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'latLng': latlng }, function (results, status) {
      // This is checking to see if the Geoeode Status is OK before proceeding
      if (status == google.maps.GeocoderStatus.OK) {
        if(results[0]){
            for(var i = 0; i < results[0].address_components.length; i++){
              var component = results[0].address_components[i];
              switch(component.types[0]){
                case 'route':
                  var route = component.long_name;
                  break;
                case 'locality':
                  var city = component.long_name;
                  break;
                case 'administrative_area_level_1':
                  var state = component.long_name;
                  break;
                case 'postal_code':
                  var postcode = component.long_name;
                  break;
              }
            }
            console.log(results[0]);
            document.getElementById('route').value = route;
            document.getElementById('state').value = state;
            document.getElementById('city').value = city;
            document.getElementById('postcode').value = postcode;
          } else
          		window.alert("No results found.")
      } else
      		window.alert('Geocoder failed due to: ' + status);
  });
}