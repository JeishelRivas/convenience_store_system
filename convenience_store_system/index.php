<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>QuickMart Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="assets/style.css">

<style>

/* GOOGLE FONT */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:
    linear-gradient(135deg,#ffe4ec,#fdf2ff,#edf4ff);
    overflow-x:hidden;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 100vh;
    background: linear-gradient(to bottom, #ffb3c6, #a2d2ff); /* Imong pink-blue gradient */
    padding: 20px 15px;
    display: flex;
    flex-direction: column;
    
    /* MAOY MAKA-FIX: Kung taas ang sulod, pwede na ma-scroll paubos ang sidebar */
    overflow-y: auto; 
}

/* Para hapsay tan-awon ang scrollbar sa sidebar (Optional pero nindot) */
.sidebar::-webkit-scrollbar {
    width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.4);
    border-radius: 10px;
}

.sidebar .logo {
    text-align: center;
    color: white;
    margin-bottom: 25px; 
}

.sidebar a {
    color: white;
    text-decoration: none;
    padding: 10px 15px; 
    margin-bottom: 5px; 
    display: block;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    padding-left: 20px; 
}
.logo{
    margin-bottom:40px;
}

.logo h2{
    color:white;
    font-weight:800;
    margin:0;
    font-size:30px;
}

.logo p{
    color:white;
    opacity:0.9;
    margin-top:5px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    text-decoration:none;
    color:white;
    padding:14px 16px;
    margin-bottom:12px;
    border-radius:16px;
    transition:0.3s;
    font-weight:500;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.25);
    transform:translateX(5px);
}

/* MAIN */
.main{
    margin-left:270px;
    padding:30px;
}

