class Polygon {
    constructor(myMap) {
        this.myDrawingManager;       // holds drawing tools
        this.myField;                // holds the polygon we draw using drawing tools
        this.myMap = myMap;         // holds the map object drawn on the 
        this.color;
        this.paths;
    }

    /**
     * Show drawing tools
     */
    SetColor(color){
        this.color = color;
    }
    DrawingTools() {

        // drawingMode of NULL, which means that the map drawing tools will
        // have no default drawing tool selected. If drawingMode was set to 
        // google.maps.drawing.OverlayType.POLYGON, polygon would be auto-
        // selected
        // drawingModes can have multiple information. Over here only the
        // polygon capability is added along with the default of hand icon
        // Moreover, polygonOptions are specified as defaults
        this.myDrawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT,
                drawingModes: [
                    // google.maps.drawing.OverlayType.POLYGON
                ]
            },
            polygonOptions: {
                draggable: false,
                editable: false,
                fillColor: this.color,
                fillOpacity: 0.1,
                strokeColor: this.color,
            }
        });
        this.myDrawingManager.setMap(this.myMap);

        // when polygon drawing is complete, an event is raised by the map
        // this function will listen to the event and work appropriately

        google.maps.event.addListener(
            this.myDrawingManager,
            'overlaycomplete',
            (event) => {
                var paths = event.overlay.getPaths();
                var polygon = new google.maps.Polygon({
                    fillColor: this.color,
                    fillOpacity: 0.5,
                    strokeWeight: 5,
                    strokeColor: this.color,
                    editable: false,
                    draggable: false,
                    paths: paths,
                    map: this.myMap
                });
                this.paths = paths;
                this.myField = polygon;
            }
        );

        this.FieldDrawingCompletionListener();
        
    }

    DrawField(paths){
        var polygon = new google.maps.Polygon({
            fillColor: this.color,
            fillOpacity: 0.5,
            strokeWeight: 5,
            strokeColor: this.color,
            editable: false,
            draggable: false,
            paths: paths,
            map: this.myMap
        });
        this.paths = paths;
        this.myField = polygon;
        this.FieldClickListener();
        this.FieldEditable(false);
    }

    FieldDrawingCompletionListener(editable = true) {
        // capture the field, set selector back to hand, remove drawing
        google.maps.event.addListener(
            this.myDrawingManager,
            'polygoncomplete',
            (polygon) => {
                polygon.setMap(null);
                this.ShowDrawingTools(false);
                this.FieldClickListener();
                this.FieldEditable(editable);
            }
        );
    }

    ShowDrawingTools(val) {
        this.myDrawingManager.setOptions({
            drawingMode: null,
            drawingControl: val
        });
        this.FieldEditable(false);
    }

    /**
     * Allow or disallow polygon to be editable and draggable 
     */
    FieldEditable(val) {
        this.myField.setOptions({
            editable: val,
            // draggable: val
        });
        return false;
    }

    /**
     * Attach an event listener to the polygon. When a user clicks on the 
     * polygon, get a formatted message that contains links to re-edit the 
     * polygon, mark the polygon as complete, or delete the polygon. The message
     * appears as a dialog box
     */
    FieldClickListener() {
        google.maps.event.addListener(
            this.myField,
            'click',
            (event) => {
                var message = this.GetMessage(this.myField);
                // this.FieldEditable(true);
                console.log(message);
            }
        );
    }
    /**
     * Delete the polygon and show the drawing tools so that new polygon can be
     * created
     */
    DeleteField() {

        if (typeof(this.myField) !== 'undefined'){
            this.myField.setMap(null);
        }
    }

    /**
     * Get coordinates of the polygon and display information that should 
     * appear in the polygon's dialog box when it is clicked
     */
    GetMessage(polygon) {
        var coordinates = polygon.getPath().getArray();
        var message = '';

        message += '<div style="color:#000">This polygon has ' 
            + coordinates.length + ' points<br>'
            + 'Area is ' + this.GetArea(polygon) + ' acres</div>';

        var coordinateMessage = '<p style="color:#000">My coordinates are:<br>';
        for (var i = 0; i < coordinates.length; i++) {
            coordinateMessage += coordinates[i].lat() + ', ' 
                + coordinates[i].lng() + '<br>';
        }
        coordinateMessage += '</p>';

        message += coordinateMessage;
        // message += '<p><a href="#" onclick="FieldEditable(true);">Edit</a> '
        //     + '<a href="#" onclick="FieldEditable(false);">Done</a> '
        //     + '<a href="#" onclick="DeleteField('+this.myField+')">Delete</a></p>'
        //     + coordinateMessage;

        return message;
    }

    /**
     * Get area of the drawn polygon
     */
    GetArea(poly) {
        var result = parseFloat(google.maps.geometry.spherical.computeArea(poly.getPath())) * 0.000247105;
        return result.toFixed(4);
    }
}
class Circle {
    constructor(myMap,pos,kmRadius) {
        this.myField;                // holds the polygon we draw using drawing tools
        this.myMap = myMap;         // holds the map object drawn on the 
        this.color;    
        this.pos = pos;      
        this.kmRadius = kmRadius;      
        this.infowindow = new google.maps.InfoWindow({
            position:pos,
        });
    }
    SetColor(color){
        this.color = color;
    }
    DrawingTools() {
        var circle = new google.maps.Circle({
            fillColor: this.color,
            fillOpacity: 0.5,
            strokeWeight: 5,
            strokeColor: this.color,
            editable: false,
            draggable: false,
            map: this.myMap,
            center: this.pos,
            radius: this.kmRadius * 1000
        });

        this.myField = circle;
        this.FieldDrawingCompletionListener();
        
    }
    DrawField(){
        var circle = new google.maps.Circle({
            fillColor: this.color,
            fillOpacity: 0.5,
            strokeWeight: 5,
            strokeColor: this.color,
            editable: false,
            draggable: false,
            map: this.myMap,
            center: this.pos,
            radius: this.kmRadius * 1000
        });
        this.myField = circle;
        this.FieldDrawingCompletionListener(false);
    }

