@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@bsMultilangualFormTabs
    {{ BsForm::text('name')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
@endBsMultilangualFormTabs

<div class="form-group">
    {{ BsForm::number('price')->min('.01')->step('.01')->required() }}
</div>

<div class="form-group">
    <div id="map" style="height: 450px; width: 100%;"></div>
</div>

<input type="hidden" name="waypoints" id="waypoints">


<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqiHxtNgiDP_NQNZAcbiLheQsC5XasMUU&callback=initMap&v=weekly"
    async defer></script>

<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 11,
            center: {
                lat: 29.328586,
                lng: 47.990341
            },
            mapTypeId: "terrain",
        });

        const defData = [{
                lat: 29.314651896456947,
                lng: 48.05429821435547
            },
            {
                lat: 29.320402185334785,
                lng: 48.094123653808595
            },
            {
                lat: 29.26734233454724,
                lng: 48.08911877099609
            }
        ];

        // Define the LatLng coordinates for the polygon's path.
        const triangleCoords = @json($waypoints ?? []).length === 0 ? defData : @json($waypoints ?? []);


        // Construct the polygon.
        const bermudaTriangle = new google.maps.Polygon({
            editable: true,
            draggable: true,
            paths: triangleCoords,
            strokeColor: "#FF0011",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF1111",
            fillOpacity: 0.35,
        });

        bermudaTriangle.setMap(map);

        // Add event listeners for when the polygon is dragged or edited
        google.maps.event.addListener(bermudaTriangle.getPath(), "set_at", logPolygonCoords, {
            passive: true
        });
        google.maps.event.addListener(bermudaTriangle.getPath(), "insert_at", logPolygonCoords, {
            passive: true
        });
        google.maps.event.addListener(bermudaTriangle, "dragend", logPolygonCoords, {
            passive: true
        });

        // Function to log the polygon's updated coordinates
        function logPolygonCoords() {
            const path = bermudaTriangle.getPath();
            const coordinates = [];

            for (let i = 0; i < path.getLength(); i++) {
                const latLng = path.getAt(i);
                coordinates.push({
                    lat: latLng.lat(),
                    lng: latLng.lng()
                });
            }

            $("#waypoints").val(JSON.stringify(coordinates));

            // console.log("Updated polygon coordinates:", coordinates);
        }
    }

    window.initMap = initMap;
</script>
