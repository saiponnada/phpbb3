<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
$(document).ready(function(){

	$("#page-body").css({
	display: "inline",
	"float":"left",
	width:"65%"
});

var query = <?php echo $topic_data['topic_id'] ?>;
var googleAPI = "https://www.googleapis.com/books/v1/volumes";


  $.ajax({
    url: googleAPI,
    data: {
    	q: query
    },
    dataType : "json",
    success: function( response ) {
    	console.log(query);
       var htmlStr = "<div><ul class='gBooksUL'><li><h3>Suggested Readings</h3></li>";
     for(var i=0; i<response.items.length;i++){
     	htmlStr += "<li class='gBooksLI'>Book Title: <i>" + response.items[i].volumeInfo.title + "</i><a href='" + response.items[i].volumeInfo.previewLink +"'>    Preview Link</a>" + "</li>";
     }
     htmlStr += "</ul></div>";
     $("#page-body").after(htmlStr);
    },
 
    error: function( xhr, status, errorThrown ) {
        alert( "Sorry, there was a problem!" );
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    },
 
    complete: function( xhr, status ) {
        $(".gBooksUL").css({
			"display": "inline",
			"float":"left",
			"list-style":"none",
			border: "1px black",
			margin: "10px",
			"padding-top": "100px"
		});

		$(".gBooksLI").css({
			"font-weight": "bold",
			"font-size": "14px"
		});

		$(".gBooksLI a").css({
			"font-weight": "normal",
			"font-size": "10px"
		});
    }
});




});
</script>