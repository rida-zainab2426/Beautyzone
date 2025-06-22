<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Cards with Search</title>
  
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Apple-style Search CSS -->
  <style>
    .apple-search {
      width: 100%;
      max-width: 400px;
      margin: 20px auto;
      position: relative;
    }

    .apple-search input {
      width: 100%;
      padding: 10px 15px;
      border-radius: 12px;
      border: 1px solid #ccc;
      box-shadow: 0 1px 6px rgba(0,0,0,0.1);
      transition: 0.3s ease;
    }

    .apple-search input:focus {
      outline: none;
      border-color: #007aff;
      box-shadow: 0 0 8px rgba(0,122,255,0.4);
    }
  </style>
</head>
<body>

  <div class="container mt-4">
    <!-- Apple Search Bar -->
    <div class="apple-search">
      <input type="text" id="searchInput" placeholder="Search products by name...">
    </div>

    <!-- Cards -->
    <div class="row" id="cardContainer">
      <!-- Card 1 -->
      <div class="col-md-4 mb-4 product-card">
        <div class="card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="iPhone">
          <div class="card-body">
            <h5 class="card-title">iPhone 15</h5>
            <p class="card-text">Latest Apple smartphone with A17 chip.</p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4 mb-4 product-card">
        <div class="card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="MacBook">
          <div class="card-body">
            <h5 class="card-title">MacBook Pro</h5>
            <p class="card-text">Powerful laptop with M3 chip.</p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4 mb-4 product-card">
        <div class="card">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Apple Watch">
          <div class="card-body">
            <h5 class="card-title">Apple Watch Ultra</h5>
            <p class="card-text">Smartwatch for fitness and health tracking.</p>
          </div>
        </div>
      </div>

      <!-- Add more cards as needed -->
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JavaScript for Filtering Cards -->
  <script>
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.product-card');

    searchInput.addEventListener('input', () => {
      const value = searchInput.value.toLowerCase();
      cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        card.style.display = title.includes(value) ? 'block' : 'none';
      });
    });
  </script>
</body>
</html>