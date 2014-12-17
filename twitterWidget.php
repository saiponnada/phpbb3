<link rel="stylesheet" type="text/css" href="tolc/styles.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
var course;
	$(document).ready(function() {
		course = $("#page-body h2 a").html();
		 var url = window.location.href + "&course="+course;
		if($.urlParam('course')==null){
			console.log("check Browser");
			$(location).attr('href',url);
		}
		//console.log($.urlParam('course'));
		var html = "<div id='rightPanel'></div>";
		$(html).insertAfter( "#page-body" );
	});
	
	$.urlParam = function(name){
	    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	    if (results==null){
	       return null;
	    }
	    else{
	       return results[1] || 0;
	}
}
</script>

<?php
	# hide Errors
	error_reporting(0);
	ini_set('display_errors', 0);
	
	#to display Errors
	#error_reporting(E_ALL);
	#ini_set('display_errors', 1);
	
	require_once('TwitterAPIExchange.php');
	/** **/
	$screenName = '';
	$course = $_GET['course'];
	$list = str_replace(" ","-",$course);
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	/*For security, Keys were not displayed*/
	$settings = array(
	    'oauth_access_token' => "",
	    'oauth_access_token_secret' => "",
	    'consumer_key' => "",
	    'consumer_secret' => ""
	);

	$consumer="";
	$consumersecret="";
	$accesstoken="";
	$accesstokensecret="";
	//https://api.twitter.com/1.1/statuses/user_timeline.json
	$url='https://api.twitter.com/1.1/lists/statuses.json';
	
	$getfield = '?slug='.$list.'&owner_screen_name='.$screenName;
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$response = $twitter->setGetfield($getfield)
	           			->buildOauth($url, $requestMethod)
	             		->performRequest();
?>
<script type="text/javascript">
	$(document).ready(function() {
		processTwitterJson();
		processUdacity();
		processGoogleBooks();
	});
	function processTwitterJson(){
		
		var totalTweets = "";
		var jsonObj = <?php echo $response;?>;
		if(jsonObj.length!= undefined){
				for(key in jsonObj) {
				var text = jsonObj[key].text;
				var length = jsonObj[key].entities.urls.length;
				var user= {
					"name" : jsonObj[key].user.name,
					"nickName" : jsonObj[key].user.screen_name,
					"userUrl" : "https://twitter.com/" +jsonObj[key].user.screen_name,
					"userImg" : jsonObj[key].user.profile_image_url
				};
				var text;
				if(length ==1){
					var link = jsonObj[key].entities.urls[0].url;
					text = text.replace(link, "<a target='_blank' href='"+ link +"'>" + link + "</a>");
				}
				totalTweets += "<li><div class='profileHeader'><a class='aprofile' target='_blank' href='"+ user["userUrl"] +"'>";
				totalTweets += "<img class='avatar' height='48px' width='48px' alt='"+user["name"]+"' src='"+ user["userImg"] +"' />";
				totalTweets += "<span class='fullName'>"+user["name"]+"</span>&nbsp;&nbsp;&nbsp;";
				totalTweets += "<span class='nickName'>@<b>"+user["nickName"]+"</b></span></a></div>";
				totalTweets += "<div class='textTweet'>"; 
				totalTweets +=  text;
				totalTweets += "</div></li>";
			}
			$('#rightPanel').append("<div id='tweetsHeader'><h2 class='headerStyle'>Tweets from Experts</h2></div><div id='twitterAPI'><ol id='tweets'></ol></div>");
			var list = document.getElementById("tweets");
			list.innerHTML = totalTweets;
		}
		
		
	}
	function processUdacity(){
		var courseID = '#'+ course.replace(" ","_");
		$('#rightPanel').append($("#udacityCourses").find(courseID).html());
	}
	function processGoogleBooks(){
		var googleAPI = "https://www.googleapis.com/books/v1/volumes";
		$.ajax({
		    	url: googleAPI,
		    data: {
		    	q: course
		    },
		    dataType : "json",
		    success: function( response ) {
		         var htmlStr = "<div class='booksHeader'><h2 class='headerStyle'>Suggested Readings</h2></div><div><ul class='gBooksUL'>";
			     for(var i=0; i<response.items.length;i++){
			     	htmlStr += "<li class='gBooksLI'><a target='_blank' href='" + response.items[i].volumeInfo.previewLink +"'>"+ response.items[i].volumeInfo.title + "</a></li>";
			     }
			     htmlStr += "</ul></div></div>";
			     $('#rightPanel').append(htmlStr);
		    },
		 
		    error: function( xhr, status, errorThrown ) {
		        alert( "Sorry, there was a problem!" );
		        console.log( "Error: " + errorThrown );
		        console.log( "Status: " + status );
		        console.dir( xhr );
		    },
		 
		    complete: function( xhr, status ) {
		    }
		});
	}		
</script>
