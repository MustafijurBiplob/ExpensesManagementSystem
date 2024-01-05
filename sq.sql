


-- Create Users Table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    RegistrationDate DATE NOT NULL
);

-- Create Accounts Table
CREATE TABLE Accounts (
    AccountID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    Capital DECIMAL(10, 2) DEFAULT 0.00,
    Expenses DECIMAL(10, 2) DEFAULT 0.00,
    ExpenseDetails TEXT,
    Income DECIMAL(10, 2) DEFAULT 0.00,
    IncomeDetails TEXT,
    TotalExpenses DECIMAL(10, 2) DEFAULT 0.00,
    TotalIncome DECIMAL(10, 2) DEFAULT 0.00,
    Balance DECIMAL(10, 2) DEFAULT 0.00,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
CtREATE TABLE AccountHistory (
    HistoryID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    Capital DECIMAL(10, 2),
    Expenses DECIMAL(10, 2),
    ExpenseDetails TEXT,
    Income DECIMAL(10, 2),
    IncomeDetails TEXT,
    Timesamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
