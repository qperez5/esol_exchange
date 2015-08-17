Esol.MapView = Ember.View.extend({
    templateName: "map",
    didInsertElement: function(){
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
            center: new google.maps.LatLng(51.548222, 0.01500),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions)

    }

});

Esol.EditCentreView = Ember.View.extend({
    templateName: "editCentre",
    didInsertElement: function(){
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
            center: new google.maps.LatLng(51.548222, 0.01500),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(mapCanvas, mapOptions);
        this.get("controller").set("map",map);

    }

});

