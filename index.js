script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.4.0/lodash.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript" ></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
// jQuery(window).load(function () {
   

  FB.init({
    appId      : '569045470119197',
    status     : true,
    xfbml      : true,
    version    : 'v2.7'
  })
  access_token = 'EAAIFizkbhR0BAK4FtK8F0G51YCPQxAAJVYtGXuwc1XEm83YAmrTuIDngfd0SOIMXQ0x6VURiqFqZCiCnWSv477xOZBw2L86HXOFF2ZAtiWbr1Pcfiz1TkWsekzdcgN7m1QeTV85XPQnnPdZCibv8kIDaFp6NDGzLFXK4OO2nMgZDZD';
  


  // Replace the id by any other public page id


FB.api(
  '/BookMyShowIN',
  'GET',
  {"fields":"id,name,fan_count"},{access_token}, function(response) {
    var page_id = response.id + '/feed'; 
    FB.api(page_id,  { access_token }, function(result) {
    $(result.data).each(function(index, posts) {
    var Messages = (posts.message)?posts.message:'';
    var words = ['ballet', 'exciting','tickets','book','event','amazing','life','Onlybot'];
    for(i = 0; i < words.length; i++){
        var pattern = new RegExp(words[i],'i');
        if (pattern.test(Messages) != false) {
            var MatchedIDs = posts.id;
            //console.log(MatchedIDs);
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