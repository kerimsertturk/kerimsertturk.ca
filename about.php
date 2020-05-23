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
					padding-top: 20px;
					width: 60%;
					height: 100%;
				}

				.about-text{
					position:relative;
					word-wrap: break-word;
				}
				.img-div{
					float: right;
					margin-right: 70px;
				}
				.linkedin-pic{
					width: auto;
					height: 260px;
					display: inline-block;
				}
				ul.tabs-list li{
				list-style-type: lower-greek !important;
				}
				.about-tabs{
					display: inline-block;
					background-color: transparent;
				}
				@media (max-width: 1300px){
					.about-text-wrapper{
						width:100%;
						height: 80%;
						margin-bottom: 50px;
				} }
				@media (max-width: 530px){
					.about-text-wrapper{
						margin-bottom: 65px;
				} }
		</style>
	</head>

  <main>
    <div class="container">
			<div class="about">
				<div class="img-div">
					<img class="linkedin-pic" src="https://i.imgur.com/cCMgaKO.jpg">
				</div>
				<div class="about-text-wrapper">
					<span id="about-text"><p> Hi! <br><br> My name is Kerim Sertturk. I am an Electrical Engineering
						student set to graduate from University of British Columbia at the end of May 2020.
						I am looking to start work between June and September 2020, preferably either in Vancouver or Toronto. </p>
						<p>I have previously worked remotely with my capstone client, so I am familiar with most remote access tools that may
						be required due to COVID-19.</p>
					<p>You can download my resume <a href="#">here</a></p>
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
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum at lacus congue, suscipit elit nec, tincidunt orci.</p>
            <p>Mauris dolor augue, vulputate in pharetra ac, facilisis nec libero. Fusce condimentum gravida urna, vitae scelerisque erat ornare nec.</p>
        </div>
        <div id="webdesign" class="col s12">
            <h5 class="flow-text blue-text text-darken-3">Web Design</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum at lacus congue, suscipit elit nec, tincidunt orci.</p>
            <p>Mauris dolor augue, vulputate in pharetra ac, facilisis nec libero. Fusce condimentum gravida urna, vitae scelerisque erat ornare nec.</p>
        </div>
        <div id="electrical" class="col s12">
            <h5 class="flow-text blue-text text-darken-3">Electrical Engineering</h5>
						<p></p>
            <ul class="tabs-list" style="padding-left:20px;">
							<li>power systems analysis</li>
            	<li>microcontrollers</li>
							<li>circuits</li>
							<li>hardware description language</li>
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
