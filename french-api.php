<?php
include('materialize.php');
include('navbar.php');
include("pdo.php");
?>
<html>
<head>
  <style type="text/css">
    .card-wrapper{
      margin-top:2% !important;
      margin: 80px;
    }
    .card-custom{
      float: right;
      min-width: 37vw;
      width: auto;
      min-height: 30vh;
      height: auto;
      border-radius: 30px !important;
      overflow: hidden;
      /* background-color: #071e3d !important; /* navy */
      background-color: #220666 !important; /* purple */
    }
    .card-content blockquote {
      line-height: 1.68em;
      font-size: 17px;
      border-left: 5px solid #a7ff83;
    }
    .card-author{
      font-style: italic;
    }
    .card-action a{
      color: #21e6c1 !important;
      font-weight: bold;
      letter-spacing: 1.3px;
    }
    .info-search-wrapper{
      background-color: #132a4a;
      display: inline-block;
      float: left;
      width: 50vw;
      height: auto;
      min-height: 75vh;
      border-radius: 30px;
    }

    .french-api-btn{
      min-width: 15%;
      height: 50px !important;
      margin-left: 5%;
      margin-right: 4%;
      margin-top: 15px;
      background-color: #17355e !important;
      color: #21e6c1 !important;
      font-size: 17px !important;
      /* border: 0.25px solid white !important; */
    }
    .input-field{
      margin: 35px;
      margin-top: 50px !important;
    }
    .input-field .prefix.active {
     color: white !important;
    }
    .input-field label{
      color: white !important;
    }
     .input-field input:focus{
     color: white !important;
     border-bottom: 1px solid white !important;
     box-shadow: 0 1px 0 0 white !important;
     }
     .input-field input {
       color: white !important;
     }
     .search-output{
       height: auto;
       min-height: 50vh;
       width: 90%;
       margin: 5%;
       margin-top: 2% !important;
       /* background-color: #b0bec5; */
       border: 1.5px solid white;
       border-radius: 24px;
     }
     .results_title{
       font-size: 20px;
       margin: 20px;
       color: #1ff0c9;
       text-align: center;
     }
     .search_results_list li{
       margin-left: 15px;
       margin-right: 6px;
       color: white;
       line-height: 5vh;
       font-size: 15px;
       /* list-style-type: disc; */
     }
     .search_results_list p{
       color: #abb0b8;
       font-style: italic;
       margin-left: 40px;
     }
     .error-msg{
       color: #bed2fa;
       font-size: 23px;
       margin:auto;
       margin-top: 18vh !important;
       line-height: 2em;
     }

  </style>
</head>

<main>
  <div class="card-wrapper">
    <div class="info-search-wrapper">
        <div class="input-field">
          <i class="material-icons prefix" style="color: white;">search</i>
          <input id="search-word" type="text" name="search_word">
       </div>
       <input class="french-api-btn btn z-depth-4" type="submit" name="citations" value="citations" onclick="fetch_cit(); return false;"/>
       <input class="french-api-btn btn z-depth-4" type="submit" name="definition" value="definition" onclick="fetch_def(); return false;"/>
       <input class="french-api-btn btn z-depth-4" type="submit" name="expressions" value="expressions" onclick="fetch_exp(); return false;"/>
       <input class="french-api-btn btn z-depth-4" type="submit" name="synonyms" value="synonyms" onclick="fetch_syn(); return false;"/>
      <div class="search-output" id="search-output">
        <p class="results_title" id="results-title"></p>
        <ul class="search_results_list" id="results-list"></ul>

      </div>
    </div>

    <div class="card-custom card hoverable" id="quote-card-custom">
      <div class="card-content white-text">
        <span class="card-title" style="color: #21e6c1;">Quote of the Day</span>
        <blockquote id="card-quote">...loading...</blockquote>
        <p class="card-author" id="card-author"></p>
        <p class="quote-translate" id="quote-translate"></p>
      </div>
      <div class="card-action">
        <a onClick="getdata(); return false;" href="#!">GET ANOTHER</a>
      </div>
    </div>
  </div>

