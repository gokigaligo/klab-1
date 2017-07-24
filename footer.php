
<!-- Footer Start -->

<div class="footer padd" style="color: #c35a26; background-color: #251d1a;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1 col-sm-3"></div>
			<div class="col-md-3 col-sm-5">
				<!-- Footer widget -->
				<div class="footer-widget">
					<!-- Logo area -->
					<div class="logo">
						<a href="index"><img class="img-responsive" src="img/kLab_stamp.jpg" alt="">
						<!-- Heading -->
						<h1>KCafe</h1></a>
					</div>
					<!-- Paragraph --> 
					<p>you are importants  for us! order product to this website and get it at real time.</p>

				</div> <!--/ Footer widget end -->
			</div>
			<div class="col-md-5 col-sm-10">
				<!-- Footer widget -->
				<div class="footer-widget">
					<!-- Heading -->
					<h4><span class="fa fa-comment green"></span>&nbsp;&nbsp;&nbsp;Comment here!</h4>
					<!-- Paragraph -->
					<p>Add your comment here? your idea or request is most  important for us.</p>
					<!-- Subscribe form -->
					<?php
						$response = "";
						if (isset($_POST['submit'])) {
							$comment = $_POST['comment'];
							$commenter_email = $_POST['commenter_email'];
							$noti_from = $_POST['commenter'];
							$noti_type = "comment";
							include("db.php");
							$sqlInsertNotification = $con ->query("INSERT INTO notification(noti_type,noti_from,content,noti_time) VALUES('$noti_type', '$noti_from', '$comment', now())");
							$response.='<p style="color: green;">text you commented has sent!</p>';
						}
					?>
					<?php
						echo $response;
					?>
					<form class="form-inline" action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input name="commenter" class="form-control" type="text" placeholder="Your name"  required />
						</div>
						<div class="form-group">
							<input name="commenter_email" class="form-control" type="email" placeholder="Your email" required />
						</div>
						<div class="form-group">
						<textarea name="comment" rows="3" cols="50" class="form-control" required>
						</textarea>
						</div>
						<input value="Comment" class="btn btn-info" type="submit" name="submit">
					</form>
				</div> <!--/ Footer widget end -->
			</div>
			<div class="col-md-3 col-sm-6">
				<!-- Footer widget -->
				<div class="footer-widget">
					<!-- Heading -->
					<h4>Contact Us</h4>
					<div class="contact-details">
						<!-- Address / Icon -->
						<!-- Contact Number / Icon -->
						<i class="fa fa-phone br-green"></i> <span>+250782565895/+250725896545</span>
						<div class="clearfix"></div>
						<!-- Email / Icon -->
						<i class="fa fa-envelope-o br-lblue"></i> <span><a href="#">kcafe@gmail.com</a></span>
						<div class="clearfix"></div>
					</div>
					<!-- Social media icon -->
					<div class="social">
						<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
						<a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
						<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
						<a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a>
					</div>
				</div> <!--/ Footer widget end -->
			</div>
		</div>
		<!-- Copyright -->
		<div class="footer-copyright" style="width: 100%;">
			<!-- Paragraph -->
			<p>&copy; Copyright 2017 <a href="index">KCafe</a></p>
		</div>
	</div>
</div>

<!-- Footer End -->

