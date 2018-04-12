# Facebook-autoPostPages

# Introduction
A Javascript to crawl through the specified facebook page and look for the keywords given. If found it automatically replies to the comment. There can me n number of keywords. The script first calls through all the comments on the first 25 posts in a cronological order.

# Prerequsites
You have to generate a page access token (non-expiring) as the normal token expires in 15 minuites. To generate an access-token visit [`Facebook Developer console`][LINK].

# Future enhancments
This script will be fully automated where you dont have to pass pages one at a time. you can send a json file with page names and keywords you are looking in those pages.

# Issues
There is one more issue that is that if the same message is posted more than 11 times facebook treates it as an spam. This issue is fixed and will pe updated by this weekend.



[LINK]: https://developers.facebook.com
