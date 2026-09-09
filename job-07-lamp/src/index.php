<?php

$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'lamp_demo';
$dbUser = getenv('DB_USER') ?: 'dev';
$dbPassword = getenv('DB_PASSWORD') ?: 'dev_password';

if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit;
}

$statusTitle = 'Connexion MySQL';
$statusMessage = '';
$statusClass = 'error';
$serverTime = null;

try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $dbName);
    $pdo = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $serverTime = $pdo->query('SELECT NOW() AS server_time')->fetchColumn();
    $statusMessage = sprintf(
        'Connexion réussie à la base <strong>%s</strong> sur <strong>%s:%s</strong> avec l’utilisateur <strong>%s</strong>.',
        htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($host, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($port, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars($dbUser, ENT_QUOTES, 'UTF-8')
    );
    $statusClass = 'success';
} catch (Throwable $exception) {
    $statusMessage = sprintf(
        'Échec de connexion MySQL : %s',
        htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8')
    );
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job07 - Stack LAMP</title>
    <style>
        :root {
            color-scheme: light dark;
            --bg: #0f172a;
            --panel: #111827;
            --border: #334155;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --success: #16a34a;
            --error: #dc2626;
            --accent: #38bdf8;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: linear-gradient(180deg, #020617 0%, #0f172a 100%);
            color: var(--text);
        }

        main {
            max-width: 980px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }

        .card {
            border: 1px solid var(--border);
            background: rgba(15, 23, 42, 0.9);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        }

        h1 {
            margin-top: 0;
            font-size: 2rem;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .badge.success {
            background: rgba(22, 163, 74, 0.16);
            color: #86efac;
        }

        .badge.error {
            background: rgba(220, 38, 38, 0.16);
            color: #fca5a5;
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin: 20px 0;
        }

        .meta div {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            background: rgba(2, 6, 23, 0.55);
        }

        .meta small {
            display: block;
            color: var(--muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        code {
            padding: 2px 6px;
            border-radius: 6px;
            background: rgba(148, 163, 184, 0.15);
        }

        .hint {
            color: var(--muted);
        }
    </style>
</head>

<body>
    <main>
        <section class="card">
            <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusTitle, ENT_QUOTES, 'UTF-8'); ?></span>
            <h1>Job07 - Stack LAMP</h1>
            <p class="hint">Conteneur PHP + MySQL + phpMyAdmin avec configuration externe via variables d’environnement.</p>

            <p><?php echo $statusMessage; ?></p>

            <?php if ($serverTime !== null): ?>
                <p>Heure serveur MySQL : <code><?php echo htmlspecialchars((string) $serverTime, ENT_QUOTES, 'UTF-8'); ?></code></p>
            <?php endif; ?>

            <div class="meta">
                <div>
                    <small>Hôte BDD</small>
                    <strong><?php echo htmlspecialchars($host, ENT_QUOTES, 'UTF-8'); ?></strong>
                </div>
                <div>
                    <small>Base</small>
                    <strong><?php echo htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8'); ?></strong>
                </div>
                <div>
                    <small>Utilisateur</small>
                    <strong><?php echo htmlspecialchars($dbUser, ENT_QUOTES, 'UTF-8'); ?></strong>
                </div>
                <div>
                    <small>Port MySQL interne</small>
                    <strong><?php echo htmlspecialchars($port, ENT_QUOTES, 'UTF-8'); ?></strong>
                </div>
            </div>

            <p>
                <a href="?phpinfo=1">Ouvrir phpinfo()</a>
                &nbsp;|&nbsp;
                <a href="http://localhost:8081" target="_blank" rel="noreferrer">Ouvrir phpMyAdmin</a>
            </p>
        </section>
    </main>
</body>

</html>