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

<?php

// Add event listener to button
if (isset($_POST['addcarbutton'])) {
    $inputcarFields = "";
    if ($inputcarFields === "") {
        // Create two new input fields
        $carname = '<input type="text" name="carname" placeholder="Enter Car Name">';
        $carmodel = '<input type="text" name="carmodel" placeholder="Enter Car Model">';

        // Add input fields to the DOM
        $inputcarFields .= $carname;
        $inputcarFields .= $carmodel;

        // Show the Submit button
        $submitButtonStyle = 'display: block;';
    }
    // Remove event listener from button
    unset($_POST['addcarbutton']);
}

// Add event listener to Submit button
if (isset($_POST['submitButton'])) {
    // Get the values of the input fields
    $carname = $_POST['carname'];
    $carmodel = $_POST['carmodel'];
    $userID = $_SESSION['user'];
    // Send data to PHP page using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "insert.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "carname=$carname&carmodel=$carmodel&userID=$userID");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result;
    $message = '<p style="color: green;">Saved</p>';
    $locationReload = "<script>location.reload();</script>";
    unset($_POST['submitButton']);
}

// Function to create a card element for a car record
function createCarCard($car) {
    $card = '<div class="card">';
    $card .= '<h2>' . $car['carname'] . '</h2>';
    $card .= '<p>' . $car['carmodel'] . '</p>';
    $card .= '<button onclick="window.location.href=\'carinfo.php?id=' . $car['id'] . '\'">Details</button>';
    $card .= '<button onclick="deleteCar(' . $car['id'] . ')">Delete</button>';
    $card .= '</div>';
    return $card;
}

// Function to retrieve car data from the server and display it in the card view
function loadCars() {
    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', 'get_cars.php');
    if ($res->getStatusCode() == 200) {
        $responseText = $res->getBody();
        echo 'Server response: ' . $responseText . '<br>';
        $cars = json_decode($responseText, true);
        $carCards = '';
        foreach ($cars as $car) {
            $carCards .= createCarCard($car);
        }
        return $carCards;
    } else {
        echo 'Error loading car data. Status code: ' . $res->getStatusCode() . '<br>';
    }
}

// Load car data when page is first loaded
echo loadCars();
?>

</body>
</html>