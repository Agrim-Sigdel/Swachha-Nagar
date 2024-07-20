<?php
include 'db.php';

// Define variables and initialize with empty values
$ward_number = $section = "";
$schedules = [];

// Fetch schedules based on user selection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ward_number = $_POST['ward_number'];
    $section = $_POST['section'];

    $stmt = $conn->prepare("SELECT * FROM schedules WHERE ward_number = ? AND section = ?");
    $stmt->bind_param("ss", $ward_number, $section);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User View</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    form {
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <h1>View Garbage Truck Schedules</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="ward_number">Ward Number:</label>
        <select id="ward_number" name="ward_number" required>
            <option value="">Select Ward</option>
            <option value="14" <?php if ($ward_number == "14") echo "selected"; ?>>14</option>
            <option value="15" <?php if ($ward_number == "15") echo "selected"; ?>>15</option>
            <option value="16" <?php if ($ward_number == "16") echo "selected"; ?>>16</option>
        </select>
        <br>
        <label for="section">Section:</label>
        <select id="section" name="section" required>
            <option value="">Select Section</option>
            <option value="A" <?php if ($section == "A") echo "selected"; ?>>A</option>
            <option value="B" <?php if ($section == "B") echo "selected"; ?>>B</option>
            <option value="C" <?php if ($section == "C") echo "selected"; ?>>C</option>
            <option value="D" <?php if ($section == "D") echo "selected"; ?>>D</option>
        </select>
        <br>
        <button type="submit">View Schedule</button>
    </form>

    <?php if (!empty($schedules)) { ?>
    <table>
        <tr>

            <th>City</th>
            <th>Ward Number</th>
            <th>Section</th>
            <th>Type of Waste</th>
            <th>Day</th>
        </tr>
        <?php foreach ($schedules as $schedule) { ?>
        <tr>

            <td><?php echo htmlspecialchars($schedule['city']); ?></td>
            <td><?php echo htmlspecialchars($schedule['ward_number']); ?></td>
            <td><?php echo htmlspecialchars($schedule['section']); ?></td>
            <td><?php echo htmlspecialchars($schedule['waste_type']); ?></td>
            <td><?php echo htmlspecialchars($schedule['day']); ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>
</body>

</html>