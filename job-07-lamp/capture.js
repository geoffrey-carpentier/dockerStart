const fs = require("node:fs");
const path = require("node:path");
const { chromium } = require("playwright");

function loadEnv(filePath) {
  if (!fs.existsSync(filePath)) {
    return {};
  }

  const env = {};
  const content = fs.readFileSync(filePath, "utf8");

  for (const line of content.split(/\r?\n/)) {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith("#") || !trimmed.includes("=")) {
      continue;
    }

    const index = trimmed.indexOf("=");
    const key = trimmed.slice(0, index).trim();
    let value = trimmed.slice(index + 1).trim();

    if (
      (value.startsWith('"') && value.endsWith('"')) ||
      (value.startsWith("'") && value.endsWith("'"))
    ) {
      value = value.slice(1, -1);
    }

    env[key] = value;
  }

  return env;
}

(async () => {
  const rootDir = __dirname;
  const imagesDir = path.join(rootDir, "images");
  const env = { ...loadEnv(path.join(rootDir, ".env")), ...process.env };

  fs.mkdirSync(imagesDir, { recursive: true });

  const browser = await chromium.launch();
  const context = await browser.newContext({
    viewport: { width: 1280, height: 800 },
  });

  const shots = [
    ["04-job07-phpinfo-browser.png", "http://localhost:8080/?phpinfo=1"],
    ["05-job07-php-connection-ok.png", "http://localhost:8080/"],
    ["06-job07-phpmyadmin-login.png", "http://localhost:8081/"],
  ];

  for (const [filename, url] of shots) {
    const page = await context.newPage();
    await page.goto(url, { waitUntil: "networkidle", timeout: 30000 });
    await page.screenshot({
      path: path.join(imagesDir, filename),
      fullPage: true,
    });
    await page.close();
  }

  await browser.close();
})();
