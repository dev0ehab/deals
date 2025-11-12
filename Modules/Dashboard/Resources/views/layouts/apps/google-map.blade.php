    @isset($item)
        <div class="form-group">
            <label for="start_start">{{ __('Address') }}</label>
            <input type="text" id="start-input" name="address" value="{{ old('address', $item->address) }}"
                class="form-control map-input">
            <input type="hidden" name="lat" id="start-latitude" value="{{ old('lat', $item->lat) }}" />
            <input type="hidden" name="long" id="start-longitude" value="{{ old('long', $item->long) }}" />
        </div>
    @else
        <div class="form-group">
            <label for="start_start">{{ __('Address') }}</label>
            <input type="text" id="start-input" name="address" value="{{ old('address', 'Jeddah, Saudi Arabia') }}"
                class="form-control map-input">
            <input type="hidden" name="lat" id="start-latitude" value="{{ old('lat', '21.492500') }}" />
            <input type="hidden" name="long" id="start-longitude" value="{{ old('long', '39.177570') }}" />
        </div>
    @endisset

    <div class="my-2">
        <div id="map"></div>
        <div id="address-map"></div>
    </div>


@push('css')
      <style>
          #map,
          #bestmap,
          #to_map {
              height: 300px;
              width: 100%;
          }
      </style>
  @endpush


  @push('js')
      <script
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALBkU7wWi4T90Su1avgHWvpKE5K1ytWQM&callback=initMap&libraries=places&v=weekly"
          defer></script>

      <script>
          function initMap() {
              $('form').on('keyup keypress', function(e) {
                  var keyCode = e.keyCode || e.which;
                  if (keyCode === 13) {
                      e.preventDefault();
                      return false;
                  }
              });
              looping()
          }

          function looping() {
              const start_lat = Number(document.getElementById("start-latitude").value);
              const start_lng = Number(document.getElementById("start-longitude").value);
              const map = new google.maps.Map(document.getElementById("map"), {
                  zoom: 17,
                  center: {
                      lat: start_lat,
                      lng: start_lng
                  },
                  position: {
                      lat: start_lat,
                      lng: start_lng
                  },
                  draggable: true
              });
              const marker = new google.maps.Marker({
                  map,
                  position: {
                      lat: start_lat,
                      lng: start_lng
                  },
                  draggable: true
              });
              locationInputs = document.getElementsByClassName("map-input")
              const autocompletes = [];
              const geocoder = new google.maps.Geocoder;
              for (let i = 0; i < locationInputs.length; i++) {
                  const input = locationInputs[i];
                  const fieldKey = input.id.replace("-input", "");
                  const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(
                      fieldKey + "-longitude").value != '';
                  const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
                  const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;
                  const map = new google.maps.Map(document.getElementById('address-map'), {
                      center: {
                          lat: latitude,
                          lng: longitude
                      },
                      zoom: 13,
                      draggable: true
                  });
                  const marker = new google.maps.Marker({
                      map,
                      position: {
                          lat: latitude,
                          lng: longitude
                      },
                  });
                  marker.setVisible(isEdit);
                  const autocomplete = new google.maps.places.Autocomplete(input);
                  autocomplete.key = fieldKey;
                  autocompletes.push({
                      input: input,
                      map: map,
                      marker: marker,
                      autocomplete: autocomplete
                  });
              }
              google.maps.event.addListener(marker, 'dragend', function() {
                  latlng = {
                      location: {
                          lat: marker.position.lat(),
                          lng: marker.position.lng(),
                      }
                  }
                  setLocationCoordinates('start', marker.position.lat(), marker.position.lng());
                  getNameByGeoCode(latlng, "start-input")

              });
              for (let i = 0; i < autocompletes.length; i++) {
                  const input = autocompletes[i].input;
                  const autocomplete = autocompletes[i].autocomplete;
                  const map = autocompletes[i].map;
                  const marker = autocompletes[i].marker;
                  google.maps.event.addListener(autocomplete, 'place_changed', function() {
                      marker.setVisible(false);
                      const place = autocomplete.getPlace();
                      geocoder.geocode({
                          'placeId': place.place_id
                      }, function(results, status) {
                          if (status === google.maps.GeocoderStatus.OK) {
                              const lat = results[0].geometry.location.lat();
                              const lng = results[0].geometry.location.lng();
                              setLocationCoordinates(autocomplete.key, lat, lng);
                          }
                      });
                      if (!place.geometry) {
                          window.alert("No details available for input: '" + place.name + "'");
                          input.value = "";
                          return;
                      }
                      if (place.geometry.viewport) {
                          map.fitBounds(place.geometry.viewport);
                      } else {
                          map.setCenter(place.geometry.location);
                          map.setZoom(17);
                      }
                      marker.setPosition(place.geometry.location);
                      marker.setVisible(true);
                  });
              }
          }

          function setLocationCoordinates(key, lat, lng) {
              console.log(lat);
              const latitudeField = document.getElementById(key + "-" + "latitude");
              const longitudeField = document.getElementById(key + "-" + "longitude");
              latitudeField.value = lat;
              longitudeField.value = lng;
              looping();
          }

          function getNameByGeoCode(latlng, id) {
              const geocoder = new google.maps.Geocoder();
              geocoder
                  .geocode({
                      location: latlng.location ? latlng.location : latlng
                  })
                  .then((response) => {
                      if (response.results[0]) {
                          locationName = locationName = response.results[0].formatted_address.split(",").join(" ");
                          document.getElementById(id).value = removeIntegersFromString(locationName)
                      } else {
                          window.alert("No results found");
                      }
                  })
              // .catch((e) => window.alert("Geocoder failed due to: " + e));
          }

          function removeIntegersFromString(str) {
              return str.replace(/\d+/g, '');
          }

          window.initMap = initMap;
      </script>
  @endpush
