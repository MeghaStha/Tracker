$(document).ready(function() {
    //
    function addLayerControl() {
            var layercontrol = L.control.layers();
            return layercontrol;
    }
    //

    //
    function getLatestTracks() {

            $.ajax({
                url: './php/userLatestTrack.php',
                type: 'post',
                datatype: 'json',

                success: function(output) {

                    jsonParsed = JSON.parse(output); //converts JSON string to object

                    var latlngtrack = [];
                    var time = [];

                    for (something in jsonParsed) {

                        object = jsonParsed[something];

                        for (track_id in object) {
                            track_id_object = object[track_id];

                            for (i = 0; i < track_id_object.length; ++i) {

                                latlngpair = track_id_object[i];
                                latlngpair_leaflet = L.latLng(latlngpair[0], latlngpair[1]);
                                latlngtrack.push(latlngpair_leaflet);
                                time.push(latlngpair[2]);
                            }

                        }
                    }
                    setMapExtent(latlngtrack);
                    var getDisplayTracks = new displayingTracks(latlngtrack, time);
                    var decorator = getDisplayTracks.getDecorator();
                    decorator.addTo(map);
                    var startFlag = getDisplayTracks.getStartFlag();
                    startFlag.addTo(map);
                    var endFlag = getDisplayTracks.getEndFlag();
                    endFlag.addTo(map);

                }
            });
        }
        //

    //
    function getAllTracks() {

            $.ajax({
                url: './php/userAllTracks.php',
                type: 'post',
                datatype: 'json',

                success: function(output) {
                    var latlngtrack = [];
                    var time = [];

                    json_parsed = JSON.parse(output); //converts JSON string to object

                    for (anything in json_parsed) {

                        object = json_parsed[anything];

                        for (track_id in object) {
                            track_id_object = object[track_id];

                            var latlngtrack = [];
                            var time = [];

                            for (i = 1; i < track_id_object.length; ++i) {
                                latlngpair = track_id_object[i];
                                latlngpair_leaflet = L.latLng(latlngpair[0], latlngpair[1]);
                                latlngtrack.push(latlngpair_leaflet);
                                time.push(latlngpair[2]);
                            }

                        }
                        //layerSwitcher(latlngtrack,time); 
                        var getDisplayTracks = new displayingTracks(latlngtrack, time);
                        var decorator = getDisplayTracks.getDecorator();
                        var startFlag = getDisplayTracks.getStartFlag();
                        var endFlag = getDisplayTracks.getEndFlag();
                        var startTime = getDisplayTracks.getStartTime();
                        var featureGroup = L.layerGroup([decorator, first_marker, last_marker]);
                        layercontrol.addOverlay(featureGroup, "Track of " + startTime);
                    }
                }
            });

        }
        //


    var cartography = new Map();
    var map = cartography.getMap();
    var layercontrol = addLayerControl();
    layercontrol.addTo(map);
    getLatestTracks();
    getAllTracks();
    getNotifications();

    //
    map.on('overlayadd', function(layer, name) {

        map.panTo(layer.target.getBounds().getCenter());
        map.fitBounds(layer.target.getBounds());

    });
    //

});