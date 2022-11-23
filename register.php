<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name704 = $address = $salary = $username = $password = $confirm_password = "";
$name704_err = $address_err = $salary_err = $username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
// Validate name
if(empty(trim($_POST["name704"]))){
    $name704_err = "Please enter a name.";     
} elseif(strlen(trim($_POST["name704"])) < 6){
    $name704_err = "name must have atleast 6 characters.";
} else{
    $name704 = trim($_POST["name704"]);
}

// Validate address
if(empty(trim($_POST["address"]))){
    $address_err = "Please enter a address.";     
} elseif(strlen(trim($_POST["address"])) < 6){
    $address_err = "address must have atleast 6 characters.";
} else{
    $address = trim($_POST["address"]);
}

// Validate salary
if(empty(trim($_POST["salary"]))){
    $salary_err = "Please enter a salary.";     
} elseif(strlen(trim($_POST["salary"])) < 0){
    $salary_err = "salary must have atleast 6 characters.";
} else{
    $salary = trim($_POST["salary"]);
}



    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name704_err) && empty($address_err) && empty($salary_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name704, address, salary, username, password) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiss", $param_name704, $param_address, $param_salary, $param_username, $param_password);
            
            // Set parameters
            $param_name704 = $name704;
            $param_address = $address;
            $param_salary = $salary;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Free Bootstrap Themes by Zerotheme dot com - Free Responsive Html5 Templates">
    <meta name="author" content="https://www.Zerotheme.com">
	
    <title>ChokoCake | Free Bootstrap Chocolate Templates</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	
	<!-- Custom CSS -->
	<link href="css/style2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Owl Carousel Assets -->
    <link href="owl-carousel/owl.carousel.css" rel="stylesheet">
    <!-- <link href="owl-carousel/owl.theme.css" rel="stylesheet"> -->
	
	<!-- jQuery and Modernizr-->
	<script src="js/jquery-2.1.1.js"></script>
	
    
    <link rel="stylesheet" type="text/css" href="style1.css">
    
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="sub-page">
<div class="wrap-body">

	<header class="clearfix">
		
		<!--Navigation-->
		<nav id="menu" class="navbar">
			<div class="container">
				<div class="navbar-header"><!--<span id="heading" class="visible-xs">Categories</span>-->
				  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
					<a class="navbar-brand" href="#">
						<img src="images/logo.jpg" width="250px"/>
					</a>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.html">Home</a></li>
						<li><a href="aboutus.html">About Us</a></li>

						<li><a href="careers.html">Careers</a></li>
						<li><a href="orderonline.php">Order Online</a></li>

						<li><a href="contactus.html">Contact Us</a></li>
						<li><a href="register.php">Register</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- Static Header -->
		<div class="header-text">
			<div class="col-md-12 text-center">
				<span>Register</span>
				
			</div>
		</div><!-- /header-text -->
		
	</header>
	<!-- /Section: intro -->
	
	<!-- /////////////////////////////////////////Content -->
	<div id="page-content">
		
		<!-----------------Content-------------------->
		<section class="box-content">
			<div class="container">
				<div class="row">
					
					
					<div class="col-md-8">
						<h4>Fill out the form below and sign up as a member.