<script type="text/javascript">
  async function getresponse(url,rapid_host,rapid_key){
    const response = await fetch(url, {
      "method": "GET",
      "headers": {
        "x-rapidapi-host": rapid_host,
        "x-rapidapi-key": rapid_key
          }
      })
      if (response.status >= 200 && response.status < 300){
        return await response.json();
      }
      else{
        var flag_404 = "404";
        console.log("404")
        return flag_404;
      }
    }
  const quotes_url = "https://quotes15.p.rapidapi.com/quotes/random/?language_code=fr";
  const quotes_host = "quotes15.p.rapidapi.com";
  const rapidapi_key = "85404dcb84mshc82034ba294896cp180b7djsnd164c6f20ef7";

  // async function getdata(){
  //   await getresponse(quotes_url, quotes_host, rapidapi_key)
  //   .then(data => {
  //     let quote = data.content;
  //     let author = data.originator.name;
  //     if (quote.length > 350){
  //       fetch_invoked_too_long();
  //     }
  //     else{
  //       document.getElementById("card-quote").innerHTML=quote;
  //       document.getElementById("card-author").innerHTML=author;
  //     }
  //   })
  //   .catch(err => console.log(err));
  //   }
  //   getdata();
  //   var fetch_interval = 3600000; // fetch new every hour normal conditions
  //   setInterval(getdata,fetch_interval);
  //
  //   function fetch_invoked_too_long(){
  //     setTimeout(getdata,1200) //try to fetch another in a second if too long
  //   }

  // function return_title (dicolink_type, search_word){
  //   if (search_word.toString().trim().length == 0){
  //     var title_string = "... please type the word ...";
  //   }
  //   else if(search_word.trim().length > 1 ){
  //     var title_string = "you can only search one word"
  //   }
  //   else{
  //     var title_string = dicolink_type + " for " + search_word;
  //   }
  //   return title_string;
  // }
  var error_p = document.createElement("P");
  error_p.className = "error-msg";
  var title = document.getElementById("results-title");
  var results_list =  document.getElementById("results-list");

  function error404_msg(){
    title.innerHTML = "";
    error_p.appendChild(document.createTextNode("404 NOT FOUND"));
    const br = document.createElement("BR");
    error_p.appendChild(br);
    error_p.appendChild(document.createTextNode("Make sure not to use special characters such as '!?%&^$*@#_")); // invalid multiple words error
    title.appendChild(error_p);
  }

  const dico_host = "dicolink.p.rapidapi.com";
  function fetch_cit(){
    // clear title
   results_list.innerHTML = "";
   title.innerHTML = "";
   error_p.innerHTML = "";
   // create error element

   const get_type = "Citations";
   const searched_word = document.getElementById('search-word').value.toString();
   const word_length = searched_word.split(' ').length;
   // check if multiple words searched
   if(word_length != 1){
    error_p.appendChild(document.createTextNode("Only a single word without spaces can be searched!")); // invalid multiple words error
    title.appendChild(error_p);
   }
   else{
    title.innerHTML = get_type + " for " + "\""+ searched_word + "\""; // valid search title
    // FETCH
    var lim_num = 5;
    const dico_cit_url = "https://dicolink.p.rapidapi.com/mot/" + searched_word + "/citations?limite=" + lim_num.toString();
    async function getdata_citdico(){
     await getresponse(dico_cit_url, dico_host, rapidapi_key)
     .then(data => {
       // console.log(data);
       if (data == "404"){
         error404_msg()
       }
       else{
         if (data.error){
           title.innerHTML = "";
           error_p.appendChild(document.createTextNode("Can't find the searched word!"));
           const br = document.createElement("BR");
           error_p.appendChild(br);
           error_p.appendChild(document.createTextNode("Make sure there are no typos or try another conjugation"));
           title.appendChild(error_p);
         }
         else {
           for (var i = 0; i < lim_num; i++){
             const citation = data[i].citation.toString();
             const author = data[i].auteur.toString();
             console.log(citation);
             const cit_li_entry = document.createElement("LI");
             cit_li_entry.appendChild(document.createTextNode(citation));
             document.getElementById("results-list").appendChild(cit_li_entry);
             const cit_p_author = document.createElement("P");
             cit_p_author.appendChild(document.createTextNode(author));
             document.getElementById("results-list").appendChild(cit_p_author);
             }
           }
         }
       })
     .catch(err => console.log(err));
       }
    getdata_citdico()
    }
  }

  function fetch_def(){
   const get_type = "Definiton";
   document.getElementById("results-title").innerHTML=check_empty_title(get_type);
  }
  function fetch_exp(){
   const get_type = "Expressions";
   document.getElementById("results-title").innerHTML=check_empty_title(get_type);
  }
  function fetch_syn(){
   const get_type = "Synonyms";
   document.getElementById("results-title").innerHTML=check_empty_title(get_type);
  }

</script>
</main>

<?php include('footer.html'); ?>
</html>
