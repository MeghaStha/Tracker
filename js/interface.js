$(document).ready(function() {

    //
    function abso() {
        $('#top').css({
            position: 'absolute',
            width: $(document).innerWidth(),
            height: $(document).innerHeight() - 100
        });
    }
    //

    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    
    function first_map() {
        map.setView([28.425, 84.435], 7);
        $("#loading-indicator").hide();
    }

    var markerLayerGroup = L.layerGroup();
    markermap = {};
    var latlng = [];
    var countFriend = 0;

    function displayMap(locationArray,imageArray,friendNameArray,durationArray,colorScheme) {

        if(logged.length == 2){
            setMapExtent(locationArray);
        }

        for(var i = 0; i<friendNumber; i++){

            if(colorScheme[i] === 'GREEN'){
                var myIcon = L.icon({
                    iconUrl: imageArray[i],
                    iconSize: [70, 70],
                    iconAnchor: [10, 10],
                    className: 'profile-picture-container-green'
                });
            } else if (colorScheme[i] === 'YELLOW'){
                var myIcon = L.icon({
                    iconUrl: imageArray[i],
                    iconSize: [70, 70],
                    iconAnchor: [10, 10],
                    className: 'profile-picture-container-yellow'
                });
            } else if (colorScheme[i] === 'RED'){
                var myIcon = L.icon({
                    iconUrl: imageArray[i],
                    iconSize: [70, 70],
                    iconAnchor: [10, 10],
                    className: 'profile-picture-container-red'
                });
            }
            var marker = L.marker(locationArray[i],{icon:myIcon},{title:friendNameArray[i]});
            popupContent = friendNameArray[i];
            popupContent+= durationArray[i];
            marker.bindPopup(popupContent);
            marker.on('mouseover', function (e) {
            	this.openPopup();
            });
            marker.on('mouseout', function (e) {
            	this.closePopup();
            });
            markerLayerGroup.addLayer(marker);
        }

        markerLayerGroup.addTo(map);                       
            
        $("#loading-indicator").hide();

    }//end of function

    //
    function extractName(friendArray){
        var friendNameArray = [];
        for(counter in friendArray){
            total = friendArray[counter];
            for(friendInfo in total){
                var name = friendInfo;
            }
            friendNameArray.push(name);
        }
        return friendNameArray;
    }
    //

    var check_object = {};

    function check_for_change_in_coordinates(a) {
    
        if (JSON.stringify(a) === JSON.stringify(check_object)) {

            return false;
        } else {
            check_object = a;
            return true;
        }
    }


    showAlert = true;
    var friendNumber = 0;

    function checker() {
    
        if(logged.length >= 2){
            logged.push('otherload');
        }
    
        $.ajax({
            url: './php/data.php',
            type: 'post',
            datatype: 'json',

            success: function(data) {
            
        //$("#loading-indicator").hide();

                jsonParsed = JSON.parse(data);
                friendNumber = Object.keys(jsonParsed).length;

                for (something in jsonParsed) {
                    checking = jsonParsed[something];

                    if (checking[0] == "false") {
                        if (showAlert == true) {
                            alert("No One to View Yet. Search for Friends on Tracker and Get Connected");
                            showAlert = false;
                        }
                        first_map();
                        console.log('reach here');
                        return;
                    } 
                    else {

                        if (check_for_change_in_coordinates(jsonParsed) == true) {
                            if (markerLayerGroup) {
                                markerLayerGroup.clearLayers();
                            }
                        } 
                    }
                }
                var locationArray = extractLocation(jsonParsed);
                var imageArray = extractImage(jsonParsed);
                var friendNameArray = extractName(jsonParsed);
                var duration = new extractDuration(jsonParsed);
                var durationArray = duration.getDuration();
                var colorScheme = duration.getColorScheme();
                displayMap(locationArray,imageArray,friendNameArray,durationArray,colorScheme);
            }

        });
    }


    var logged = [];

    function loggedCheck() {
        
        if (logged.length == 0) {
            logged.push('firstload');
            checker();
            loggedCheck();
        } else if (logged.length > 0) {
            logged.push('secondload');
            interval = window.setInterval(checker, 10000);
            
        }
    }
    
    $("#loading-indicator").show();
    abso();
    var cartography = new Map();
    var map = cartography.getMap();
    loggedCheck();
    getNotifications();

});