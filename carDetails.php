<?php

include 'userSession.php';
$userID = $_SESSION['user'];


?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Catalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


        /* Style the parts list section */
        #car-cards{
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

    <h1>Car List</h1>
    <button id="addcarbutton">Add New Car</button>
    <div id="inputcarFields"></div>
    <button id="submitButton">Submit</button>
</header>

<main>



<div id="car-cards"></div>

</main>

<footer>
    &copy; 2023 Car List
</footer>

<script>

    // Add event listener to button
    document.getElementById("addcarbutton").addEventListener("click", function() {

        var inputcarFields = document.getElementById("inputcarFields");
        if (inputcarFields.innerHTML === "") {
            // Create two new input fields
            var carname = document.createElement("input");
            carname.type = "text";
            carname.name = "carname";
            carname.placeholder = "Enter Car Name";

            var carmodel = document.createElement("input");
            carmodel.type = "text";
            carmodel.name = "carmodel";
            carmodel.placeholder = "Enter Car Model";

            // Add input fields to the DOM
            document.getElementById("inputcarFields").appendChild(carname);
            document.getElementById("inputcarFields").appendChild(carmodel);

            // Show the Submit button
            document.getElementById("submitButton").style.display = "block";
        }
        // Remove event listener from button
        document.getElementById("addcarbutton").removeEventListener("click", arguments.callee);

    });
    // Add event listener to Submit button
    document.getElementById("submitButton").addEventListener("click", function() {
        // Get the values of the input fields
        var carname = document.querySelector('input[name="carname"]').value;
        var carmodel = document.querySelector('input[name="carmodel"]').value;
        var userID  ='<?php echo $_SESSION['user']?>';
        console.log(userID);
        // Send data to PHP page using XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "insert.php", true);
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
        xhr.send("carname=" + carname + "&carmodel=" + carmodel + "&userID=" + userID);
    });

    // Function to create a card element for a car record
    function createCarCard(car) {
        var card = document.createElement('div');
        card.className = 'card';

        var name = document.createElement('h2');
        name.textContent = car.carname;
        card.appendChild(name);

        var model = document.createElement('p');
        model.textContent = car.carmodel;
        card.appendChild(model);



        var detailsBtn = document.createElement('button');
        detailsBtn.textContent = 'Details';
        detailsBtn.onclick = function() {
            // Navigate to the car details page with the car id as a parameter
            window.location.href = 'carinfo.php?id=' + car.id;
        };
        card.appendChild(detailsBtn);

        var deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.onclick = function() {
            console.log(car.id);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_car.php', true);

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    location.reload();
                } else {
                    console.log('Error deleting car. Status code: ' + xhr.status);
                }
            };
            xhr.send('id=' + encodeURIComponent(car.id));
        };
        card.appendChild(deleteBtn);

        return card;
    }


    // Function to retrieve car data from the server and display it in the card view
    function loadCars() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `get_cars.php`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var responseText = xhr.responseText;
                console.log('Server response:', responseText);
                var cars = JSON.parse(responseText);
                var carCards = document.getElementById('car-cards');
                carCards.innerHTML = '';
                for (var i = 0; i < cars.length; i++) {
                    var carCard = createCarCard(cars[i]);
                    carCards.appendChild(carCard);
                }
            } else {
                console.log('Error loading car data. Status code: ' + xhr.status);
            }
        };
        xhr.send();
    }



    // Load car data when page is first loaded
    loadCars();
</script>
</body>
</html>