<?php
include_once "db_config.php";

// Start or resume the session
session_start();

// Check if a user is logged in and the user ID is set in the URL or in the session
if (!isset($_GET['id']) && (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))) {
  header("Location: login.php");
  exit();
}

// Get the user ID from the URL or from the session
$userID = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'];

try {
  $pdo = new PDO("mysql:host=localhost;dbname=exp", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch user data
  $stmtUser = $pdo->prepare("SELECT * FROM Users WHERE UserID = ?");
  $stmtUser->bindParam(1, $userID);
  $stmtUser->execute();
  $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

  // Redirect to login if the user is not found
  if (!$user) {
    header("Location: login.php");
    exit();
  }

  // Fetch or insert account data
  $stmtAccount = $pdo->prepare("SELECT * FROM Accounts WHERE UserID = ?");
  $stmtAccount->bindParam(1, $userID);
  $stmtAccount->execute();
  $account = $stmtAccount->fetch(PDO::FETCH_ASSOC);

  if (!$account) {
    $stmtInsert = $pdo->prepare("INSERT INTO Accounts (UserID) VALUES (?)");
    $stmtInsert->bindParam(1, $userID);
    $stmtInsert->execute();

    $stmtAccount->execute();
    $account = $stmtAccount->fetch(PDO::FETCH_ASSOC);
  }

  // Fetch account history
  $stmtHistory = $pdo->prepare("SELECT * FROM AccountHistory WHERE UserID = ?");
  $stmtHistory->bindParam(1, $userID);
  $stmtHistory->execute();
  $historyRecords = $stmtHistory->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit();
}

// Process the form submission and update account data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $capital = $_POST["capital"];
  $expenses = $_POST["expenses"];
  $expenseDetails = $_POST["expense_details"];
  $income = $_POST["income"];
  $incomeDetails = $_POST["income_details"];

  try {
    // Update Accounts table
    $stmtUpdate = $pdo->prepare("UPDATE Accounts SET Capital = ?, Expenses = ?, ExpenseDetails = ?, Income = ?, IncomeDetails = ?, TotalExpenses = TotalExpenses + ?, TotalIncome = TotalIncome + ?, Balance = Capital + Income - Expenses WHERE UserID = ?");
    $stmtUpdate->bindParam(1, $capital);
    $stmtUpdate->bindParam(2, $expenses);
    $stmtUpdate->bindParam(3, $expenseDetails);
    $stmtUpdate->bindParam(4, $income);
    $stmtUpdate->bindParam(5, $incomeDetails);
    $stmtUpdate->bindParam(6, $expenses);
    $stmtUpdate->bindParam(7, $income);
    $stmtUpdate->bindParam(8, $userID);
    $stmtUpdate->execute();

    // Fetch updated account data
    $stmtAccount->execute();
    $account = $stmtAccount->fetch(PDO::FETCH_ASSOC);

    // Insert into AccountHistory
    $stmtInsertHistory = $pdo->prepare("INSERT INTO AccountHistory (UserID, Capital, Expenses, ExpenseDetails, Income, IncomeDetails) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtInsertHistory->bindParam(1, $userID);
    $stmtInsertHistory->bindParam(2, $capital);
    $stmtInsertHistory->bindParam(3, $expenses);
    $stmtInsertHistory->bindParam(4, $expenseDetails);
    $stmtInsertHistory->bindParam(5, $income);
    $stmtInsertHistory->bindParam(6, $incomeDetails);
    $stmtInsertHistory->execute();

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .footer {
            margin-top: auto;
            background-color: #f8f9fa;
            text-align: center;
            font-size: 10px;
            padding: 5px;
            width: 100%;
        }
    </style>
</head>


<body>

<nav>
  <!-- Navbar (if any) -->

  <form method="POST" action="logout.php">
    <!-- Logout Form -->
    <button type="submit">Logout</button>
  </form>

</nav><body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container">

  <h2>Welcome <?php echo $user['UserName']; ?>!</h2>

  <!-- Update Account Form -->
  <form method="POST">
    <!-- Form fields for updating account data -->
    <label for="capital">Capital:</label>
    <input type="text" name="capital" value="<?php echo $account['Capital']; ?>">

    <label for="expenses">Expenses:</label>
    <input type="text" name="expenses" value="<?php echo $account['Expenses']; ?>">

    <label for="expense_details">Expense Details:</label>
    <textarea name="expense_details"><?php echo $account['ExpenseDetails']; ?></textarea>

    <label for="income">Income:</label>
    <input type="text" name="income" value="<?php echo $account['Income']; ?>">

    <label for="income_details">Income Details:</label>
    <textarea name="income_details"><?php echo $account['IncomeDetails']; ?></textarea>

    <button type="submit">Update Account</button>
  </form>

  <!-- Display Current Account Details -->
  <h3>Current Account</h3>
  <table>
    <thead>
      <tr>
        <th>AccountID</th>
        <th>Capital</th>
        <th>Expenses</th>
        <th>Expense Details</th>
        <th>Income</th>
        <th>Income Details</th>
        <th>Total Expenses</th>
        <th>Total Income</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $account['AccountID']; ?></td>
        <td><?php echo $account['Capital']; ?></td>
        <td><?php echo $account['Expenses']; ?></td>
        <td><?php echo $account['ExpenseDetails']; ?></td>
        <td><?php echo $account['Income']; ?></td>
        <td><?php echo $account['IncomeDetails']; ?></td>
        <td><?php echo $account['TotalExpenses']; ?></td>
        <td><?php echo $account['TotalIncome']; ?></td>
        <td><?php echo $account['Balance']; ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Display Account History -->
  <h3>Account History</h3>
  <table>
    <thead>
      <tr>
        <th>HistoryID</th>
        <th>Capital</th>
        <th>Expenses</th>
        <th>Expense Details</th>
        <th>Income</th>
        <th>Income Details</th>
        <th>Timestamp</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($historyRecords as $record): ?>
        <tr>
          <td><?php echo $record['HistoryID']; ?></td>
          <td><?php echo $record['Capital']; ?></td>
          <td><?php echo $record['Expenses']; ?></td>
          <td><?php echo $record['ExpenseDetails']; ?></td>
          <td><?php echo $record['Income']; ?></td>
          <td><?php echo $record['IncomeDetails']; ?></td>
          <td><?php echo $record['Timestamp']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer">
        <p>&copy; 2023 Your Website Name. All rights reserved.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
