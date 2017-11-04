new Vue({
    el: '#premium',
    data: {
        suggestions: [],
        contentString: [],
        search: '',
        searchCommunityId: '',
        lar: '',
        lng: '',
        com_lat: '',
        com_long: '',
        infowindow:'',
        checked_marker_icon:'',
        single_community_flag:'',
        slider_schools: {},
        lastSchool: {},
        topSchool: {}
    },
    created: function () {

        /// function being called on page load
        this.loadCurrentLocation();
        // this.hidesuggestions();
    },
    watch: {

    },
    methods: {
        loadSchools: function (clrId) {

            if(clrId){
                this.searchCommunityId = '';
            }
            
            this.suggestions = '';
            $('#suggestion-box').hide();
            
            search = this.search.split('/').join('**s**');
            this.$http.get('get-map-community-schools/' + encodeURI(search) + '/' + this.searchCommunityId).then((response) => {
                this.slider_schools = '';
                this.lastSchool = '';
                this.topSchool = '';

                if (response.body.data != '') {
                    //var res = google.maps.event.addDomListener(window, 'load', init);

                    this.contentString = [];
                    //console.log('data of schools', response.body.data); 
                    this.com_lat = response.body.data.com_lat;
                    this.com_long = response.body.data.com_long;
                    //console.log('data alllll', response.body.data.schools_array);
                    var schools_array = response.body.data.schools_array;
                    var schools_codes_array = response.body.data.schools_color_codes;
                    for (var i = 0; i < schools_array.length; i++) {

                        data = {};
                        //data.marker_icon = 'assets/images/marker_blue.svg';
                        data.marker_icon = schools_codes_array[i];
                        data.content = '<div id="content_' + schools_array[i].code + '">' +
                                '<div id="siteNotice_' + schools_array[i].code + '">' +
                                '</div>' +
                                '<div id="bodyContent_' + schools_array[i].title + '">' +
                                '<p><strong>' + schools_array[i].title + '</strong><br> ' + schools_array[i].street_address + '<br>' +
                                '<a style="cursor: pointer"  id="link_id_one_school"  class="custom_link">' +
                                ' Se skolans resultat</a> </p>' +
                                '<div class="text-center center-block"><div class="compare_check">' +
                                '<input id="' + schools_array[i].code + '"  class="compare_checkbox" type="checkbox" > <label for="'+schools_array[i].code+'" class="' + schools_array[i].code + '"> Välj </label><label class="1122"> Välj </label>' +
                                '</div></div>' +
                                '</div>' +
                                '</div>';
                        data.lat = schools_array[i].lat;
                        data.long = schools_array[i].long;
                        data.title = schools_array[i].title;
                        data.code = schools_array[i].code;
                        this.contentString[i] = data;

                    }
                    //console.log(this.contentString);
                    this.init();

                }
            }, (response) => {

            });
        },
        init: function () {

            var x = this.com_lat;
            var y = this.com_long;
            console.log(x + ' ' + y);
            var marker = "";
            //var infowindow = "";
            var check_count = 0;
            // Basic options for a simple Google Map
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 13,
                // gestureHandling: 'greedy',
                gestureHandling: 'cooperative',
                disableDoubleClickZoom: true,
                // The latitude and longitude to center the map (always required)
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: new google.maps.LatLng(x, y),
                //mapTypeId: 'satellite',
                // How you would like to style the map. 
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{
                        "featureType": "administrative",
                        "elementType": "all",
                        "stylers": [{
                                "saturation": "-100"
                            }]
                    }, {
                        "featureType": "administrative.province",
                        "elementType": "all",
                        "stylers": [{
                                "visibility": "off"
                            }]
                    }, {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [{
                                "saturation": -100
                            }, {
                                "lightness": 65
                            }, {
                                "visibility": "on"
                            }]
                    }, {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [{
                                "saturation": -100
                            }, {
                                "lightness": "50"
                            }, {
                                "visibility": "simplified"
                            }]
                    }, {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [{
                                "saturation": "-100"
                            }]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [{
                                "visibility": "simplified"
                            }]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "all",
                        "stylers": [{
                                "lightness": "30"
                            }]
                    }, {
                        "featureType": "road.local",
                        "elementType": "all",
                        "stylers": [{
                                "lightness": "40"
                            }]
                    }, {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [{
                                "saturation": -100
                            }, {
                                "visibility": "simplified"
                            }]
                    }, {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{
                                "hue": "#ffff00"
                            }, {
                                "lightness": -25
                            }, {
                                "saturation": -97
                            }]
                    }, {
                        "featureType": "water",
                        "elementType": "labels",
                        "stylers": [{
                                "lightness": -25
                            }, {
                                "saturation": -100
                            }]
                    }]
            };

            var mapElement = document.getElementById('map');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);
            

            


            this.infowindow = new google.maps.InfoWindow({
                maxWidth: 500
            });
            var markersData = 0;

            //// setting for responsiveness of map
