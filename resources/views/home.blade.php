<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Ridge Header Clone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        /* General Reset for Spacing */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

         .top-bar {
            background-color: #5D4037; /* Dark Brown */
            color: #FFF8E1; /* Light Cream */
            padding: 5px 5%;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .social-icons span {
            margin-left: 15px;
            cursor: pointer;
        }

        header {
            background-color: #FFFBF0; /* Cream Background */
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 35px;
            height: 25px;
            border: 2px solid #8D6E63;
            border-radius: 4px 4px 0 0;
            position: relative;
        }

        .logo-text {
            font-size: 26px;
            font-weight: bold;
            color: #3E2723;
            line-height: 1;
        }

        .logo-text span {
            display: block;
            font-size: 12px;
            letter-spacing: 2px;
            font-weight: normal;
        }

        /* Nav Links */
        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #5D4037;
            font-weight: 500;
            font-size: 15px;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #A1887F;
        }

        /* Search & Actions */
        .actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-container {
            display: flex;
            border: 1px solid #D7CCC8;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-container input {
            padding: 8px 12px;
            border: none;
            outline: none;
            background: #fff;
            width: 260px;
        }

        .search-btn {
            background-color: #8D6E63;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        .register-btn {
            background-color: #8D6E63;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .register-btn:hover {
            background-color: #5D4037;
        }

        .user-icon {
            font-size: 20px;
            color: #3E2723;
            cursor: pointer;
        }
        .nav-container {
            
            background-color: #f1f1f1; 
            text-align: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

       .nav-container a {
    display: inline-block;
    margin: 3px 35px; /* spacing between links */
    text-decoration: none;
    color: #555;
    font-size: 16px;
    font-weight: 500;
}

        .nav-container a:hover {
            color: #000;
        }
   .main-wrapper {
    position: relative;
    width: 100%;
}

.banner-container {
    width: 100%;
    height: 650px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: flex-start;
    padding-top: 80px;
    position: relative;
    border-radius: 30px;
    overflow: hidden;
}

.banner-1 { background-image: url('ban.webp'); background-color: #e9ae5c; }
.banner-2 { background-image: url('ban1.jpg'); background-color: #d1d1d1; }
.banner-3 { background-image: url('ban2.jpg'); background-color: #d1d1d1; }
.banner-4 { background-image: url('ban6.avif'); background-color: #e9ae5c; }

.banner-content {
    flex-grow: 1;
    padding-left: 60px;
    z-index: 2;
}

.banner-content h1, .banner-content h2 {
    color: #1a1a1a;
    font-size: 3.8em;
    line-height: 1.1;
    margin-bottom: 20px;
    font-weight: 800;
}

.buttons-container {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.banner-button {
    padding: 12px 28px;
    border: none;
    border-radius: 30px;
    font-size: 1em;
    font-weight: 600;
    background-color: #1a1a1a;
    color: white;
    text-decoration: none;
}

.info-boxes-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    width: 98%;
    max-width: 1450px;
    position: absolute;
    bottom: 20px; 
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.info-box {
    background: white;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.info-box h3 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.box-image-wrapper {
    width: 100%;
    height: 180px;
    border-radius: 12px;
    overflow: hidden;
}

.box-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.style-trends-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

@media (max-width: 991px) {
    .banner-container { height: auto; padding-bottom: 50px; }
    .info-boxes-container {
        position: relative;
        bottom: 0;
        transform: none;
        left: 0;
        width: 100%;
        margin-top: 20px;
        grid-template-columns: 1fr;
    }
}
        .style-trends-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .style-trends-grid.box-image-wrapper{
            height: 250px !important;
        }
        .sub-box {
            display: flex;
            flex-direction: column;
        }

        .sub-box span {
            font-size: 0.9rem;
            margin-top: 5px;
            font-weight: 600;
        }

        /* Responsive Mobile View */
        @media (max-width: 768px) {
            .info-boxes-container {
                grid-template-columns: 1fr; /* Stack vertically on mobile */
            }
            .banner-content h1 { font-size: 2.5em; }
        }
        h5{
            text-align: center;
            color: rgb(152, 25, 25);
            font-weight: 600;
            letter-spacing: 2px;
            text-shadow: 0px 1px #000000;
        }
        h3{
            text-align: center;
            font-weight: 500;
            letter-spacing: 3px;
        }
        h3 span{
            font-weight: 700;
        }

    .icon-grid {
    display: grid;
    grid-template-columns: repeat(8, max-content); /* 4 icons per row */
    gap: 8px 20px; /* Horizontal and vertical spacing */
    justify-items: center; /* Center icons in each cell */
    padding: 0;
    margin-left: 490px;
}
/* Styling for each individual item (Icon + Text) */
.icon-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.icon-item:hover{
     transform: scale(1.2);
}
/* Styling for the Circle Border and Icon */
.icon-circle {
    width: 80px;
    height: 80px;
    border: 2px solid #000;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 8px;
}

.icon-circle i {
    font-size: 36px;
    color: #000;
}

/* Styling for the text label */
.icon-label {
    font-size: 14px;
    color: #000;
}

        .auctions-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
             box-shadow: 0 10px 30px rgba(1,0,0,0.2);
        }
        /* Heading style */
        .auctions-container h2 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #333;
        }

        /* Flex container for the auction items */
        .auction-list {
            display: flex;
            justify-content: space-between; /* Distribute items evenly */
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        /* Style for a single auction item */
        .auction-item {
            position: relative;
            width: 25%; /* Approx. for 4 items in a row */
            margin-bottom: 20px;
            text-align: center;
            padding: 10px;
        }

        /* Image and bid tag container */
        .item-image-container {
            position: relative;
            height: 150px; /* Fixed height for image area */
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        /* Item image style */
        .item-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Ensures the image fits without cropping */
            display: block;
        }
        .item-image:hover {
    transform: scale(1.2);
}
        /* Bid price tag (the orange circle) */
        .bid-tag {
            position: absolute;
            top: -15px; /* Adjust as needed */
            left: 0px; /* Adjust as needed */
            background-color: #ff6600; /* Orange color */
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            line-height: 60px; /* Center text vertically */
            font-weight: bold;
            font-size: 1.1em;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Item details */
        .item-title {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .item-category {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 3px;
        }

        .item-bids {
            font-size: 0.9em;
            color: #666;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .auction-item {
                width: 48%; /* 2 items per row */
            }
        }

        @media (max-width: 480px) {
            .auction-item {
                width: 100%; /* 1 item per row */
            }
        }
         footer {
            background-color: #000000;
            color: #ffffff;
            padding: 60px 8% 20px 8%;
        }

        .footer-top {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 50px;
        }

        /* Logo and Description Section */
        .footer-brand {
            flex: 1;
            min-width: 250px;
            margin-bottom: 30px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .logo-icon {
            width: 40px;
            height: 25px;
            border: 2px solid #d4a373; /* Golden/Tan color */
            border-radius: 4px;
            position: relative;
            margin-right: 10px;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            top: -5px;
            left: 5px;
            right: 5px;
            height: 5px;
            background: #d4a373;
            border-radius: 2px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .brand-name span {
            display: block;
            font-size: 10px;
            letter-spacing: 5px;
            font-weight: normal;
            margin-top: -5px;
        }

        .tagline {
            font-size: 14px;
            color: #cccccc;
            line-height: 1.6;
            max-width: 200px;
        }

        /* Footer Links Columns */
        .footer-links {
            flex: 3;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .link-column {
            margin-bottom: 20px;
            min-width: 150px;
        }

        .link-column h4 {
            font-size: 16px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .link-column ul {
            list-style: none;
        }

        .link-column ul li {
            margin-bottom: 12px;
        }

        .link-column ul li a {
            color: #999999;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .link-column ul li a:hover {
            color: #ffffff;
        }

        /* Bottom Section (Social & Legal) */
        .footer-bottom {
            border-top: 1px solid #222;
            padding-top: 30px;
            text-align: center;
        }

        .social-icons {
            margin-bottom: 20px;
        }

        .social-icons a {
            color: #ffffff;
            font-size: 15px;
            margin: 0 3px;
            text-decoration: none;
        }

        .legal-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .legal-links a {
            color: #999999;
            font-size: 12px;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-top {
                flex-direction: column;
            }
            .footer-links {
                flex-direction: column;
            }
        }
        .categories{
    display: flex;
    gap: 85px;
    font-weight: bold;
    margin-bottom: 30px;
    justify-content: center;
}

.categories span{
    cursor: pointer;
    color: #777;
    padding-bottom: 5px;
}

.categories .active{
    color: #000;
    border-bottom: 3px solid #000;
}

.items{
    display: none;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    padding: 20px 0;
}

.items.active{
    display: grid;
}

.item{
    border: 1px solid #e0e0e0;
    padding: 15px;
    text-align: center;
    background: #fff;
    border-radius: 10px;
}

.item img{
    width: 100%;
    height: 400px;             /* same height as you want */
    object-fit: cover;         /* image fit + crop */
    object-position: center;
    border-radius: 8px;
    display: block;
}
.item p{
    margin-top: 12px;
    font-size: 15px;
    line-height: 1.4;
}
        .up {
    display: flex;
    gap: 90px;
    font-weight: bold;
    margin-bottom: 30px;
    justify-content: center;
}

.up a {
    cursor: pointer;
    color: #777;          
    text-decoration: none; 
    padding-bottom: 5px;
    transition: color 0.3s;
}

.up a:hover {
    color: #000;          
}

.up a.active {
    color: #000;           
    border-bottom: 3px solid #000; 
}
  .container {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            padding-top: 50px;
        }

        /* Side Images */
        .side-img-left {
            position: absolute;
            left: -200px;
            top: 210px;
            width: 300px;
            height: 400px;
             /* Adjust size accordingly */
        }

        .side-img-right {
            position: absolute;
            right: -260px;
             top: 90px;  
            width: 400px; /* Adjust size accordingly */
        }
        .side-img-right {
    background: transparent;
    mix-blend-mode: multiply;}

        .container header h2 {
            font-size: 32px;
            margin-top: 0;
            font-weight: normal;
            
        }

        /* Buttons Section */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 40px 0;
        }

        .nav-button {
            text-decoration: none;
            color: #555;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
        }

        .icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    overflow: hidden; /* Circle ke andar image fit karne ke liye */
    transition: transform 0.2s;
}
.icon-circle img {
    width: 120%; /* Image ko circle ke andar fit karne ke liye */
    height: auto;
    object-fit: contain; /* Image crop ya stretch ko control karta hai */
     border-radius: 90%;
}
        .icon-circle:hover {
            transform: scale(1.1);
        }

       
        /* Text Section */
        .content-box {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            font-size: 18px;
        }

        .content-box a {
            color: #00bcd4;
            text-decoration: none;
        }

        .content-box a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .side-img-left, .side-img-right {
                display: none; /* Mobile par images hide kar di hain */
            }
            .button-container {
                flex-wrap: wrap;
            }
        }
          .newsletter-container {
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9; /* Light background similar to image */
        }

        /* Form styling to keep input and button together */
        .newsletter-form {
            display: flex;
            margin-right: 20px;
            margin-left: 300px;
        }

        /* Email input field styling */
        .email-input {
            padding: 10px 15px;
            border: 1px solid #ccc;
            width: 250px;
            font-size: 14px;
            outline: none;
            color: #666;
        }

        /* Submit button styling */
        .submit-btn {
            background-color: #2c344b; /* Dark navy color from image */
            color: white;
            border: none;
            padding: 10px 25px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #1a1f2d;
        }

        /* Text label styling */
        .newsletter-text {
            font-style: italic;
            font-family: "Times New Roman", Times, serif; /* Seríf font used in image */
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

     <!-- TOP  -->
    <div class="top-bar">
        <div>Free shipping on orders above $100+</div>
        <div class="social-icons">
           <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-x-twitter"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>

    <header>
        <div class="logo-section">
            <div class="logo-icon"></div>
            <div class="logo-text">
                AuctionX
               
            </div>
        </div>

        <nav>
            <ul>
                <li><a href="#" style="color: #8D6E63;">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Pages ▾</a></li>
                <li><a href="#">Shop ▾</a></li>
                <li><a href="#">Blog ▾</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>

        <div class="actions">
            <div class="search-container">
                <input type="text" placeholder="Search for...">
                <button class="search-btn">🔍</button>
            </div>
            <a href="#" class="register-btn">Register</a>
            <div class="user-icon">👤</div>
        </div>
    </header>

    <br><br>
     <div class="nav-container">
        <a href="#">Fine Art</a>
        <a href="#">Decorative Arts</a>
        <a href="#">Furniture</a>
        <a href="#">Jewelry & Watches</a>
        <a href="#">Mid Century Modern</a>
        <a href="#">Asian Works of Art</a>
        <a href="#">Others</a>
    </div>



    <!-- SLIDERS -->
<div class="main-wrapper">
    <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="banner-container banner-1">
                    <div class="banner-content">
                        <h1>Endless Deals.<br>Limited time.</h1>
                        <div class="buttons-container">
                            <a href="#" class="banner-button">Explore Product</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="banner-container banner-2">
                    <div class="banner-content">
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="banner-container banner-3">
                    <div class="banner-content">
                        <h1>Exclusive Offers.<br>Grab Today!</h1>
                        <div class="buttons-container">
                            <a href="#" class="banner-button">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item">
                <div class="banner-container banner-4">
                    <div class="banner-content">
                    </div>
                </div>
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>



<!-- NOTE -->
<br><br>
<div class="about" style="background-color: #f0f0f0; padding: 40px 20px;">
    <h2 style="text-align: center">Leading Online Auction Platform</h2>
    <p style="text-align: center;font-size: 18px; line-height: 1.6;">
        AuctionX is the premier online platform for live and timed online auctions. Browse auction catalogs and bid real-time on <br>
        exceptional fine art and antiques from the best auction houses and dealers. New auctions added daily.
    </p>
</div>



<!-- CATEGORIES -->
 <br><br><br>
<a href="{{ route('categories') }}" style="text-decoration: none; color: inherit;">
    <h3>Our <span>Categories</span></h3>
</a>
<div class="icon-grid">
        
        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-couch"></i> 
            </div>
            <span class="icon-label">Sofa</span>
        </div>

        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-chair"></i>
            </div>
            <span class="icon-label">Chair</span>
        </div>

        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-ring"></i> 
            </div>
            <span class="icon-label">Jewelry</span>
        </div>

        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-brush"></i> 
            </div>
            <span class="icon-label">paintings</span>
        </div>

        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-crown"></i> 
            </div>
            <span class="icon-label">Collectibles</span>
        </div>

        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-bed"></i> 
            </div>
            <span class="icon-label">Bed</span>
        </div>

        <div class="icon-item">
            <div class="icon-circle">
                <i class="fa fa-clock"></i> 
            </div>
            <span class="icon-label">Clocks</span>
        </div>
 
    </div>



 <!--CURRENT AUCTION (OPTIONAL) -->
<br><br><br>
<h5>Auction</h5>
 <h3 >Current <span>Auctions</span></h3>
  <div class="auctions-container">
       
        <div class="auction-list">

            <div class="auction-item">
                <div class="item-image-container">
                    <img src="sofa.webp" alt="Pinky Shoes" class="item-image">
                    <span class="bid-tag">$950</span>
                </div>
                <p class="item-title">White Sofa</p>
                <p class="item-category">Furniture</p>
                <p class="item-bids">4 bids</p>
            </div>

            <div class="auction-item">
                <div class="item-image-container">
                    <img src="bed.jpeg" alt="Eye Glass Eye Protector" class="item-image">
                    <span class="bid-tag">$3000</span>
                </div>
                <p class="item-title">Royal Bed</p>
                <p class="item-category">Furniture</p>
                <p class="item-bids">6 Bids</p>
            </div>

            <div class="auction-item">
                <div class="item-image-container">
                    <img src="jacket.webp" alt="Black Leather Jacket" class="item-image">
                    <span class="bid-tag">$199</span>
                </div>
                <p class="item-title">Black Leather Jacket</p>
                <p class="item-category">Clothing</p>
                <p class="item-bids">3 bids</p>
            </div>

            <div class="auction-item">
                <div class="item-image-container">
                    <img src="mac.jpeg" alt="MacBook 15-Inch Laptop" class="item-image">
                    <span class="bid-tag">$1,999</span>
                </div>
                <p class="item-title">MacBook 15-Inch Laptop</p>
                <p class="item-category">Electronic</p>
                <p class="item-bids">12</p>
            </div>

        </div>
    </div>



    <!-- AUCTION ITEMS -->
<br><br><br>
<h2 style="text-align: center; letter-spacing: 2px; font-size:32px;">Featured <span style="font-weight:600;color:rgb(79, 63, 63)">Auction</span> Items</h2>
<br>
<div class="categories">
    <span class="active">Popular</span>
    <span>Decorative Arts</span>
    <span>Watches</span>
    <span>Collectibles</span>
    <span>Furniture</span>
</div>

<div class="items active">
    <div class="item"><img src="jew.webp"><p>Britannica</p></div>
    <div class="item"><img src="sword.webp"><p>SAMURAY Wall Hanging Sword Showpiece </p></div>
    <div class="item"><img src="jew2.jpg"><p>The Green Empress</p></div>
    <div class="item"><img src="tele.webp"><p>Buy Vintage & Antique Home décor</p></div>
</div>

<div class="items">
    <div class="item"><img src="dec1.jpg"><p>Porcelain and Decorative Arts</p></div>
    <div class="item"><img src="dec.jpg"><p>New Orleans Art</p></div>
    <div class="item"><img src="dec3.jpg"><p>Colorful Ceramic Bowls Crockery Set</p></div>
    <div class="item"><img src="ok.webp"><p>Musée d'Orsay</p></div>
</div>

<div class="items">
    <div class="item"><img src="watch.jpg"><p>Iron Digital Luxury Crystal Peacock Wall Clock Wall-</p></div>
    <div class="item"><img src="clock.jpg"><p>ANTIQUE CLOCKS</p></div>
    <div class="item"><img src="dec5.jpg"><p>TIYETA European Style Table Lamps</p></div>
    <div class="item"><img src="clock1.jpg"><p>Decorative Pendulum Wall Clock Quartz Movement</p></div>
</div>

<div class="items">
    <div class="item"><img src="jew1.webp"><p>The History & Style of Art Nouveau Jewelry</p></div>
    <div class="item"><img src="crown.avif"><p>Victorian Crown, Gold Rhinestone Tiara</p></div>
    <div class="item"><img src="ruby.webp"><p>Antique Victorian 5 Stone Unheated Natural Ruby</p></div>
    <div class="item"><img src="blue.webp"><p>The Historical Significance of Antique Victorian Jewelry</p></div>
</div>

<div class="items">
    <div class="item"><img src="sofa2.webp"><p>Home furntirue at afoordable price in Gujrawala, Pakistan</p></div>
    <div class="item"><img src="bed2.webp"><p>Shop Stylish Bed Sets in Pakistan</p></div>
    <div class="item"><img src="tab.webp"><p>Modern Wooden Dining Table with Classy Chairs</p></div>
    <div class="item"><img src="swing.webp"><p>Perfect Homes Studio Swing chair With Stand And Cushion Iron Hammock</p></div>
</div>

<script>
let index = 0;
const tabs = document.querySelectorAll('.categories span');
const contents = document.querySelectorAll('.items');

setInterval(() => {
    tabs.forEach(t => t.classList.remove('active'));
    contents.forEach(c => c.classList.remove('active'));

    index = (index + 1) % tabs.length;

    tabs[index].classList.add('active');
    contents[index].classList.add('active');
}, 3000);
</script>


<!-- LIVE AUCTION -->
 <br><br><br>
 <h2 style="text-align: center; letter-spacing: 2px;">Upcoming Online Auctions</h2>
 <br>
 <div class="up">
    <a href="#" class="active">All</a>
    <a href="#"><i class="fa-solid fa-gavel"></i> Live Auction</a>
    <a href="#"><i class="fa-regular fa-clock"></i> Time Auction</a>
    <a href="#"><i class="fa-solid fa-bag-shopping"></i> Buy Now</a>
</div>


<!-- HOW TO BID -->
<br><br><br>
  <div class="container">
        <img src="bid1.webp" alt="Left Art" class="side-img-left">
        
        <img src="bid.webp" alt="Auctioneer" class="side-img-right">

        <header>
            <h2>New to Live and Online Auctions?<br>
            Bidding is easy. Learn how to bid in live auctions.</h2>
        </header>

        <div class="button-container">
    <a href="#" class="nav-button">
        <div class="icon-circle">
            <img src="ic1.jpg" alt="Live Auctions">
        </div>
        <span>Live Auctions</span>
    </a>
    <a href="#" class="nav-button">
        <div class="icon-circle">
            <img src="icon3.jpg" alt="Your Watchlist">
        </div>
        <span>Your Watchlist</span>
    </a>
    <a href="#" class="nav-button">
        <div class="icon-circle">
            <img src="icon1.jpg" alt="Condition Reports">
        </div>
        <span>Condition Reports</span>
    </a>
    <a href="#" class="nav-button">
        <div class="icon-circle">
            <img src="icon2.jpg" alt="Buy Now">
        </div>
        <span>Buy Now</span>
    </a>
</div>
        <div class="content-box">
            <p>
                AuctionX is an online auction website providing access to hundreds of auctions and online events from leading auction houses and dealers. Watch live streaming auctions online and bid live, real-time - at any time, on any device, and from anywhere.
            </p>
            <p>
                Registration is free! Place your bids - either a max absentee bid before the auction or bid live during the live streaming auction. Search our full range of online auction catalogs, save your favorite items and create your custom watchlist in My Account.
            </p>
            <p>
                Easily search and find local auctions near you in our <a href="#">Auctions Near Me page</a>. Check our <a href="#">upcoming auctions</a> and watch live video auctions online to discover and acquire rare and beautiful works of <a href="#">Fine Art</a>, <a href="#">Furniture</a>, <a href="#">Real Estate</a>, Antiques, <a href="#">Collectibles</a>, <a href="#">Jewelry</a>, and more.
            </p>
        </div>
    </div>



<!-- FOOTER-->
     <div style="height: 300px;"></div>

 <div class="newsletter-container">
        <form class="newsletter-form">
            <input type="email" class="email-input" placeholder="Your Email Address">
            <button type="submit" class="submit-btn">Submit</button>
        </form>

        <div class="newsletter-text">
            <h3>Get the latest news from AuctionX</h3>
        </div>
    </div>
    <br>
    <footer>
        <div class="footer-top">
            <div class="footer-brand">
                <div class="logo-container">
                    <div class="logo-icon"></div>
                    <div class="brand-name">AuctionX</div>
                </div>
                <p class="tagline">Super complete shop for all kinds of your daily needs</p>
            </div>

            <div class="footer-links">
                <div class="link-column">
                    <h4 style="margin-left: 30px">About</h4>
                    <ul>
                        <li><a href="#">Career</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Investor</a></li>
                        <li><a href="#">Tracking</a></li>
                    </ul>
                </div>

                <div class="link-column">
                    <h4 style="margin-left: 30px">Earn money</h4>
                    <ul>
                        <li><a href="#">Sell your stuff</a></li>
                        <li><a href="#">Join affiliate</a></li>
                        <li><a href="#">Premium seller</a></li>
                        <li><a href="#">Become a host</a></li>
                    </ul>
                </div>

                <div class="link-column">
                    <h4 style="margin-left: 30px">Product</h4>
                    <ul>
                        <li><a href="#">All departments</a></li>
                        <li><a href="#">New items</a></li>
                        <li><a href="#">Flash sale</a></li>
                        <li><a href="#">Trending</a></li>
                    </ul>
                </div>

                <div class="link-column">
                    <h4 style="margin-left: 30px">Help center</h4>
                    <ul>
                        <li><a href="#">Customer care</a></li>
                        <li><a href="#">My account</a></li>
                        <li><a href="#">Return & replacement</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-x-twitter"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
            </div>
            <div class="legal-links">
                <a href="#">Privacy policy</a>
                <a href="#">Term of use</a>
                <a href="#">Accessibility</a>
                <a href="#">Personal information</a>
            </div>
        </div>
    </footer>

</body>
</html>