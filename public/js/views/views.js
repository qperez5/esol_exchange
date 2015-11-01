Esol.MapView = Ember.View.extend({
    templateName: "map",
    map: null,
    mapMarkers: Ember.A([]),

    didInsertElement: function(){
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
            center: new google.maps.LatLng(51.548222, 0.01500),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
        this.set("map",map);
        var newhamLayer = new google.maps.KmlLayer({
            url: "http://mapit.mysociety.org/area/2510.kml",
            map: map
        });
        this.displaySearchResults();
    },

    displaySearchResults: function(){
        this.clearMarkers();

        var controller = this.get("controller");
        var mapVar = this.get("map");
        var coursesMap = controller.get("coursesMap");
        var mapMarkers = this.get("mapMarkers");

        controller.get("centres").forEach(function(centre){
            var courses = coursesMap[centre.get("id")];
            var infoWindow = new google.maps.InfoWindow({
                content: controller.templateToString(centre,courses)
            });

            var marker = new google.maps.Marker({
                map: mapVar,
                position: centre.get("latLng"),
                label: courses.length.toString(),
                title: centre.get("name")
            });

            marker.addListener('click', function() {
                infoWindow.open(mapVar, marker);
            });

            mapMarkers.pushObject(marker);
        });

    }.observes("controller.centres"),

    clearMarkers: function(){
        this.get("mapMarkers").forEach(function(marker){
            marker.setMap(null);
        });
        this.get("mapMarkers").clear();
    }
});

Esol.EditCentreView = Ember.View.extend({
    templateName: "editCentre",
    didInsertElement: function(){
        var mapCanvas = document.getElementById('map-canvas');
        //var context = mapCanvas.getContext("2d");
        var mapOptions = {
            center: new google.maps.LatLng(51.548222, 0.01500),
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
        this.get("controller").set("map",map);
    }
});

Esol.SearchResultView = Ember.View.extend({
    templateName: "searchResult",
    didInsertElement: function(){
        var mapCanvas = document.getElementById('map-canvas-small');
        var mapOptions = {
            center: new google.maps.LatLng(51.548222, 0.01500),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
        this.get("controller").set("map",map);
    }
});

Esol.OrganizationView = Ember.View.extend({
    templateName: "organization",
    didInsertElement: function(){
        var pagination = document.getElementById('pag');
        pagination.bs_pagination;
    }
});

Esol.InfoWindowComponent = Ember.Component.extend({
    classNames: ['info-window-container'],

    attachTo: function ($el) {
        this.$().detach().appendTo($el);
    }
});
