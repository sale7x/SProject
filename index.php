<?php

include 'userSession.php';


?>

<!DOCTYPE html>
<html>
<head>
  <title>My Website</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      min-height: 50vh;
      background-color: #f2f2f2;
    }
    .card {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin: 20px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      min-width: 300px;
      min-height: 300px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
    .card img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 20px;
    }
    .card h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .card p {
      font-size: 16px;
      margin-bottom: 20px;
    }

    .header {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: #fff;
      padding: 50px 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .header h1 {
      font-size: 36px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="header">
  <h1>Welcome to My Website</h1>
</div>
<div class="container">
  <div class="card" onclick="location.href='carDetails.php?user_id=' + '<?php echo $_SESSION['user']; ?>';">
    <img src="cars.jpg" alt="Cars">
    <h2>Cars</h2>
    <p>View All Cars</p>
  </div>
  <div class="card" onclick="location.href='page1.html';">
    <img src="reminders.jpg" alt="Reminders">
    <h2>Reminders</h2>
    <p>Viwe All Reminders</p>
  </div>
  <div class="card" onclick="location.href='blog.html';">
    <img src="blog.jpg" alt="Blog">
    <h2>Blog</h2>
    <p>Read our latest articles and insights.</p>
  </div>
  <div class="card" onclick="location.href='contact.html';">
    <img src="contact.jpg" alt="Contact">
    <h2>Contact</h2>
    <p>Get in touch with us.</p>
  </div>
</div>
</body>
</html>