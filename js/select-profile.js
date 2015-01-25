$(document).ready(function() {

    $("#addAsFriend").click(function(e){
        $.ajax({
            url:'./php/sendFriendRequest.php',
            type: 'post',
            success:function (output){
                location.reload(true);
            }
        });
    });
        
    $("#unfriend").click(function(e){
        $.ajax({
            url:'./php/unfriend.php',
            type: 'post',
            success:function (output){
                location.reload(true);
            }
        });
    });

    var wholeExtend = new L.LatLngBounds(); //extend of the map
    //
    function first_map() {
        map.setView([27.6972, 85.3380], 8);
    }
        //

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
    //

    //
    function setMapExtent(receivedLocationArray) {
            for (var i = 0; i < receivedLocationArray.length; i++) {
                wholeExtend.extend(receivedLocationArray[i]);
            }
            map.fitBounds(wholeExtend);
        }
        //

    function check_in_from_database() {
        $("#loading-indicator").show();
        $.ajax({
            url: './php/select-profile.php',
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
                            var viewable = profileFriendCheck(jsonParsed);
                            displayFriendButton(viewable);
                            displaySelectedProfile(checkIns, tracks, following, followers, profilePicture, viewable);
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
                var viewable = profileFriendCheck(jsonParsed);
                displayFriendButton(viewable);
                displaySelectedProfile(checkIns, tracks, following, followers, profilePicture, viewable);

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