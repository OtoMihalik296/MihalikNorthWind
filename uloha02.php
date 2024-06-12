<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Úloha 2</title>
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
    echo "<h1>Požiadavka 01</h1>";
    $sql = "SELECT Orders.OrderID, Orders.OrderDate, Customers.CompanyName 
            FROM Orders 
            JOIN Customers ON Orders.CustomerID = Customers.CustomerID 
            WHERE YEAR(Orders.OrderDate) = 1996";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID objednávky</th><th>Dátum objednávky</th><th>Meno zákazníka</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['OrderID'] . "</td><td>" . $row['OrderDate'] . "</td><td>" . $row['CompanyName'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 02
    echo "<h1>Požiadavka 02</h1>";
    $sql = "SELECT Employees.City, COUNT(DISTINCT Employees.EmployeeID) AS EmployeeCount, COUNT(DISTINCT Customers.CustomerID) AS CustomerCount
            FROM Employees
            LEFT JOIN Customers ON Employees.City = Customers.City
            GROUP BY Employees.City";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Mesto</th><th>Počet zamestnancov</th><th>Počet zákazníkov</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['City'] . "</td><td>" . $row['EmployeeCount'] . "</td><td>" . $row['CustomerCount'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 03
    echo "<h1>Požiadavka 03</h1>";
    $sql = "SELECT Customers.City, COUNT(DISTINCT Employees.EmployeeID) AS EmployeeCount, COUNT(DISTINCT Customers.CustomerID) AS CustomerCount
            FROM Customers
            LEFT JOIN Employees ON Customers.City = Employees.City
            GROUP BY Customers.City";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Mesto</th><th>Počet zamestnancov</th><th>Počet zákazníkov</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['City'] . "</td><td>" . $row['EmployeeCount'] . "</td><td>" . $row['CustomerCount'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 04
    echo "<h1>Požiadavka 04</h1>";
    $sql = "SELECT City, 
                   SUM(CASE WHEN Source = 'Employee' THEN 1 ELSE 0 END) AS EmployeeCount, 
                   SUM(CASE WHEN Source = 'Customer' THEN 1 ELSE 0 END) AS CustomerCount 
            FROM (
                SELECT City, 'Employee' AS Source FROM Employees 
                UNION ALL 
                SELECT City, 'Customer' AS Source FROM Customers
            ) AS Combined
            GROUP BY City";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Mesto</th><th>Počet zamestnancov</th><th>Počet zákazníkov</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['City'] . "</td><td>" . $row['EmployeeCount'] . "</td><td>" . $row['CustomerCount'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 05
    echo "<h1>Požiadavka 05</h1>";
    $sql = "SELECT Orders.OrderID, Employees.FirstName, Employees.LastName
            FROM Orders
            JOIN Employees ON Orders.EmployeeID = Employees.EmployeeID
            WHERE Orders.ShippedDate > '1995-12-31'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID objednávky</th><th>Meno zamestnanca</th><th>Priezvisko zamestnanca</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['OrderID'] . "</td><td>" . $row['FirstName'] . "</td><td>" . $row['LastName'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 06
    echo "<h1>Požiadavka 06</h1>";
    $sql = "SELECT ProductID, SUM(Quantity) AS TotalQuantity 
            FROM `Order Details` 
            GROUP BY ProductID 
            HAVING SUM(Quantity) < 200";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID produktu</th><th>Celkové množstvo</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['ProductID'] . "</td><td>" . $row['TotalQuantity'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    // požiadavka 07
    echo "<h1>Požiadavka 07</h1>";
    $sql = "SELECT Customers.CustomerID, Customers.CompanyName, COUNT(Orders.OrderID) AS TotalOrders 
            FROM Orders 
            JOIN Customers ON Orders.CustomerID = Customers.CustomerID 
            WHERE Orders.OrderDate > '1994-12-31' 
            GROUP BY Customers.CustomerID, Customers.CompanyName 
            HAVING COUNT(Orders.OrderID) > 15";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID zákazníka</th><th>Meno spoločnosti</th><th>Celkový počet objednávok</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['CustomerID'] . "</td><td>" . $row['CompanyName'] . "</td><td>" . $row['TotalOrders'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Údaje sa nenašli</p>";
    }

    $conn->close();
    ?>
</body>
</html>