<?php
/**
 * Dev: Amit Kumar
 * Date: 3/14/18
 * Time: 10:13 PM
 */

class facebookautopost
{
    private $page_access_token = "YOUR_PAGE_ACCESS_TOKEN";
    private $page_name = "Innovate1992"; //name of the page you want to crawl
    private $page_response;
    private $comment_response;
    public function getPageFeed(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v2.9/$this->page_name/posts?access_token=$this->page_access_token&limit=25",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $this->page_response =  json_decode($response);
            $this->getCommentIds();
        }
    }

    public function getCommentIds(){
        foreach ($this->page_response->data as $key=>$value){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://graph.facebook.com/v2.12/$value->id/comments?access_token={YOUR_PAGE_ACCESS_TOKEN}&limit=1000",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: 34b4ae35-a762-62fc-d326-f1eb5f6225f4"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $this->comment_response = json_decode($response);
                $this->matchCommentsWithWords();
            }
        }
    }
    public function matchCommentsWithWords(){

        foreach ($this->comment_response->data as $key=>$value) {
            $comment_messages[] = $value;
            foreach ($comment_messages as $results) {
                $commentID = array();
                $expression = '/true/i'; 
                $expression2 = '/comment/i';
                //$expression and $expression2 are the two words you want to look up for.
                if (preg_match($expression, $results->message) or preg_match($expression2, $results->message)) {
                    if (!in_array($results->id, $commentID)) {
                        $commentID[] = $results->id;
                    }
                }
            }
            foreach ($commentID as $value) {
                $url = "https://graph.facebook.com/v2.12/$value/comments?access_token=$this->page_access_token&limit=1000";
                $attachment =  array(
                    'access_token'  => $this->page_access_token,
                    'message'       => "Hello !!!for the love of giff's https://gph.is/14Ja5a5"
                );

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $attachment,
                    CURLOPT_HTTPHEADER => array(
                        "Cache-Control: no-cache",
                        "content-type: multipart/form-data;"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }
            }
        }
    }
}

