<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Úloha 03</title>
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

    // požiadavka 01
    echo "<h1>požiadavka 01</h1>";
    $sql = "SELECT SUM(`order details`.Quantity * `order details`.UnitPrice) AS TotalRevenue
            FROM Orders
            JOIN `order details` ON Orders.OrderID = `order details`.OrderID
            WHERE YEAR(Orders.OrderDate) = 1994";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p>Naše celkové príjmy v roku 1994 boli: " . number_format($row['TotalRevenue'], 2) . " dolárov</p>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 02
    echo "<h1>požiadavka 02</h1>";
    $sql = "SELECT Customers.CustomerID, Customers.CompanyName, SUM(`order details`.Quantity * `order details`.UnitPrice) AS TotalPaid
            FROM Customers
            JOIN Orders ON Customers.CustomerID = Orders.CustomerID
            JOIN `order details` ON Orders.OrderID = `order details`.OrderID
            GROUP BY Customers.CustomerID, Customers.CompanyName";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID zákazníka</th><th>Meno spoločnosti</th><th>Celková suma</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['CustomerID'] . "</td><td>" . $row['CompanyName'] . "</td><td>" . number_format($row['TotalPaid'], 2) . " dolárov</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 03
    echo "<h1>požiadavka 03</h1>";
    $sql = "SELECT Products.ProductID, Products.ProductName, SUM(`order details`.Quantity) AS TotalQuantity
            FROM `order details`
            JOIN Products ON `order details`.ProductID = Products.ProductID
            GROUP BY Products.ProductID, Products.ProductName
            ORDER BY TotalQuantity DESC
            LIMIT 10";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID produktu</th><th>Názov produktu</th><th>Predané množstvo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['ProductID'] . "</td><td>" . $row['ProductName'] . "</td><td>" . $row['TotalQuantity'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 04
    echo "<h1>požiadavka 04</h1>";
    $sql = "SELECT Customers.CustomerID, Customers.CompanyName, SUM(`order details`.Quantity * `order details`.UnitPrice) AS TotalRevenue
            FROM Customers
            JOIN Orders ON Customers.CustomerID = Orders.CustomerID
            JOIN `order details` ON Orders.OrderID = `order details`.OrderID
            GROUP BY Customers.CustomerID, Customers.CompanyName";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID zákazníka</th><th>Meno spoločnosti</th><th>Celkové výnosy</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['CustomerID'] . "</td><td>" . $row['CompanyName'] . "</td><td>" . number_format($row['TotalRevenue'], 2) . " dolárov</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 05
    echo "<h1>požiadavka 05</h1>";
    $sql = "SELECT Customers.CustomerID, Customers.CompanyName, SUM(`order details`.Quantity * `order details`.UnitPrice) AS TotalPaid
            FROM Customers
            JOIN Orders ON Customers.CustomerID = Orders.CustomerID
            JOIN `order details` ON Orders.OrderID = `order details`.OrderID
            WHERE Customers.Country = 'UK'
            GROUP BY Customers.CustomerID, Customers.CompanyName
            HAVING TotalPaid > 1000";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID zákazníka</th><th>Meno spoločnosti</th><th>Celková suma</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['CustomerID'] . "</td><td>" . $row['CompanyName'] . "</td><td>" . number_format($row['TotalPaid'], 2) . " dolárov</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 06
    echo "<h1>požiadavka 06</h1>";
    $sql = "SELECT Customers.CustomerID, Customers.CompanyName, Customers.Country, 
                   SUM(`order details`.Quantity * `order details`.UnitPrice) AS TotalPaid,
                   SUM(CASE WHEN YEAR(Orders.OrderDate) = 1995 THEN `order details`.Quantity * `order details`.UnitPrice ELSE 0 END) AS PaidIn1995
            FROM Customers
            JOIN Orders ON Customers.CustomerID = Orders.CustomerID
            JOIN `order details` ON Orders.OrderID = `order details`.OrderID
            GROUP BY Customers.CustomerID, Customers.CompanyName, Customers.Country";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID zákazníka</th><th>Meno spoločnosti</th><th>Krajina</th><th>Celková suma</th><th>Suma v roku 1995</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['CustomerID'] . "</td><td>" . $row['CompanyName'] . "</td><td>" . $row['Country'] . "</td><td>" . number_format($row['TotalPaid'], 2) . " dolárov</td><td>" . number_format($row['PaidIn1995'], 2) . " dolárov</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 07
    echo "<h1>požiadavka 07</h1>";
    $sql = "SELECT COUNT(DISTINCT Customers.CustomerID) AS TotalCustomers
            FROM Orders
            JOIN Customers ON Orders.CustomerID = Customers.CustomerID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p>Celkový počet zákazníkov zo všetkých objednávok je: " . $row['TotalCustomers'] . "</p>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 08
    echo "<h1>požiadavka 08</h1>";
    $sql = "SELECT COUNT(DISTINCT Customers.CustomerID) AS TotalCustomers1996
            FROM Orders
            JOIN Customers ON Orders.CustomerID = Customers.CustomerID
            WHERE YEAR(Orders.OrderDate) = 1996";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p>Celkový počet zákazníkov z 1996 objednávok je: " . $row['TotalCustomers1996'] . "</p>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    $conn->close();
    ?>
</body>
</html>