    FieldDrawingCompletionListener(editable = true) {
        this.FieldClickListener();
        this.FieldEditable(editable);

    }

    FieldClickListener() {
        google.maps.event.addListener(
            this.myField,
            'click',
            (event) => {
                // this.FieldEditable(true);
            }
        );
        google.maps.event.addListener(
            this.myField,
            'center_changed',
            (event) => {
                this.infowindow.close();
                this.FieldShowInfo();
            }
            );
            google.maps.event.addListener(
            this.myField,
            'radius_changed',
            (event) => {
                this.infowindow.close();
                this.FieldShowInfo();
            }
        );
    }
    FieldShowInfo(){
        var message = this.GetMessage(this.myField);
        var _myMap = this.myField.map;
        this.infowindow.setContent(message);
        const center = { lat: this.myField.getCenter().lat(), lng:  this.myField.getCenter().lng() };
        this.infowindow.open({
            anchor: marker,
            _myMap,
            shouldFocus: false,
        });
        this.infowindow.setPosition(center);
    }
    FieldEditable(val) {
        this.myField.setOptions({
            editable: val,
            // draggable: val
        });
        if (!val){
            this.infowindow.close();
        }
        return false;
    }

    GetMessage(circle) {
        var center = circle.getCenter();
        var radius = circle.getRadius();
        var message = '';

        message += '<div style="color:#555;font-size:16px;">Center : {' 
            + center.lat().toFixed(4)+ " , " + center.lng().toFixed(4) +'} </div>';

        var coordinateMessage = '<div style="color:#000;font-size:16px;">Radius : ';
        coordinateMessage += (radius/1000).toFixed(2) + "km ( " + (radius/1609).toFixed(2) + "miles )";
        coordinateMessage += '</div>';

        message += coordinateMessage;
        return message;
    }

    DeleteField() {
        if (typeof(this.myField) !== 'undefined'){
            this.infowindow.close();
            this.myField.setMap(null);
        }
    }

    GetArea(circle) {
        // var result = parseFloat(google.maps.geometry.spherical.computeArea(circle.getPath())) * 0.000247105;
        // return result.toFixed(4);
    }
}
