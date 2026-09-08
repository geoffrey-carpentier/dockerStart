const express = require("express");
const mysql = require("mysql2");

const dbConfig = {
  host: process.env.DB_HOST || "database",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "root",
  database: process.env.DB_NAME || "projetdb",
};

let connection;

function connectToDatabase() {
  connection = mysql.createConnection(dbConfig);

  connection.connect((err) => {
    if (err) {
      console.error(
        "Error connecting to database. Retrying in 5 seconds...",
        err.message,
      );
      setTimeout(connectToDatabase, 5000);
    } else {
      console.log("Connected to database");
    }
  });

  connection.on("error", (err) => {
    console.error("Database error", err.message);
    if (err.code === "PROTOCOL_CONNECTION_LOST") {
      console.log("Reconnecting to database...");
      connectToDatabase();
    } else {
      throw err;
    }
  });
}

connectToDatabase();

const app = express();

app.get("/", (req, res) => {
  res.send("Bienvenue sur l'API du backend de votre projet Docker !");
});

app.get("/api/status", (req, res) => {
  connection.query("SELECT NOW() AS currentTime", (err, results) => {
    if (err) {
      console.error("Error executing query:", err.message);
      res.status(500).send("Database query failed");
    } else {
      res.json({ status: "success", currentTime: results[0].currentTime });
    }
  });
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Backend running on port ${PORT}`);
});
