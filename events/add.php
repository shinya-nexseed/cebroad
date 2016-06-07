<?php


 ?>
<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&output?json&region=ph&language=en&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8"></script>
<h1>New event</h1>
<div class="container">
    <form action="/cebroad/events/confirm.php" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Date,Time</label>
            <input type="datetime-local" name="time" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Place</label>
            <input id="searchTextField" type="text" name="place" class="form-control" required>
        </div>

        <div class="form-group">
            <label>detail</label>
            <textarea name="detail" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Picture1</label>
            <input type="file" name="pic1">
        </div>

        <div class="form-group">
            <label>Picture2</label>
            <input type="file" name="pic2">
        </div>

        <div class="form-group">
            <label>Picture3</label>
            <input type="file" name="pic3">
        </div>


        <input id=place_name type="hidden" name="place_name" value="">
        <input id=lat type="hidden" name="lat" value="">
        <input id=lng type="hidden" name="lng" value="">

        <div class="form-group">
            <button type="submit">confirm</button>
        </div>
    </form>
</div>


<script>
function initialize() {
    var input = document.getElementById('searchTextField');
    var options = {
        componentRestrictions: {country: 'ph'}
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.getElementById('place_name').value = place.name;
        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('lng').value = place.geometry.location.lng();

        });
}
google.maps.event.addDomListener(window, 'load', initialize);

</script>




<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en&region=ph"></script> -->

<!-- <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en"></script> -->

<script src="../webroot/assets/js/jquery-1.12.4.min.js"></script>
<!-- <script src="../webroot/assets/js/gmap.js"></script> -->


<script src="../webroot/assets/js/bootstrap.js"></script>