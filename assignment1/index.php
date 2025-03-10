<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education, Salary & Loan Data</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Original+Surfer&family=Poiret+One&family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <style>   

/* Global Styling */
        body {
            font-family: "Lexend Deca", sans-serif;
            background-color: #8fc2ff;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* Heading Styling */
        h2 {
            font-size: 50px;
            font-family: "Original Surfer", sans-serif; 
            text-align: center;
            color: white;
            text-shadow: 5px 3px 5px #2e387d;
            letter-spacing:3px;
            margin-top: 30px;
            padding: 30px;
            }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Filter Form Styling */
        form {
            background: #ffa077;
            padding: 30px;
            margin: 80px auto;
            width: 70%;
            border-radius: 15px;
            box-shadow: 0 4px 15px #2e387d;
            display: flex;
            /* flex-wrap: wrap; */
            gap: 15px;
        }

        form label {
            font-size: 16px;
            color: #555;
            width: 100%;
        }

        form select, form input {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ff8652;
            border-radius: 10px;
            width: 100%;
            background: ##fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        form select:focus, form input:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.2);
            outline: none;
        }

        form button {
            /* background: linear-gradient(45deg, #6a11cb, #2575fc);  */
            background: #7284ff;
            color: #fff;
            padding: 10px;
            border: 2px solid #ff8652;
            border-radius: 15px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600; 
            letter-spacing: 3px;
            text-transform: uppercase;
            width: 50%;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        form button:hover {
            /* background: linear-gradient(45deg, #2575fc, #6a11cb);  */
            background: #2e387d;
            transform: translateY(-2px);
        }

        /* Table Styling */
        table {
            margin: 80px auto;
            width: 75%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px #2e387d;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 2px solid #ffce4f;
        }

        th {
            background: #ffc327;
            /* background: linear-gradient(45deg, #6a11cb, #2575fc);  */
            color: #fff;
            font-size: 18px;
        }

        td {
            font-size: 16px;
            color: #555;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: rgba(255, 244, 216, 0.5); /* Subtle hover effect */
        }

        /* Footer Styling */
        footer {
            text-align: center;
            padding: 20px;
            /* background: #6a11cb; */
            color: #fff;
            margin-top: 100px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
                font-size: 12px;
            }

            form {
                padding: 15px;
            }

            h2 {
                font-size: 2em;
            }
        }

        /* Loading Spinner */
        #loading-spinner {
            display: none;
            text-align: center;
            margin: 20px;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #6a11cb;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <h2>Education, Salary & Loan Data <img src="./icon.png" alt="icon" style="width: 100px"></h2>
    


    <!-- Loading Spinner -->
    <div id="loading-spinner" style="display: none; text-align: center; margin: 20px;">
        <div class="spinner"></div>
    </div>

    <?php
    $connect = new mysqli('localhost', 'root', 'root', 'education_loan_2');
    // $connect = new mysqli('localhost', 'u129225509_root', 'Root1ab2', 'u129225509_education_loan');

    if ($connect->connect_error) {
        die("Connection Failed: " . $connect->connect_error);
    }

    // Get filter values & prevent SQL injection
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
    $field_of_study = isset($_GET['field_of_study']) ? $_GET['field_of_study'] : '';
    $starting_salary = isset($_GET['starting_salary']) ? $_GET['starting_salary'] : '';

    // Base SQL Query
    $sql = "SELECT e.student_id, e.gender, e.university_ranking, e.university_GPA, e.internship, e.starting_salary, e.field_of_study, 
                   l.income, l.loan, l.credit_score 
            FROM education_career e
            JOIN loan_data l ON e.gender = l.gender AND e.starting_salary = l.income
            WHERE 1";

    // Apply filters using prepared statements
    $params = [];
    if (!empty($gender)) {
        $sql .= " AND e.gender = ?";
        $params[] = $gender;
    }
    if (!empty($field_of_study)) {
        $sql .= " AND e.field_of_study = ?";
        $params[] = $field_of_study;
    }
    if (!empty($starting_salary)) {
        $sql .= " AND e.starting_salary BETWEEN ? AND ?";
        $salary_range = explode('-', $starting_salary);
        $params[] = $salary_range[0];
        $params[] = $salary_range[1];
    }

    $sql .= " ORDER BY e.student_id"; // Order results

    // Prepare SQL statement
    $stmt = $connect->prepare($sql);

    // Bind parameters dynamically
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // 's' = string (change to 'i' for integers if needed)
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <!-- Filter Form -->
    <form method="GET" onsubmit="showLoadingSpinner()">
        <label>Gender:
            <select name="gender">
                <option value="">All</option>
                <option value="Male" <?= $gender === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $gender === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </label>

        <label>Field of Study:
            <select name="field_of_study">
                <option value="">All</option>
                <option value="Business" <?= $field_of_study === 'Business' ? 'selected' : '' ?>>Business</option>
                <option value="Computer Science" <?= $field_of_study === 'Computer Science' ? 'selected' : '' ?>>Computer Science</option>
            </select>
        </label>

        <label>Starting Salary:
            <select name="starting_salary">
                <option value="">All</option>
                <option value="50000-60000" <?= $starting_salary === '50000-60000' ? 'selected' : '' ?>>50k-60k</option>
                <option value="60000-70000" <?= $starting_salary === '60000-70000' ? 'selected' : '' ?>>60k-70k</option>
                <option value="70000-80000" <?= $starting_salary === '70000-80000' ? 'selected' : '' ?>>70k-80k</option>
                <option value="80000-90000" <?= $starting_salary === '80000-90000' ? 'selected' : '' ?>>80k-90k</option>
            </select>
        </label>

        <button type="submit">Filter</button>
    </form>

    <!-- Data Table -->
    <table>
        <tr>
            <th>Student ID</th>
            <th>Gender</th>
            <th>University Ranking</th>
            <th>University GPA</th>
            <th>Internship</th>
            <th>Starting Salary</th>
            <th>Field of Study</th>
            <th>Income</th>
            <th>Loan</th>
            <th>Credit Score</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['student_id']) . "</td>
                        <td>" . htmlspecialchars($row['gender']) . "</td>
                        <td>" . htmlspecialchars($row['university_ranking']) . "</td>
                        <td>" . htmlspecialchars($row['university_GPA']) . "</td>
                        <td>" . htmlspecialchars($row['internship']) . "</td>
                        <td>" . htmlspecialchars($row['starting_salary']) . "</td>
                        <td>" . htmlspecialchars($row['field_of_study']) . "</td>
                        <td>" . htmlspecialchars($row['income']) . "</td>
                        <td>" . htmlspecialchars($row['loan']) . "</td>
                        <td>" . htmlspecialchars($row['credit_score']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }

        $stmt->close();
        $connect->close();
        ?>
    </table>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Education, Salary & Loan Data. All rights reserved.</p>
    </footer>

    <!-- JavaScript for Loading Spinner -->
    <script>
        function showLoadingSpinner() {
            document.getElementById('loading-spinner').style.display = 'block';
        }
    </script>
</body>
</html>