</h4>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<input type="text" class="form-control input-lg <?php echo (!empty($name704_err)) ? 'is-invalid' : ''; ?>" name="name704" id="name" placeholder="Name" required="required" value="<?php echo $name704; ?>" />
									<span class="invalid-feedback"><?php echo $name704_err; ?></span>
									</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control input-lg <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" name="address" id="subject" placeholder="Address" required="required" value="<?php echo $address; ?>" />
										<span class="invalid-feedback"><?php echo $address_err; ?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control input-lg <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" name="salary" id="subject" placeholder="Salary" required="required" value="<?php echo $salary; ?>" />
										<span class="invalid-feedback"><?php echo $salary_err; ?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control input-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" name="username" id="subject" placeholder="Username" required="required" value="<?php echo $username; ?>" />
										<span class="invalid-feedback"><?php echo $username_err; ?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="password" class="form-control input-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" id="subject" placeholder="Password" required="required" value="<?php echo $password; ?>" />
										<span class="invalid-feedback"><?php echo $password_err; ?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="password" class="form-control input-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" name="confirm_password" id="subject" placeholder="Confirm Password" required="required" value="<?php echo $confirm_password; ?>" />
										<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="submit" class="btn btn-secondary ml-2" value="Submit">
                					<input type="reset" class="btn btn-secondary ml-2" value="Reset">						
									
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
		
	<footer id="footer">
		<div class="wrap-footer">
			<div class="container">
				<div class="row"> 
					<div class="col-footer footer-1 col-md-3">
						<h2 class="footer-title">About Us</h2>
						<div class="footer-content">
							The Luca’s bread offers a large amount of choice and high quality of Sourdough Bread and Desserts. We lovingly make a fine selection of delicious and special breads, sandwiches and other desserts in our Bakery. We also have many types of drinks and several combos.  <br> <br> 
							We are trying to focus on the culture thing and healthy diet.
						</div>
					</div> 
					<div class="col-footer footer-2 col-md-3">
						<h2 class="footer-title">Recent Posts</h2>
						<div class="footer-content">
							<ul>
								<li><a href="#">Origin of Luca's Loaves</a></li>
								<li><a href="#">How to make good bread</a></li>
								<li><a href="#">Nine popular breads you might choose</a></li>
								<li><a href="#">New types of bread are expected to be introduced</a></li>
							</ul>
						</div>
					</div>
					<div class="col-footer footer-3 col-md-3">
						<h2 class="footer-title">OUR FLICKR</h2>
						<div class="footer-content">
							<div class="row">
							<div class="col-md-4">
									<a href="#"><img src="images/1footer.jpg" /></a>
									<a href="#"><img src="images/2footer.jpg" /></a>
									<a href="#"><img src="images/3footer.jpg" /></a>
								</div>
								<div class="col-md-4">
									<a href="#"><img src="images/4footer.jpg" /></a>
									<a href="#"><img src="images/5footer.jpg" /></a>
									<a href="#"><img src="images/6footer.jpg" /></a>
								</div>
								<div class="col-md-4">
									<a href="#"><img src="images/7footer.jpg" /></a>
									<a href="#"><img src="images/8footer.jpg" /></a>
									<a href="#"><img src="images/9footer.jpg" /></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-footer footer-4 col-md-3">
						<h2 class="footer-title">Tag Cloud</h2>
						<div class="footer-content">
							<a href="#">animals</a>
							<a href="#">cooking</a>
							<a href="#">countries</a>
							<a href="#">city</a>
							<a href="#">children</a>
							<a href="#">home</a>
							<a href="#">likes</a>
							<a href="#">photo</a>
							<a href="#">link</a>
							<a href="#">law</a>
							<a href="#">shopping</a>
							<a href="#">skate</a>
							<a href="#">scholl</a>
							<a href="#">video</a>
							<a href="#">travel</a>
							<a href="#">images</a>
							<a href="#">love</a>
							<a href="#">lists</a>
							<a href="#">makeup</a>
							<a href="#">media</a>
							<a href="#">password</a>
							<a href="#">pagination</a>
							<a href="#">wildlife</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom-footer">
			<div class="container">
				<div class="copyright text-center">
					<span>20ITA2 design by Abbott(Lin Jixiang)</span>
				</div>
			</div>
		</div> 
	</footer>
	<!-- Footer -->
	
	<!-- JS -->
	<script src="js/bootstrap.min.js"></script>
	
	<!-- Google Map -->
	<script>
	  var marker;
	  var image = 'images/map-marker.png';
      function initMap() {
        var myLatLng = {lat: 39.79, lng: -86.14};

		// Specify features and elements to define styles.
        var styleArray = [
          {
            featureType: "all",
            stylers: [
             { saturation: -80 }
            ]
          },{
            featureType: "road.arterial",
            elementType: "geometry",
            stylers: [
              { hue: "#000000" },
              { saturation: 50 }
            ]
          },{
            featureType: "poi.business",
            elementType: "labels",
            stylers: [
              { visibility: "off" }
            ]
          }
        ];
		
        var map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          scrollwheel: false,
		   // Apply the map style array to the map.
          styles: styleArray,
          zoom: 7
        });

        var directionsDisplay = new google.maps.DirectionsRenderer({
          map: map
        });

		// Create a marker and set its position.
        marker = new google.maps.Marker({
          map: map,
		  icon: image,
		  draggable: true,
          animation: google.maps.Animation.DROP,
          position: myLatLng
        });
		marker.addListener('click', toggleBounce);
      }
	  
	  function toggleBounce() {
        if (marker.getAnimation() !== null) {
          marker.setAnimation(null);
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7V-mAjEzzmP6PCQda8To0ZW_o3UOCVCE&callback=initMap" async defer></script>
	
	<script src="js/main.js"></script>
</div>	
</body>
</html>