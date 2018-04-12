script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.4.0/lodash.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript" ></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
// jQuery(window).load(function () {
   

  FB.init({
    appId      : 'XXXXXXXXXXXXXX',
    status     : true,
    xfbml      : true,
    version    : 'v2.7'
  })
  access_token = 'YOUR_ACCESS_TOKEN';
  


  // Replace the id by any other public page id


FB.api(
  '/BookMyShowIN',
  'GET',
  {"fields":"id,name,fan_count"},{access_token}, function(response) {
    var page_id = response.id + '/feed'; 
    FB.api(page_id,  { access_token }, function(result) {
    $(result.data).each(function(index, posts) {
    var Messages = (posts.message)?posts.message:'';
    var words = ['ballet', 'exciting','tickets','book','event','amazing','life','Onlybot']; //this is where you specify the keywords you want to match
    for(i = 0; i < words.length; i++){
        var pattern = new RegExp(words[i],'i');
        if (pattern.test(Messages) != false) {
            var MatchedIDs = posts.id;
              FB.api(
                  '/' + MatchedIDs+'/comments?comments.limit(100)',
                  'GET',
                  {access_token},
                  function(response){
                    if(response.data.length >= 25){
                        console.log(response);
                        console.log(response.paging.next);
                    }
                  }
                );
        }
      }
    })
  })
});
