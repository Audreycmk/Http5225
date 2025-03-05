<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education & Loan Data</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Education & Loan Data</h2>

    <?php
    // Database connection
    $connect = mysqli_connect('localhost', 'u129225509_root', 'Root1ab2', 'u129225509_education_loan');

    if (!$connect) {
        die('Connection Failed: ' . mysqli_connect_error());
    }

    // Get filter values
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
    $university_ranking = isset($_GET['university_ranking']) ? $_GET['university_ranking'] : '';
    $credit_score = isset($_GET['credit_score']) ? $_GET['credit_score'] : '';

    // Base SQL Query
    $sql = "SELECT e.student_id, e.gender, e.university_ranking, e.university_GPA, e.internship, e.project, e.starting_salary, 
                   l.client_id, l.income, l.loan, l.credit_score 
            FROM education_career e
            JOIN loan_data l ON e.gender = l.gender
            WHERE 1";

    $params = [];
    $types = '';

    if (!empty($gender)) {
        $sql .= " AND e.gender = ?";
        $params[] = $gender;
        $types .= 's';
    }
    if (!empty($university_ranking)) {
        $sql .= " AND e.university_ranking = ?";
        $params[] = $university_ranking;
        $types .= 'i';
    }
    if (!empty($credit_score)) {
        $sql .= " AND l.credit_score >= ?";
        $params[] = $credit_score;
        $types .= 'i';
    }

    // Prepare and execute the query
    $stmt = $connect->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!-- Filter Form -->
    <form method="GET">
        <label>Gender:
            <select name="gender">
                <option value="">All</option>
                <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </label>

        <label>University Ranking:
            <input type="number" name="university_ranking" value="<?= htmlspecialchars($university_ranking) ?>">
        </label>

        <label>Min Credit Score:
            <input type="number" name="credit_score" value="<?= htmlspecialchars($credit_score) ?>">
        </label>

        <button type="submit">Filter</button>
    </form>

    <!-- Data Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Gender</th>
            <th>University Ranking</th>
            <th>University GPA</th>
            <th>Internship</th>
            <th>Project</th>
            <th>Starting Salary</th>
            <th>Income</th>
            <th>Loan</th>
            <th>Credit Score</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['student_id']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['university_ranking']}</td>
                        <td>{$row['university_GPA']}</td>
                        <td>{$row['internship']}</td>
                        <td>{$row['project']}</td>
                        <td>{$row['starting_salary']}</td>
                        <td>{$row['income']}</td>
                        <td>{$row['loan']}</td>
                        <td>{$row['credit_score']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No records found</td></tr>";
        }
        ?>
    </table>

</body>
</html>
