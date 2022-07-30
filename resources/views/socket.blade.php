<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
    integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div id="messages"></div>
        </div>
    </div>
</div>
<script>
    const socket = io("http://localhost:8890");
    socket.on('chat', function(data) {
        console.log(data)
        $("#messages").append("<p>" + data + "</p>");
    });
</script>
