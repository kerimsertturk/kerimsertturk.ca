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
      margin: 3vw;
    }
    .info-div{
      float: right;
      min-width: 37vw;
      width: auto;
      min-height: 37vh;
      margin-top: 2vh;
      height: auto;
      background-color: #c4c4c4;
      border-radius: 30px;
    }
    .project-info{
      margin: auto;
      margin-top: 14vh;
      margin-left: 11vw;
      height: 90px !important;
      width: 220px !important;
      background-color: #6b6b6b !important;
      color: #21e6c1 !important;
      font-size: 17px !important;
    }
    .card-custom{
      float: right;
      min-width: 37vw;
      width: 37vw;
      min-height: 37vh;
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
      width: 55vw;
      min-width: 46vw;
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
       padding: 1.2vh 0;
       font-size: 15px;
     }
     .ordered_results_list li{
       list-style-type: decimal;
       margin-left: 15px;
       margin-right: 30px;
       color: white;
       padding: 1.8vh 0;
       font-size: 15px;
     }
     .synonyms-list li{
       list-style-type: disc;
       margin-left: 25px;
       margin-right: 30px;
       color: white;
       font-size: 15px;
       /* line-height: 2.5vh; */
       padding: 1.6vh 0;
     }
     .nature, .search_results_list p{
       color: #abb0b8;
       font-style: italic;
       margin-left: 40px;
     }
     .expression-result{
       margin-left: 20px;
       margin-right: 30px;
       color: white;
       padding: 0 0;
       line-height: 1.35em;
     }
     .space-div{
       height: 4vh;
     }
     .error-msg{
       color: #bed2fa;
       font-size: 23px;
       margin:auto;
       margin-top: 18vh !important;
       line-height: 2em;
     }
     .info-modal-text{
       /* font-size: 16px; */
       line-height: 1.80em;
     }
     @media (max-width: 1110px){
      .card-custom{
        width: 90vw;
        min-height: 30vh;
        float:none;
       }
       .card-wrapper{
         margin-left: 3vw;
       }
      .info-search-wrapper{
         width: 90vw;
         min-height: 45vh;
         margin-bottom: 2vh;
       }
       .info-div{
         float: none;
         width: 90vw;
         min-height: 20vh;
         margin-top:1vh;
       }
       .project-info{
         margin: auto;
         margin-top: 0;
         margin-left: 30vw;
         margin-top: 6vh;
       }
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
       <input class="french-api-btn btn z-depth-4" type="submit" name="definition" value="definitions" onclick="fetch_def(); return false;"/>
       <input class="french-api-btn btn z-depth-4" type="submit" name="expressions" value="expressions" onclick="fetch_exp(); return false;"/>
       <input class="french-api-btn btn z-depth-4" type="submit" name="synonyms" value="synonymes" onclick="fetch_syn(); return false;"/>
      <div class="search-output" id="search-output">
        <p class="results_title" id="results-title"></p>
        <p class="nature" id="nature"></p>
        <p class="expression-result" id="expression-result"></p>
        <ul class="search_results_list" id="results-list"></ul>
        <ol class="ordered_results_list" id="ordered_results_list"></ol>
        <ol class="synonyms-list" id="synonyms-list"></ol>
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

    <div class="info-div">
      <button class="project-info btn modal-trigger z-depth-3 waves-effect waves-light" href="#info_modal">project info</button>
    </div>
  </div>

  <div class="modal" id="info_modal">
    <div class="info-modal-text modal-content">
      <h5><b>Background Information</b></h5>
        <p>There are many translation engines for foreign language learners, but the main issue that I also frequently
          experience is not knowing what to search. Learners need a separate text source and often struggle juggling between
          the text and various translation apps. This project aims to eliminate the need for a separate source to
          learn new vocabulary by providing a <strong>french quote generator and a linguistic dashboard </strong>
          all on the same page.</p>
          <p>The project aims to demonstrate knowledge of <strong> JavaScript (fetch, jQuery) and REST API. </strong></p>
        <p>The code is publicly available at <a href="https://github.com/kerimsertturk/kerimsertturk.ca">my github repo.</a></p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close blue btn-flat white-text" style="margin-right: 20px;">Close</a>
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

  async function getdata(){
    await getresponse(quotes_url, quotes_host, rapidapi_key)
    .then(data => {
      let quote = data.content;
      let author = data.originator.name;
      if (quote.length > 390){
        fetch_invoked_too_long();
      }
      else{
        document.getElementById("card-quote").innerHTML=quote;
        document.getElementById("card-author").innerHTML=author;
      }
    })
    .catch(err => console.log(err));
    }
    getdata();
    var fetch_interval = 3600000; // fetch new every hour normal conditions
    setInterval(getdata,fetch_interval);

    function fetch_invoked_too_long(){
      setTimeout(getdata,1200) //try to fetch another in a second if too long
    }

  var error_p = document.createElement("P");
  error_p.className = "error-msg";
  var title = document.getElementById("results-title");
  var results_list =  document.getElementById("results-list");
  var nature = document.getElementById("nature");
  var ordered_list = document.getElementById("ordered_results_list");
  var dico_host = "dicolink.p.rapidapi.com";
  var dico_fetch_url_stem = "https://dicolink.p.rapidapi.com/mot/";
  var expressions = document.getElementById("expression-result");
  var synonyms = document.getElementById("synonyms-list");

  function error404_msg(){
    title.innerHTML = "";
    error_p.appendChild(document.createTextNode("404 NOT FOUND"));
    const br = document.createElement("BR");
    error_p.appendChild(br);
    error_p.appendChild(document.createTextNode("Make sure not to use special characters such as '!?%&^$*@#_")); // invalid multiple words error
    title.appendChild(error_p);
  }

  function nosuchword_error(){
    title.innerHTML = "";
    error_p.appendChild(document.createTextNode("Can't find the searched word!"));
    const br = document.createElement("BR");
    error_p.appendChild(br);
    error_p.appendChild(document.createTextNode("Make sure there are no typos or try another conjugation"));
    title.appendChild(error_p);
  }

  function preprocess_and_call_fetch(get_type, getdata_api_function){
    // clear html of result fields
    results_list.innerHTML = "";
    title.innerHTML = "";
    error_p.innerHTML = "";
    nature.innerHTML = "";
    ordered_list.innerHTML = "";
    expressions.innerHTML = "";
    synonyms.innerHTML = "";

    const searched_word = document.getElementById('search-word').value.toString(); // obtain searched word
    const word_length = searched_word.split(' ').length; // length of searched word
    if(word_length != 1){
     error_p.appendChild(document.createTextNode("Only a single word without spaces can be searched!")); // invalid multiple words error
     title.appendChild(error_p);
    }
    else{
     title.innerHTML = get_type + " pour " + "\""+ searched_word + "\"";
     getdata_api_function(searched_word);
    }
  }

  async function getdata_citation(word){
    const lim_num = 5;
    const dico_cit_url = dico_fetch_url_stem + word + "/citations?limite=" + lim_num.toString();
    await getresponse(dico_cit_url, dico_host, rapidapi_key)
    .then(data => {
     if (data == "404"){
       error404_msg()
     }
     else{
       if (data.error){
         nosuchword_error()
       }
       else {
         for (var i = 0; i < lim_num; i++){
           const citation = data[i].citation.toString();
           const author = data[i].auteur.toString();
           const cit_li_entry = document.createElement("LI");
           cit_li_entry.appendChild(document.createTextNode(citation));
           results_list.appendChild(cit_li_entry);
           const cit_p_author = document.createElement("P");
           cit_p_author.appendChild(document.createTextNode(author));
           results_list.appendChild(cit_p_author);
           }
         }
       }
     })
    .catch(err => console.log(err));
  }

  async function getdata_definition(word){
    const dico_def_url = dico_fetch_url_stem + word + "/definitions"
    await getresponse(dico_def_url, dico_host, rapidapi_key)
    .then(data => {
     if (data == "404"){
       error404_msg()
     }
     else{
       if (data.error){
         nosuchword_error()
       }
       else {
         const display_limit = 3;
         // nature
         const nature_word = data[0].nature.toString();
         const nature_p = document.createElement("P");
         nature_p.appendChild(document.createTextNode(nature_word));
         nature.appendChild(nature_p);
         for (var i = 0; i < display_limit; i++){
           // definition
           const def = data[i].definition.toString();
           // console.log(def);
           const def_li_entry = document.createElement("LI");
           def_li_entry.appendChild(document.createTextNode(def));
           ordered_list.appendChild(def_li_entry);
           }
         }
       }
     })
    .catch(err => console.log(err));
  }

  async function getdata_expressions(word){
    const lim_num = 3;
    const dico_exp_url = dico_fetch_url_stem + word + "/expressions?limite=" + lim_num.toString();
    await getresponse(dico_exp_url, dico_host, rapidapi_key)
    .then(data => {
     if (data == "404"){
       error404_msg()
     }
     else{
       if (data.error){
         nosuchword_error()
       }
       else {
         console.log(data);
         for (var i = 0; i < lim_num; i++){
           // expression and semantique
           const expr = data[i].expression.toString();
           const sem = data[i].semantique.toString();

           const expr_p = document.createElement("P");
           expr_p.appendChild(document.createTextNode("Expression: " + expr));
           expressions.appendChild(expr_p);
           const sem_p = document.createElement("P");
           sem_p.appendChild(document.createTextNode("Semantique: " + sem));
           expressions.appendChild(sem_p);
           const space = document.createElement("DIV");
           space.className = "space-div";
           expressions.appendChild(space);
           }
         }
       }
     })
    .catch(err => console.log(err));
  }
  async function getdata_synonyms(word){
    const lim_num = 5;
    const dico_syn_url = dico_fetch_url_stem + word + "/synonymes?limite=" + lim_num.toString();
    await getresponse(dico_syn_url, dico_host, rapidapi_key)
    .then(data => {
     if (data == "404"){
       error404_msg()
     }
     else{
       if (data.error){
         nosuchword_error()
       }
       else {
         console.log(data);
         for (var i = 0; i < lim_num; i++){
           // synonyms
           const mot = data[i].mot.toString();
           const syn_li = document.createElement("LI");
           syn_li.appendChild(document.createTextNode(mot));
           synonyms.appendChild(syn_li);
           }
         }
       }
     })
    .catch(err => console.log(err));
  }

  function fetch_cit(){
   preprocess_and_call_fetch("Citations", getdata_citation)
   }

  function fetch_def(){
   preprocess_and_call_fetch("Definitions", getdata_definition)
  }

  function fetch_exp(){
   preprocess_and_call_fetch("Expressions", getdata_expressions)
  }

  function fetch_syn(){
   preprocess_and_call_fetch("Synonymes", getdata_synonyms)
  }

  $(document).ready(function(){
  $('.modal').modal({
    'opacity': 0.6
    });
  });
</script>
</main>

<?php include('footer.html'); ?>
</html>
