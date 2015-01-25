    //
    function displayingTracks(coordinates, time) {

        var poly = new L.Polyline(coordinates, {
            color: '#00FF00',
            weight: 4,
            smoothFactor: 5
        });

        var decorator = L.polylineDecorator(poly, {
            patterns: [
                // define a pattern of 10px-wide dashes, repeated every 15px on the line 
                {
                    offset: 0,
                    repeat: '15px',
                    symbol: new L.Symbol.Dash({
                        pixelSize: 10
                    })
                }
            ]
        });
        //.addTo(map);

        last_index = coordinates.length - 1;
        last_time = time.length - 1;

        startIcon = L.icon({
            iconUrl: './img/start_track.gif',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        endIcon = L.icon({
            iconUrl: './img/end_track.gif',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        first_latlngpair = coordinates[0];
        
        first_marker = L.marker(first_latlngpair, {
            icon: startIcon
        });
        first_time = time[0];
        var manipulated_start = manipulationTime(first_time);
        first_marker.bindPopup("Track started<br/>On " + manipulated_start);
        first_marker.on('mouseover', function (e) {
            	this.openPopup();
        });
        first_marker.on('mouseout', function (e) {
            	this.closePopup();
        });
        //first_marker.addTo(map);

        last_latlngpair = coordinates[last_index];
        
        last_marker = L.marker(last_latlngpair, {
            icon: endIcon
        });
        last_time = time[last_time];
        var manipulated_end = manipulationTime(first_time);
        last_marker.bindPopup("Track ended<br/>On " + manipulated_end);
        last_marker.on('mouseover', function (e) {
            	this.openPopup();
        });
        last_marker.on('mouseout', function (e) {
            	this.closePopup();
        });
        //last_marker.addTo(map);

        this.getDecorator = function(){
            return decorator;
        };

        this.getStartFlag = function(){
            return first_marker;
        };

        this.getEndFlag = function(){
            return last_marker;
        };

        this.getStartTime = function(){
            return manipulated_start;
        };
    }
    //

    //
    function Map(){

		map = L.map('map',{
        	doubleClickZoom: true
		});//.setView([27.6989,85.3209],13);

		function osmTiles() {
        	return L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            	attribution: 'Map data and tiles &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://www.openstreetmap.org/copyright/">Read the Licence here</a> | Cartography &copy; <a href="http://kathmandulivinglabs.org">Kathmandu Living Labs</a>, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
        	});
    	}

    	var osmTileLayer = new osmTiles();

    	osmTileLayer.addTo(map);

    	L.control.scale().addTo(map);

    	this.getMap = function(){
    		return map;
    	};
	}
    //

    //
    function setMapExtent(receivedLocationArray){
        var wholeExtend = new L.LatLngBounds(); //extend of the map
        for (var i = 0; i < receivedLocationArray.length; i++) {                
            wholeExtend.extend(receivedLocationArray[i]);
        }
        map.fitBounds(wholeExtend);
    }
    //

    //
    function rounded(a) {
        return (Math.round(a));
    }
    //
    
    //
    function extractLocation(friendArray){
        var locationArray = [];
        for(counter in friendArray){
            total = friendArray[counter];
            for(friendInfo in total){
                var lat = total[friendInfo][0];
                var lng = total[friendInfo][1];
                var latLng = L.latLng(lat,lng);
            }
            locationArray.push(latLng);
        }
        return locationArray;
    }
    //

    //
    function extractImage(friendArray){
        var imageArray = [];
        for(counter in friendArray){
            total = friendArray[counter];
            for(friendInfo in total){
                var imageLink = total[friendInfo][3];
                if(!imageLink){
                    imageLink = './uploaded_files/person.jpg';
                }
            }
            imageArray.push(imageLink);
        }
        return imageArray;
    }
    //

    //
    function extractDuration(friendArray){
        var durationArray = [];
        var colorScheme = [];
        for(counter in friendArray){
            total = friendArray[counter];
            for(friendInfo in total){

                var totalInfo = total[friendInfo];

                timeInfo = totalInfo[4]; //the time 

                var reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
                var dateArray = reggie.exec(timeInfo);
                dateObject = new Date(
                    (+dateArray[1]), (+dateArray[2]) - 1, (+dateArray[3]), (+dateArray[4]), (+dateArray[5]), (+dateArray[6])
                ); //close of date_object
                //console.log("date_object"+dateObject);
                var utcDate = dateObject.getTime() / 1000; //calculates second between date_object and 1970/1/1

                //current timestamp
                var dateNow = new Date();
                var utcNow = dateNow.getTime() / 1000; //calculates second between now and 1970/1/1

                //for the difference 
                //var diff_in_seconds = 0;
                var diff_in_minutes = 0;
                var diff_in_hrs = 0;
                var diff_in_days = 0;
                var diff_in_weeks = 0;
                var diff_in_months = 0;
                var diff_in_years = 0;
                timeDiff = [];


                var diff_in_seconds = utcNow - utcDate;
                diff_in_minutes = diff_in_seconds / 60;
                diff_in_hrs = diff_in_minutes / 60;
                diff_in_days = diff_in_hrs / 24;
                diff_in_weeks = diff_in_days / 7;
                diff_in_months = diff_in_weeks / 4;
                diff_in_years = diff_in_months / 12;

                if (diff_in_seconds > 0) {
                
                    if(diff_in_seconds>0 && diff_in_seconds<60){
                        duration = '</br>'+'Active Few Seconds Ago';   
                        color = 'GREEN';        
                        //$(marker._icon).css("border-color", "#00933B");
                        //$(marker._icon).addClass("greenBorder");
                    } else if (diff_in_minutes >= 1 && diff_in_minutes < 60) {
                        timeDiff['min'] = rounded(diff_in_minutes);
                        duration = '</br>' + 'Active ' + timeDiff['min'] + ' mins ago';
                        color = 'GREEN';
                        //$(marker._icon).css("border-color", "#00933B");
                        //$(marker._icon).addClass("greenBorder");
                    } else if (diff_in_hrs >= 1 && diff_in_hrs < 24) {
                        timeDiff['hrs'] = rounded(diff_in_hrs); //rounded off to nearest hours
                        duration = '</br>' + 'Active: ' + timeDiff['hrs'] + ' hours ago';
                        color = 'GREEN';
                        //$(marker._icon).css("border-color", "#00933B");
                        //$(marker._icon).addClass("greenBorder");
                    } else if (diff_in_days >= 1 && diff_in_days < 7) {
                        timeDiff['days'] = rounded(diff_in_days);
                        duration = '</br>' + 'Active ' + timeDiff['days'] + ' days ago';
                        color = 'YELLOW';
                        //$(marker._icon).css("border-color", "#F2B50F");
                        //console.log(marker._icon);
                        //$(marker._icon).addClass("yellowBorder");
                    } else if (diff_in_weeks >= 1 && diff_in_weeks < 4) {
                        timeDiff['weeks'] = rounded(diff_in_weeks);
                        duration = '</br>' + 'Active ' + timeDiff['weeks'] + ' weeks ago';
                        color = 'YELLOW';
                        //console.log(marker._icon);
                        //$(marker._icon).attr("class","yellowBorder");
                        //$(marker._icon).addClass("yellowBorder");
                    } else if (diff_in_months >= 1 && diff_in_months < 12) {
                        timeDiff['months'] = rounded(diff_in_months);
                        duration = '</br>' + 'Active ' + timeDiff['months'] + ' months ago';
                        color = 'RED';
                        //$(marker._icon).css("border-color", "#F90101");
                        //$(marker._icon).addClass("redBorder");
                    } else {
                        timeDiff['years'] = rounded(diff_in_years);
                        duration = '</br>' + 'Active ' + timeDiff['years'] + ' years ago' + '</br>';
                        color = 'RED';
                        //console.log("years");
                        //$(marker._icon).css("border-color", "#F90101");
                        //$(marker._icon).addClass("redBorder");
                    }

                } //if close
                
            }

            colorScheme.push(color);
            durationArray.push(duration);

        }

        this.getDuration = function(){
            return durationArray;
        };
        this.getColorScheme = function(){
            return colorScheme;
        };
        //return durationArray;
    }
    //

	function friendInformation(data,length){
        friendRequest = [];
        requestId = [];

        for(id in data){
            friend_id = data[id];
            for(name in friend_id){
                request_id = name;
                friend_name = friend_id[name].toString();
                requestId.push(request_id);
                friendRequest.push(friend_name);
            }
        }
        
        if(request_id!=0){
            
            $(".navbar-brand > #notifications > img[name=notification]").attr("src","img/no-notification.png");
            $(".navbar-brand > #notifications").append('<span class="badge pull-right">'+length+'</span>');

            $.each(friendRequest,function(index){
                $("#modalContent_notifications").append('<a href="select_profile.php?value='+friendRequest[index]+'"><h4>'+friendRequest[index]+'</a> wants to follow you</h4>');

                $("#modalContent_notifications").append(function(){

                    return $('<button class="btn btn-default btn-sm" id="acceptFriend" style="float:right;"><img src = "./img/accept.png" style="height:15px;width:15px;"></button>').click(function(e){
                        console.log("here");
                        $("#loading-indicator").show();
                        //$body.addClass("loading");
                        $.ajax({
                            type:'POST',
                            data:{request_id:requestId[index]},
                            url:'./php/connect_friend.php',
                            success:function(){
                      
                                $("#loading-indicator").hide();                        
                                $('#modalContent_notifications').modal('hide');
                                window.location.reload(true);
                            }
                        });
                    });
                });

                $(".modal-body #modalContent_notifications").append(function(){
                    
                    return $('<button class="btn btn-default btn-sm" id="rejectFriend" style="float:right;"><img src = "./img/reject.png" style="height:15px;width:15px;"></button>').click(function(e){
                        
                        $("#loading-indicator").show();
                        $.ajax({
                            type:'POST',
                            data:{request_id:requestId[index]},
                            url:'./php/reject_friend.php',
                            success:function(){
                                $("#loading-indicator").hide();
                                $('#modalContent_notifications').modal('hide');
                                window.location.reload(true);
                            }
                        });
                    });

                });

                $(".modal-body #modalContent_notifications").append('<br/><hr/><br/>');

            });
        }

        else if(request_id == 0 && friend_name=='none'){
            $(".modal-body #modalContent_notifications").append('<h3>No Request</h3>');
        }
    }

    //
    function extractForProfile(checkInArray){

        var following = 0;
        var followers = 0;
        var checkIns = 0;
        var tracks = 0;
        var counter = 1;
        if(counter === 1){
            for(counter in checkInArray){
                total = checkInArray[counter];
                for(info in total){
                    checkIns = total[info][2];
                    tracks = total[info][7];
                    following = total[info][5];
                    followers = total[info][6];
                    profilePicture = total[info][3];
                }
                counter = 0;
            }
        }
        
        this.getFollowers = function(){
            return followers;
        };

        this.getFollowing = function(){
            return following;
        };

        this.getCheckIns = function(){
            return checkIns;
        };

        this.getTracks = function(){
            return tracks;
        };

        this.getProfilePicture = function(){
            return profilePicture;
        };
    }
    //

    //
    function profileFriendCheck(incomingArray){

        var friend = 0;
        var counter = 1;

        if(counter === 1){
            for(counter in incomingArray){
                total = incomingArray[counter];
                for(info in total){
                    friend = total[info][8];
                }
                counter = 0;
            }
        }

        return friend;

    }
    //

    //
    function displayProfile(checkIns,tracks,following,followers,profilePicture){

        $("#profile-picture").append(function(){            
            return $("<img>").attr({                
                src:profilePicture,
                class:"img-rounded",
                height:"180",
                width:"180"
            });
        });

        $("#check-in").html("Check-Ins<br/>").append(checkIns);
        
        if (following === 0){
            $("#following").html("<br/>Following<br/>").append(following);
        } else{
            
            $("#following").append(function(){
              return $("<a/>").attr({ "data-toggle":"modal","data-target":"#followingList",id:"forFollowingClick"}).html("Following<br/>").append(following);
            });

            $("#forFollowingClick").one('click',function(){
                $("#loading-indicator").show();
                
                $.ajax({
                    type: 'POST',
                    url: './php/FollowingList.php',
                    success: function(data) 
                    {
                      parse_json = JSON.parse(data);
                      names=[];
                      
                      $("#loading-indicator").hide();
                      //$body.removeClass("loading");
                      

                      for(trackeearray in parse_json){
                        //console.log("trackeename="+data[trackeename][0]);
                        arrays = parse_json[trackeearray];
                        for(trackeename in arrays){
                          a=arrays[trackeename].toString();
                          names.push(a);
                          //console.log(names);
                        }
                        
                      }

                      $.each(names,function(index){
                        $("#modalContentFollowing").append('<a href="select_profile.php?value='+names[index]+'"><h2>'+names[index]+'</h2></a><hr/>');
                      });

                    }
                });
            });
        }


        if (followers === 0){
            $("#followers").html("<br/>Followers<br/>").append(followers);

        } else{
            
            $("#followers").append(function(){
              return $("<a/>").attr({ "data-toggle":"modal","data-target":"#followersList",id:"forFollowersClick"}).html("Followers<br/>").append(followers);
            });

            $("#forFollowersClick").one('click',function(){
                $("#loading-indicator").show();
                
                $.ajax({
                    type: 'POST',
                    url: './php/FollowersList.php',
                    success: function(data) 
                    {
                      parse_json = JSON.parse(data);
                      names=[];
                      
                      $("#loading-indicator").hide();
                      //$body.removeClass("loading");
                      

                      for(trackeearray in parse_json){
                        //console.log("trackeename="+data[trackeename][0]);
                        arrays = parse_json[trackeearray];
                        for(trackeename in arrays){
                          a=arrays[trackeename].toString();
                          names.push(a);
                          //console.log(names);
                        }
                        
                      }

                      $.each(names,function(index){
                        $("#modalContentFollowers").append('<a href="select_profile.php?value='+names[index]+'"><h2>'+names[index]+'</h2></a><hr/>');
                      });

                    }
                });
            });
        }

        if (tracks === 0){
            $("#tracks").html("Tracks<br/>").append(tracks);
        } else{
              $("#tracks").append(function(){
                return $("<a/>").attr({href:"./TrackerInterface.php"}).html("My Tracks<br/>").append(tracks);
              });
        }
    }
    //

    //
    function displaySelectedProfile(checkIns,tracks,following,followers,profilePicture,viewable){

        $("#profile-picture").append(function(){            
            return $("<img>").attr({                
                src:profilePicture,
                class:"img-rounded",
                height:"180",
                width:"180"
            });
        });

        $("#check-in").html("Check-Ins<br/>").append(checkIns);
        
        if (following === 0){
            $("#following").html("<br/>Following<br/>").append(following);
        } else{
            
            $("#following").append(function(){
              return $("<a/>").attr({ "data-toggle":"modal","data-target":"#followingList",id:"forFollowingClick"}).html("Following<br/>").append(following);
            });

            $("#forFollowingClick").one('click',function(){
                $("#loading-indicator").show();
                
                $.ajax({
                    type: 'POST',
                    url: './php/selectedProfile-FollowingList.php',
                    success: function(data) 
                    {
                      parse_json = JSON.parse(data);
                      names=[];
                      
                      $("#loading-indicator").hide();
                      //$body.removeClass("loading");
                      

                      for(trackeearray in parse_json){
                        //console.log("trackeename="+data[trackeename][0]);
                        arrays = parse_json[trackeearray];
                        for(trackeename in arrays){
                          a=arrays[trackeename].toString();
                          names.push(a);
                          //console.log(names);
                        }
                        
                      }

                      $.each(names,function(index){
                        $("#modalContentFollowing").append('<a href="select_profile.php?value='+names[index]+'"><h2>'+names[index]+'</h2></a><hr/>');
                      });

                    }
                });
            });
        }


        if (followers === 0){
            $("#followers").html("<br/>Followers<br/>").append(followers);

        } else{
            
            $("#followers").append(function(){
              return $("<a/>").attr({ "data-toggle":"modal","data-target":"#followersList",id:"forFollowersClick"}).html("Followers<br/>").append(followers);
            });

            $("#forFollowersClick").one('click',function(){
                $("#loading-indicator").show();
                
                $.ajax({
                    type: 'POST',
                    url: './php/selectedProfile-FollowersList.php',
                    success: function(data) 
                    {
                      parse_json = JSON.parse(data);
                      names=[];
                      
                      $("#loading-indicator").hide();
                      //$body.removeClass("loading");
                      

                      for(trackeearray in parse_json){
                        //console.log("trackeename="+data[trackeename][0]);
                        arrays = parse_json[trackeearray];
                        for(trackeename in arrays){
                          a=arrays[trackeename].toString();
                          names.push(a);
                          //console.log(names);
                        }
                        
                      }

                      $.each(names,function(index){
                        $("#modalContentFollowers").append('<a href="select_profile.php?value='+names[index]+'"><h2>'+names[index]+'</h2></a><hr/>');
                      });

                    }
                });
            });
        }

        if (tracks === 0){
            $("#tracks").html("Tracks<br/>").append(tracks);
        } else{

            $("#tracks").append(function(){                
                if(viewable === 1){
                    return $("<a/>").attr({href:"./TrackerInterfaceUser.php"}).html("Tracks<br/>").append(tracks);  
                } else{
                    $('#tracks').html("Tracks<br/>").append(tracks);  
                }
            });
        }
    }
    //

    //
    function displayFriendButton(viewable){
        
        if(viewable == 1) {
          $("#friend").css('display', 'block');
          $("#unfriend").css('display', 'block');
        } else if(viewable == 2){
          $("#friendRequestSent").css('display', 'block');
        } else if(viewable == 0){
          $("#addAsFriend").css('display', 'block');
        }
    }
    //

    //
   	function getNotifications(){
    
    	$("#loading-indicator").show();
            $.ajax({
              url:'./php/notifications.php',
                type: 'post',
                datatype: 'json',
                success:function (output){       

	                $("#loading-indicator").hide();
	                json_parsed = JSON.parse(output);//converts JSON string to object 
	                var length_of_object = Object.keys(json_parsed).length;
	                friendInformation(json_parsed,length_of_object);
                }
            });
    }
    //

    //
    function getIcon(){

        var myIcon = L.icon({
            iconUrl: './img/place_icon.png',
            iconSize: [25,25],
            iconAnchor:[10,10]
        });

        return myIcon;
    }
    //

    //
    function setMarkerCluster(){
      return L.markerClusterGroup({showCoverageOnHover: false});
    }
    //

    //
    function manipulationTime(time){

        var timeString = new Date(time).toString();
        var day = timeString.substring(0,3);
        var month = timeString.substring(4,7);
        var date = timeString.substring(8,10);
        var year = timeString.substring(11,15);

        var popup = date+" "+month+","+year+" "+day;
        return popup;
    }
    //
