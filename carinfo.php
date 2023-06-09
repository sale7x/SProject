<?php

include 'userSession.php';

$carId = $_GET['id'];
?>


<!DOCTYPE html>
<html>
<head>
  <title>Car Info</title>
  <style>
    /* Define the grid layout */
    body {
      display: grid;
      grid-template-columns: 1fr;
      grid-template-rows: auto 1fr auto;
      grid-template-areas:
        "header"
        "main"
        "footer";
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Style the header section */
    header {
      grid-area: header;
      background-color: #333;
      color: #fff;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Style the main section */
    main {
      grid-area: main;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 20px;
      padding: 20px;
      overflow: auto;
    }

    /* Style the car details section */
    #car-info {
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    /* Style the parts list section */
    #parts-list {
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    /* Style the footer section */
    footer {
      grid-area: footer;
      background-color: #eee;
      padding: 10px;
      text-align: center;
    }

    /* Style the buttons */
    button {
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #333;
      color: #fff;
      cursor: pointer;
    }

    /* Show the submit button when there are input fields */
    #submitButton {
      display: none;
    }

    /* Media queries for responsive design */
    @media screen and (max-width: 768px) {
      body {
        grid-template-areas:
          "header"
          "main"
          "footer";
      }
      main {
        grid-template-columns: 1fr;
      }
    }

    @media screen and (max-width: 576px) {
      main {
        grid-gap: 10px;
      }
    }
  </style>
</head>
<body>
<header>
  <h1>Car Info</h1>
  <button id="addPartbutton">Add Part/Service</button>
  <div id="inputFields"></div>
  <button id="submitButton">Submit</button>
</header>

<main>
  <div id="car-info">

    <h1>Car Info</h1>
  </div>

  <div id="parts-list"></div>
</main>

<footer>
  &copy; 2023 Car Info
</footer>






<script>
  // Get the car id from the URL parameter



      // Call an API endpoint to get the car details by id
      fetch('get-car-byID.php?id=' + <?php echo $carId; ?>)
          .then(function (response) {
              return response.json();
          })
          .then(function (car) {
              // Display the car details
              var carDetails = document.getElementById('car-info');
              carDetails.innerHTML = '<h2>' + car.carname + '</h2>' +
                  '<p>Model: ' + car.carmodel + '</p>';

              // Call an API endpoint to get the parts for this car
              fetch('get-parts-data.php?id=' + <?php echo $carId; ?>)
                  .then(function (response) {
                      return response.json();
                  })
                  .then(function (parts) {
                      // Display the parts for this car
                      var partsList = document.getElementById('parts-list');
                      partsList.innerHTML = '';
                      parts.forEach(function (part) {
                          var card = document.createElement('div');
                          card.classList.add('card');

                          var cardBody = document.createElement('div');
                          cardBody.classList.add('card-body');

                          var partname = document.createElement('h5');
                          partname.classList.add('card-title');
                          partname.textContent = part.partname;

                          var daysno = document.createElement('p');
                          daysno.classList.add('card-text');
                          daysno.textContent = 'Remind in ' + part.daysno + ' days';

                          cardBody.appendChild(partname);
                          cardBody.appendChild(daysno);
                          card.appendChild(cardBody);
                          partsList.appendChild(card);
                      });
                  })
                  .catch(function (error) {
                      console.log(error);
                  });

          })
          .catch(function (error) {
              console.log(error);
          });


  // Add event listener to button
  document.getElementById("addPartbutton").addEventListener("click", function() {

    var inputFields = document.getElementById("inputFields");
    if (inputFields.innerHTML === "") {
      // Create two new input fields
      var partname = document.createElement("input");
      partname.type = "text";
      partname.name = "partname";
      partname.placeholder = "Enter Part/Service name";

      var daysno = document.createElement("input");
      daysno.type = "number";
      daysno.name = "daysno";
      daysno.placeholder = "Enter days to remind";

      // Add input fields to the DOM
      document.getElementById("inputFields").appendChild(partname);
      document.getElementById("inputFields").appendChild(daysno);

      // Show the Submit button
      document.getElementById("submitButton").style.display = "block";
    }
    // Remove event listener from button
    document.getElementById("addPartbutton").removeEventListener("click", arguments.callee);

  });
    // Add event listener to Submit button
    document.getElementById("submitButton").addEventListener("click", function() {
      // Get the values of the input fields
      var partname = document.querySelector('input[name="partname"]').value;
      var daysno = document.querySelector('input[name="daysno"]').value;

      // Send data to PHP page using XMLHttpRequest
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "save-part.php?id=" + <?php echo $carId; ?>, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          console.log(this.responseText);
          var message = document.createElement("p");
          message.textContent = "Saved";
          message.style.color = "green";
          document.body.appendChild(message);
          location.reload();
        }
      };
      xhr.send("partname=" + partname + "&daysno=" + daysno);
    });

</script>
</body>
</html>