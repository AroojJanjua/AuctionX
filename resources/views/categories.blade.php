<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Categories</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
    background:#ffffff;
    margin:0;
    padding:40px 60px;
    color:#222;
}

.section-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.section-title h1{
    font-size:32px;
    font-weight:500;
}

.section-title span{
    font-size:12px;
    letter-spacing:1px;
    color:#777;
}

.divider{
    height:1px;
    background:#ddd;
    margin:15px 0 30px;
}

.category{
    display:flex;
    align-items:center;
    padding:30px 0;
    border-bottom:1px solid #eee;
}
.cat-img{
    width:250px;     /* pehle 120px */
    height:120px;    /* pehle 80px */
    border-radius:6px;
    margin-right:30px;
    flex-shrink:0;
    overflow:hidden;
}
.cat-img img{
    width:100%;
    height:100%;
    object-fit:cover;
}


.cat-number{
    font-size:12px;
    color:#999;
    width:40px;
}

.cat-info{
    flex:1;
}

.cat-info h2{
    font-size:24px;
    margin:0;
    font-weight:500;
}

.cat-info p{
    margin:6px 0 0;
    font-size:14px;
    color:#777;
}

.cat-desc{
    width:260px;
    font-size:14px;
    color:#777;
    line-height:1.5;
    margin-right:30px;
}

.cat-btn button{
    padding:10px 18px;
    border-radius:6px;
    border:1px solid #ccc;
    background:#fff;
    cursor:pointer;
    font-size:12px;
    letter-spacing:.5px;
     transition: all 0.3s ease;
}
.cat-btn button:hover {
    background: #000;      
    color: #fff;           
    border-color: #000;   
}
.cat-btn button:hover .arrow {
    color: #fff;
}
</style>
</head>

<body>

<div class="section-title">
    <h1>Explore Our Categories</h1>
    <span>CATEGORIES</span>
</div>

<div class="divider"></div>

<!-- Living Room -->
<div class="category">
   <div class="cat-img">
    <img src="cat.jpg" alt="Living Room">
</div>

    <div class="cat-number">01</div>

    <div class="cat-info">
        <h2>Living Room</h2>
        <p>Over 250 Products</p>
    </div>

    <div class="cat-desc">
        Transform your living room into a cozy haven with our sofas, coffee tables, and decorative pieces.
    </div>

    <div class="cat-btn">
        <button>GO TO STORE <span class="arrow">→</span></button>

    </div>
</div>

<!-- Bedroom -->
<div class="category">
     <div class="cat-img">
    <img src="cat1.webp" alt="Living Room">
</div>

    <div class="cat-number">02</div>

    <div class="cat-info">
        <h2>Bedroom</h2>
        <p>Over 150 Products</p>
    </div>

    <div class="cat-desc">
        Find peace and tranquility with our curated selection of beds, dressers, and nightstands.
    </div>

    <div class="cat-btn">
        <button class="dark">GO TO STORE →</button>
    </div>
</div>

<!-- DA -->
<div class="category">
    <div class="cat-img">
    <img src="cat3.webp" alt="Living Room">
</div>

    <div class="cat-number">03</div>

    <div class="cat-info">
        <h2>Decorative arts</h2>
        <p>Over 100 Products</p>
    </div>

    <div class="cat-desc">
       Bring style and personality to any room with our selection of decorative art and accents.
    </div>

    <div class="cat-btn">
        <button>GO TO STORE →</button>
    </div>
</div>

<!-- watches -->
<div class="category">
    <div class="cat-img">
    <img src="cat4.jpg" alt="Living Room">
</div>
    <div class="cat-number">04</div>

    <div class="cat-info">
        <h2>The Gilded Hour</h2>
        <p>Over 80 Products</p>
    </div>

    <div class="cat-desc">
       Celebrate timeless craftsmanship with antique clocks that blend history, elegance, and precision.
    </div>

    <div class="cat-btn">
        <button>GO TO STORE →</button>
    </div>
</div>

<!-- collectibles -->
<div class="category">
     <div class="cat-img">
    <img src="cat5.jpg" alt="Living Room">
</div>
    <div class="cat-number">05</div>

    <div class="cat-info">
        <h2>The Royal Vault</h2>
        <p>Over 120 Products</p>
    </div>

    <div class="cat-desc">
        Once symbols of authority and honor, these collectibles preserve the grandeur of royal history.
    </div>

    <div class="cat-btn">
        <button>GO TO STORE →</button>
    </div>
</div>
<!-- painting -->
<div class="category">
     <div class="cat-img">
    <img src="cat7.jpg" alt="Living Room">
</div>
    <div class="cat-number">05</div>

    <div class="cat-info">
        <h2>Canvas paintings</h2>
        <p>Over 120 Products</p>
    </div>

    <div class="cat-desc">
       These canvas paintings bring color, style, and warmth, making any room feel inviting and lively.
    </div>

    <div class="cat-btn">
        <button>GO TO STORE →</button>
    </div>
</div>
</body>
</html>