//            google.maps.event.addDomListener(window, 'resize', function() {
//                map.setCenter(center);
//                 map.panTo(marker.getPosition());
//
//            });
            //// setting for responsiveness of map

            var markerBounds = new google.maps.LatLngBounds();

            var arr_pins = [];
            for (var i = 0; i < this.contentString.length; i++) {
                ///alert('loading');
                //console.log('strings array', this.contentString[i]);
                arr_pins[i] = this.contentString[i];
                addMarker(arr_pins[i]);
            }

            // map.fitBounds(markerBounds);

           // var checked_marker_icon = '';
            var check_boxes_index = [];
            var get_obj = '';
            var array_schools_data = [];
            var self = this;
            function addMarker(arr) {
                //console.log('strings array', arr);
                var x = arr.lat;
                var y = arr.long;
                var randomPoint = new google.maps.LatLng(x, y);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(x, y),
                    icon: arr.marker_icon,
                    map: map,
                    title: arr.title,
                    content: $(arr.content)[0],
                    m_index: i,
                    code: arr.code
                });

                markerBounds.extend(randomPoint);


                google.maps.event.addListener(marker, 'click', (function (marker) {
                    return function () {
                    
                        //$(contentStr).remove('.compare_checkbox');                        
                        console.log('checked array',marker.code);
                        //alert(check_count);
                        var flag_arr = false;
                        for (var iter = 0; iter < array_schools_data.length; iter++) {

                            //if(arr_pins[chk].code == markersData)
                            if (array_schools_data[iter] == marker.code)
                            {                                
                                flag_arr = true;
                            }
                            
                        }
                        console.log('flag now', flag_arr);
                        console.log('check count is', check_count);
                        if(window.innerWidth < 769 && (check_count + 1) > 2  ){
                            //$( "div" ).remove( ".hello" );
                            if(flag_arr == true){
                                var contentStr = this.get('content');
                                $(contentStr).find(".1122").hide();
                                $(contentStr).find("."+marker.code).show();                                
                                self.infowindow.setContent(contentStr);
                                self.infowindow.open(this.getMap(), this); 
                            }
                            else{
                            var contentStr = this.get('content');
                            $(contentStr).find("."+marker.code).hide();
                            $(contentStr).find(".1122").show();                            
                            self.infowindow.setContent(contentStr);
                            self.infowindow.open(this.getMap(), this); 
                            //console.log('content data', this.get('content'));
                            //$(".compare_check compare_checkbox").hide();
                        }
                       }
                        else{
                            //alert('should come here');
                            console.log('content data in else', this.get('content'));
                            var contentStr = this.get('content');
                            $(contentStr).find(".1122").hide();
                            $(contentStr).find("."+marker.code).show();                            
                            self.infowindow.setContent(contentStr);
                            self.infowindow.open(this.getMap(), this);  
                            
                        }
                        self.checked_marker_icon = marker.icon;
                        markersData = marker.code;
                        
                        if (check_boxes_index.length == 0) {
                            check_boxes_index.push(markersData)
                        }

                        var flag = true;
                        for (var chk = 0; chk < check_boxes_index.length; chk++) {

                            //if(arr_pins[chk].code == markersData)
                            if (check_boxes_index[chk] == markersData)
                            {
                                // check_boxes_index.push(markersData);
                                flag = false;
                            }
                        }
                        if (flag == true) {
                            check_boxes_index.push(markersData);
                        }

                    }
                })(marker));

            }


            $('#map').on('click', '#link_id_one_school', function () {

                $("#one_school_codes_input").remove();
                $("#one_schools_form").append('<input type="hidden" id="one_school_codes_input" name="school_codes" value="' + markersData + '">');
                //var form = $('<form method="post" id="form_one_school" action="school-comparison"> <input type="text" name="_token" value="{{ csrf_token() }}"> <input type="hiddden" id="school_codes_input" name="school_codes" value=' + markersData + '> </form>').appendTo('.map_box');


                $('#one_schools_form').submit();

            });
            var selected_marker = "assets/images/marker_selected.svg";

            
            var schools_count = 0;

            $('#map').on('change', '.compare_checkbox', function () {

                
                //// no more than two schools on mobile and tab
//                if (window.innerWidth < 769 && (check_count + 1) > 2) {
////                    $(".compare_checkbox").attr('checked', false);
////                    alert('you can not select more than 2 schools. Thanks');
//
//                } else {
                    //console.log('data of selected marker', (marker.icon).split("/"));
                    if ($(this).is(':checked')) {
                        
                        //console.log('splitted', self.infowindow.anchor.setIcon('assets/images/marker_red_checked.svg'));
                        var icon = ((self.checked_marker_icon).split("/"))[2].split('.');
                        //var icon = ((marker.icon).split("/")[2]).split('.');
                        //console.log('name of icon', (icon[0]).trim());


                    //console.log('data of info window', self.checked_marker_icon);
//                        if(infowindow.anchor == 'null' || infowindow.anchor == null){
//                            //alert('inside');
//                            //infowindow.anchor.icon = marker.icon;
//                        }
                        check_count++;
                        $(this).addClass('checked');
                        if ((icon[0]).trim() == 'marker_red' || (icon[0]).trim() == 'marker_red_checked') {
                            self.infowindow.anchor.setIcon('assets/images/marker_red_checked.svg');
                        } else if ((icon[0]).trim() == 'marker_gray' || (icon[0]).trim() == 'marker_gray_checked') {
                            self.infowindow.anchor.setIcon('assets/images/marker_gray_checked.svg');
                        } else if ((icon[0]).trim() == 'marker_green' || (icon[0]).trim() == 'marker_green_checked') {
                            self.infowindow.anchor.setIcon('assets/images/marker_green_checked.svg');
                        } else if ((icon[0]).trim() == 'marker_orange' || (icon[0]).trim() == 'marker_orange_checked') {

                            self.infowindow.anchor.setIcon('assets/images/marker_orange_checked.svg');
                        } else if ((icon[0]).trim() == 'marker_yellow' || (icon[0]).trim() == 'marker_yellow_checked') {
                            self.infowindow.anchor.setIcon('assets/images/marker_yellow_checked.svg');
                        } else if ((icon[0]).trim() == 'marker_blue' || (icon[0]).trim() == 'marker_blue_checked') {
                            self.infowindow.anchor.setIcon('assets/images/marker_blue_checked.svg');
                        }

                        array_schools_data[schools_count] = $(this)[0].id;
                        //console.log('data to pass', array_schools_data);
                        schools_count++;
                        $("#school_codes_input").remove();
                        $("#schools_form").append('<input type="hidden" id="school_codes_input" name="school_codes" value="' + array_schools_data + '">');


                    } else {
                        check_count--;
                        $(this).removeClass('checked');


                        //console.log('data to arrays', arr_pins);
                        //console.log('data to codeeee', markersData);
                        for (var chk_indx = 0; chk_indx < arr_pins.length; chk_indx++) {
                            if (arr_pins[chk_indx].code == markersData) {

                                self.infowindow.anchor.setIcon(arr_pins[chk_indx].marker_icon);
                            }

                        }
                        for (var m = 0; m < array_schools_data.length; m++) {

                            if (array_schools_data[m] == markersData) {
                                array_schools_data.splice(m, 1);
                                schools_count--;
                            }

                            if (check_boxes_index[m] == markersData) {
                                check_boxes_index.splice(m, 1);
                            }
                        }

                        $("#school_codes_input").remove();
                        $("#schools_form").append('<input type="hidden" id="school_codes_input" name="school_codes" value="' + array_schools_data + '">');
                        //console.log('data to delet', check_boxes_index);

                        if (check_count == 0) {
                            $('.chk_after').find('.compare_checkbox').remove();
                            check_boxes_index = [];
                        }

                        //infowindow.anchor.setIcon(arr[marker[m_index]].marker_icon.marker_icon);
                        //alert(markersData);
                    }


                    $('#selected_schools').html(check_count + ' skolor');
                    if (check_count == 0) {

                        $('.map_box:eq(0)').slideDown('fast', function () {
                            $(this).nextAll('.map_box').slideUp('fast');
                        });
                    } else
                    if (check_count == 1) {
                        $("#schools_form").append('<input type="hidden" id="school_codes_input" name="school_codes" value="' + array_schools_data + '">');
                        $('.map_box:eq(1)').slideDown('fast', function () {
                            $(this).nextAll('.map_box').slideUp('fast');
                            $(this).prevAll('.map_box').slideUp('fast');
                        });
                    } else if (check_count >= 2) {
                        $('.map_box:eq(2)').slideDown('fast', function () {
                            $(this).prevAll('.map_box').slideUp('fast');
                        });
                    }
                //}
            });





        },
        hidesuggestions: function () {
            setTimeout(function () {
                $('#suggestion-box').hide()
            }, 500);
        },
        selectedVal: function (community_code, community_title) {


            this.suggestions = '';
            this.search = community_title;
            //this.searchCommunityId = community_code;
            this.loadSchools(0);
        },
        selectCommunity: function (event) {
            $('#suggestion-box').show();
            if (event.key == 'Enter') {
                return;
            }
            if (this.search == '') {
                this.suggestions = '';
                return;
            }
            //replace all slashes to **s**;
            search = this.search.split('/').join('**s**');
            this.$http.get('select-community/' + search).then((response) => {
                this.suggestions = response.body;

            }, (response) => {

            });
        },
        loadCurrentLocation: function () {
            
            var url = '/admin/get-comm-setting?search=';
            var comm_lat;
            var comm_long;
            var self = this;
            this.$http.get(url) .then ((response) => {
                   //console.log('com-data', response.body.data);
                    
                    this.single_community_flag = response.body.data[2].status;
                    if(this.single_community_flag == 1){
                        this.search = response.body.data[2].value; 
                        this.searchCommunityId = response.body.data[2].key_options;
                        this.loadSchools(this.search);
                    }
                    else{
                            $("#suggestion-box").hide();
                           setTimeout(this.suggestions = '', 1000);
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function showPosition(pos) {
                                self.$http.get('current-location-community-premium/' + pos.coords.latitude + '/' + pos.coords.longitude).then((response) => {
                                    //console.log('community response', response.body.data);
                                    self.search = response.body.data;
                                    self.selectedVal(response.body.data.com_code, response.body.data.com_title);

                                }, (response) => {

                                });

                            },
                            function (error) {
                                self.search = 'Stockholm';
                                self.searchCommunityId = '0180';
                                self.loadSchools(self.search);
                            });
                        } else {
                            self.search = 'Stockholm';
                            self.searchCommunityId = '0180';
                            self.loadSchools(self.search);
                        }


                        function showPosition(position) {
                            /*------------------show location------------------------*/
                            comm_lat = position.coords.latitude;
                            comm_long = position.coords.longitude;

                        }
                    }
                    
                }, (response) => {
                    // error occur
            });      
           //console.log('asdasd com-data', this.search);
            



        }

    }
});