/* TOPBAR */
.topbar{
    background:rgba(255,255,255,0.7);
    backdrop-filter:blur(14px);
    border-radius:28px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.topbar h2{
    font-weight:800;
    color:#5b4b8a;
}

.topbar p{
    color:#777;
}

/* BUTTON */
.btn-pink{
    background:linear-gradient(135deg,#ff8fab,#ffb3c6);
    border:none;
    color:white;
    padding:12px 18px;
    border-radius:14px;
    font-weight:600;
    transition:0.3s;
}

.btn-pink:hover{
    transform:scale(1.05);
    color:white;
}

/* HERO */
.hero{
    margin-top:30px;
    background:
    linear-gradient(135deg,#ffcad4,#cdb4db,#bde0fe);
    padding:45px;
    border-radius:35px;
    position:relative;
    overflow:hidden;
    color:white;
    box-shadow:0 15px 40px rgba(255,143,171,0.25);
}

.hero::before{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    background:rgba(255,255,255,0.18);
    border-radius:50%;
    top:-120px;
    right:-80px;
}

.hero h1{
    font-size:48px;
    font-weight:800;
}

.hero p{
    font-size:18px;
    margin-top:10px;
}

/* CARDS */
.card-box{
    border:none;
    border-radius:30px;
    padding:28px;
    color:white;
    position:relative;
    overflow:hidden;
    transition:0.3s;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.card-box:hover{
    transform:translateY(-8px);
}

.card-box i{
    position:absolute;
    right:20px;
    bottom:15px;
    font-size:55px;
    opacity:0.25;
}

.card1{
    background:linear-gradient(135deg,#ff8fab,#ffb3c6);
}

.card2{
    background:linear-gradient(135deg,#cdb4db,#b8c0ff);
}

.card3{
    background:linear-gradient(135deg,#90dbf4,#a2d2ff);
}

.card4{
    background:linear-gradient(135deg,#b5ead7,#c7f9cc);
    color:#355070;
}

.card-box h6{
    font-weight:600;
    font-size:16px;
}

.card-box h2{
    font-size:40px;
    font-weight:800;
}

/* TABLE */
.table-card{
    margin-top:30px;
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(10px);
    border-radius:30px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
}

.table-card h4{
    font-weight:700;
    color:#5b4b8a;
}

table thead{
    background:#cdb4db;
    color:white;
}

/* NOTIFICATIONS */
.notify{
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(10px);
    border-radius:30px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
    height:100%;
}

.notify h4{
    color:#5b4b8a;
    font-weight:700;
}

.alert{
    border:none;
    border-radius:15px;
}

/* PROFILE */
.profile{
    display:flex;
    align-items:center;
    gap:15px;
}

.profile img{
    width:55px;
    height:55px;
    border-radius:50%;
    border:4px solid #ffb3c6;
}

/* FOOTER */
.footer{
    text-align:center;
    margin-top:35px;
    color:#888;
    font-size:14px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<div class="logo">
<h2>🛒 QuickMart</h2>
<p>Convenience Store System</p>
</div>


<a href="/convenience_store_system/index.php">
Dashboard
</a>

<a href="/convenience_store_system/customers/index.php">
Customers
</a>

<a href="/convenience_store_system/categories/index.php">
Categories
</a>

<a href="/convenience_store_system/products/index.php">
Products
</a>

<a href="/convenience_store_system/orders/index.php">
Orders
</a>

<a href="/convenience_store_system/orderdetails/index.php">
Order Details
</a>

<a href="/convenience_store_system/suppliers/index.php">
Suppliers
</a>

<a href="/convenience_store_system/shippers/index.php">
Shippers
</a>

<a href="/convenience_store_system/employees/index.php">
Employees
</a>

</div>
<!-- MAIN -->
<div class="main">

<!-- TOPBAR -->
<div class="topbar">

<div>
<h2>✨ Dashboard Overview</h2>
<p class="mb-0">
Manage your convenience store beautifully and efficiently.
</p>
</div>

<div class="profile">



<img src="https://i.pravatar.cc/100" alt="">

</div>

</div>

<!-- HERO -->
<div class="hero">

<h1>Hello Admin 👋</h1>

<p>
Track inventory, customers, sales, and suppliers in one stylish dashboard.
</p>

</div>

<!-- CARDS -->
<div class="row mt-4 g-4">

<div class="col-md-3">

<div class="card-box card1">
<h6>Total Customers</h6>
<h2>120</h2>
<i class="bi bi-people-fill"></i>
</div>

</div>

<div class="col-md-3">

<div class="card-box card2">
<h6>Total Products</h6>
<h2>85</h2>
<i class="bi bi-box-seam"></i>
</div>

</div>

<div class="col-md-3">

<div class="card-box card3">
<h6>Total Orders</h6>
<h2>250</h2>
<i class="bi bi-cart-fill"></i>
</div>

</div>

<div class="col-md-3">

<div class="card-box card4">
<h6>Total Sales</h6>
<h2>₱45K</h2>
<i class="bi bi-cash-stack"></i>
</div>

</div>

</div>

<!-- TABLE + NOTIFICATION -->
<div class="row mt-4 g-4">

<!-- TABLE -->
<div class="col-md-8">

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-3">

<h4>Recent Transactions</h4>

<button class="btn btn-pink">
View All
</button>

</div>

<table class="table table-hover">

<thead>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Item</th>
<th>Status</th>
<th>Total</th>
</tr>
</thead>

<tbody>

<tr>
<td>#1001</td>
<td>Angela</td>
<td>Snacks Bundle</td>
<td><span class="badge bg-success">Completed</span></td>
<td>₱350</td>
</tr>

<tr>
<td>#1002</td>
<td>Sophia</td>
<td>Soft Drinks</td>
<td><span class="badge bg-warning text-dark">Pending</span></td>
<td>₱220</td>
</tr>

<tr>
<td>#1003</td>
<td>Daniel</td>
<td>Instant Noodles</td>
<td><span class="badge bg-info">Processing</span></td>
<td>₱180</td>
</tr>

<tr>
<td>#1004</td>
<td>Alexa</td>
<td>Chocolate Pack</td>
<td><span class="badge bg-danger">Cancelled</span></td>
<td>₱150</td>
</tr>

</tbody>

</table>

</div>

</div>

<!-- NOTIFICATIONS -->
<div class="col-md-4">

<div class="notify">

<h4 class="mb-4">Notifications</h4>

<div class="alert alert-primary">
🛒 New shipment arrived today
</div>

<div class="alert alert-warning">
⚠ Low stock on beverages
</div>

<div class="alert alert-success">
✅ Sales increased this week
</div>

<div class="alert alert-info">
📦 Inventory updated successfully
</div>

</div>

</div>

</div>

<!-- FOOTER -->
<div class="footer">
© 2026 QuickMart Convenience Store System ✨
</div>

</div>

</body>
</html>