<!DOCTYPE html>
<html>
	<?php include('navbar.php'); ?>
	<?php include('materialize.php');

	?>
	<head>
		<style type="text/css">
			/* text on hover */
				.tabs .tab a.active{
					background-color: transparent !important;
				}
				/* underline */
				.tabs .indicator {
					background-color:#808080 !important;
				}
				.about{
					background-color: transparent;
					margin-top: 50px;
					height:300px;
					margin-bottom: 40px;
				}

				.about-text-wrapper{
					background-color: transparent;
					display: inline-block;
					float:left;
					padding-left: 50px;
					margin-bottom:30px;
					width: 60%;
					height: 100%;
					line-height: 1.68em;
				}

				.about-text{
					position:relative;
					word-wrap: break-word;
				}
				.img-div{
					float: right;
					width: 300px;
					margin-top:40px;
					margin-right: 70px;
				}
				.linkedin-pic{
					width: 300px;
					display: inline-block;
				}
				.tabs-list{
					margin-left:50px;
					line-height: 1.75em;
				}
				ul.tabs-list li{
				list-style-type: disc !important;
				}
				.about-tabs{
					display: inline-block;
					background-color: transparent;
				}
				@media (max-width: 1340px){
					.about-text-wrapper{
						width:100%;
						margin-bottom: 40px;
					}
					.img-div{
						float:none;
						margin-right:0;
						margin-top:40px !important;
						display: block;
						margin:auto;
						}
				}
				@media (max-width: 590px){
					.about-text-wrapper{
						margin-bottom: 90px;
				} }
		</style>
	</head>

  <main>
    <div class="container">
			<div class="img-div">
				<img class="linkedin-pic" src="https://i.imgur.com/cCMgaKO.jpg">
			</div>
			<div class="about">
				<div class="about-text-wrapper">
					<span id="about-text"><h5> Hello! </h5> <br> My name is Kerim Sertturk. I recently graduated with a major in Electrical Engineering
						from the University of British Columbia.
						<p>I am looking to start work between June and September 2020, preferably either in Vancouver or Toronto.
						I am best suited for roles in <b>data analytics, machine learning applications and back-end development.</b></p>
						<p>I have previously worked remotely with my capstone client, so I am familiar with most remote access tools which may
						be required due to COVID-19.</p>
						<p>You can download my resume <a href="https://github.com/kerimsertturk/kerimsertturk.ca/raw/master/Resume_Kerim_Sertturk_05_08_2020.pdf">here</a>
						 which has my contact information too.</p>
					</span>
				</div>

			</div>

     <div class="row">
			 <div class="blue-text text-darken-4">
			 		<h4>I have experience in ...</h4>
			 </div>
      <div class="about-tabs col s12 l8 offset-l4">
        <ul class="tabs">
          <li class="tab col s4">
            <a href="#ml" class="active blue-text text-darken-3">ML</a>
          </li>
          <li class="tab col s4">
            <a href="#webdesign" class="active blue-text text-darken-3">Web Dev</a>
          </li>
          <li class="tab col s4">
            <a href="#electrical" class="active blue-text text-darken-3">EE</a>
          </li>
        </ul>
        <div id="ml" class="col s12">
            <h5 class="flow-text blue-text text-darken-3">Machine Learning</h5>
            <p>In my capstone project I applied:</p>
							<ul class="tabs-list">
								<li>CNNs</li>
								<li>Object Detection (YOLO)</li>
								<li>Semantic Segmentation (u-Net architecture)</li>
								<li>Focal Loss</li>
								<li>F1 Score</li>
							</ul>
						<p>Through personal research, I have gained conceptual familiarity with: </p>
							<ul class="tabs-list">
								<li>Regression, Random Forests and Unsupervised Classification </li>
								<li>Principle Component Analysis, Overfitting</li>
								<li>Natural Language Processing (NLP)</li>
								<li>Recommender Systems</li>
							</ul>
        </div>
        <div id="webdesign" class="col s12">
            <h5 class="flow-text blue-text text-darken-3">Web Design</h5>
						<p>The development of this website improved my knowledge of:
							<ul class="tabs-list">
								<li>PHP (with PDO)</li>
	            	<li>HTML/CSS</li>
								<li>jQuery</li>
								<li>SQL</li>
								<li>Python</li>
	            </ul>
							<p>as well as database management fundamentals such as:</p>
							<ul class="tabs-list">
								<li>ETL</li>
	            	<li>CRUD</li>
								<li>HTTP request methods</li>
								<li>Security</li>
								<li>Logging</li>
	            </ul>

        </div>
        <div id="electrical" class="col s12">
            <h5 class="flow-text blue-text text-darken-3">Electrical Engineering</h5>
						<p>During my undergraduate degree I have taken courses and participated in projects involving: </p>
            <ul class="tabs-list">
							<li>power systems analysis</li>
							<li>electrical design / CAD</li>
            	<li>microcontrollers</li>
							<li>circuits</li>
							<li>FPGAs & hardware description language</li>
							<li>motors</li>
            </ul>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
    $('.tabs').tabs({
      'swipeable': true
    });
    });
  </script>

  </main>
	<?php include('footer.html'); ?>


</html>
