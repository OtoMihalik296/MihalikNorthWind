<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Úloha 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 5px;
        }

        h2 {
            color: #34495e;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table, th, td {
            border: 1px solid #bdc3c7;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ecf0f1;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php
    require_once "connect.php";

    echo "<h1>požiadavka 01</h1>";

    echo "<h2>Zákazníci</h2>";
    $sql = "SELECT * FROM Customers";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h2>Objednávky</h2>";
    $sql = "SELECT * FROM Orders";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h2>Dodávatelia</h2>";
    $sql = "SELECT * FROM Suppliers";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h1>požiadavka 02</h1>";
    $sql = "SELECT * FROM Customers ORDER BY Country, CompanyName";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h1>požiadavka 03</h1>";
    $sql = "SELECT * FROM Orders ORDER BY OrderDate";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h1>požiadavka 04</h1>";
    $sql = "SELECT COUNT(*) as TotalOrders FROM Orders WHERE YEAR(OrderDate) = 1997";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Objednávky v roku 1997: " . $row['TotalOrders'] . "<br>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h1>požiadavka 05</h1>";
    $sql = "SELECT FirstName, LastName FROM Employees WHERE Title LIKE '%Manager%' ORDER BY FirstName, LastName";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Meno</th><th>Priezvisko</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['FirstName'] . "</td><td>" . $row['LastName'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    echo "<h1>požiadavka 06</h1>";
    $sql = "SELECT * FROM Orders WHERE OrderDate = '1997-05-19'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    $conn->close();
    ?>
</body>
</html>
