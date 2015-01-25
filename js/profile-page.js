$(document).ready(function() {

    var wholeExtend = new L.LatLngBounds(); //extend of the map

    //
    function notify() {
        var content = 'You have not yet submitted any location, please submit the ';
        content += 'location using our mobile app from ';
        content += ' Google Play Store. ';
        content += 'In the meantime you can try searching and adding people you know, who are on tracker.';
        alert(content);
    }
    //

    //
    function first_map() {
        map.setView([27.6972, 85.3380], 8);
        notify();
    }
    //

    //
    function setMapExtent(receivedLocationArray) {
            for (var i = 0; i < receivedLocationArray.length; i++) {
                wholeExtend.extend(receivedLocationArray[i]);
            }
            map.fitBounds(wholeExtend);
        }
        //

    function displayCheckInMaps(locationArray, durationArray, myIcon) {

        for (var i = 0; i < locationArray.length; i++) {
            var marker = L.marker(locationArray[i], {
                icon: myIcon
            });
            popupContent = durationArray[i];
            marker.bindPopup(popupContent);
            marker.on('mouseover', function (e) {
            	this.openPopup();
            });
            marker.on('mouseout', function (e) {
            	this.closePopup();
            });
            markerCluster.addLayer(marker);
            //markerLayerGroup.addLayer(marker);
        }
        markerCluster.addTo(map);
    }

    function check_in_from_database() {
        //$body.addClass("loading");
        $("#loading-indicator").show();
        $.ajax({
            url: 'php/profile-page.php',
            type: 'post',
            datatype: 'json',

            success: function(output) {
                $("#loading-indicator").hide();
                jsonParsed = JSON.parse(output); //converts JSON string to object 

                for (something in jsonParsed) {
                    checking = jsonParsed[something];
                    //console.log(checking);
                    for (info in checking) {
                        if (checking[info][0] === 0 && checking[info][1] === 0) {
                            first_map();
                            var infoProfile = new extractForProfile(jsonParsed);
                            var profilePicture = infoProfile.getProfilePicture();
                            var checkIns = infoProfile.getCheckIns();
                            var tracks = infoProfile.getTracks();
                            var following = infoProfile.getFollowing();
                            var followers = infoProfile.getFollowers();
                            displayProfile(checkIns, tracks, following, followers, profilePicture);
                            return;

                        }

                    }
                }

                var infoProfile = new extractForProfile(jsonParsed);
                var profilePicture = infoProfile.getProfilePicture();
                var checkIns = infoProfile.getCheckIns();
                var tracks = infoProfile.getTracks();
                var following = infoProfile.getFollowing();
                var followers = infoProfile.getFollowers();
                displayProfile(checkIns, tracks, following, followers, profilePicture);

                var locationArray = extractLocation(jsonParsed);
                setMapExtent(locationArray);
                var duration = new extractDuration(jsonParsed);
                var durationArray = duration.getDuration();
                var myIcon = getIcon();
                displayCheckInMaps(locationArray, durationArray, myIcon);
            }
        });

    }

    var cartography = new Map();
    var map = cartography.getMap();
    var markerCluster = setMarkerCluster();
    check_in_from_database();
    getNotifications();

});