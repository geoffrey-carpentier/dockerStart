const { chromium } = require("playwright");

(async () => {
  const browser = await chromium.launch();
  const context = await browser.createContext({
    viewport: { width: 1280, height: 800 },
  });

  // Screenshot 1: Application PHP
  const page1 = await context.newPage();
  await page1.goto("http://localhost:8080", {
    waitUntil: "networkidle",
    timeout: 30000,
  });
  await page1.screenshot({
    path: "D:/TOOLS/LARAGON/www/dockerStart/job-07-lamp/images/01-php-app.png",
    fullPage: true,
  });
  await page1.close();

  // Screenshot 2: phpMyAdmin
  const page2 = await context.newPage();
  await page2.goto("http://localhost:8081", {
    waitUntil: "networkidle",
    timeout: 30000,
  });
  await page2.screenshot({
    path: "D:/TOOLS/LARAGON/www/dockerStart/job-07-lamp/images/02-phpmyadmin.png",
    fullPage: true,
  });
  await page2.close();

  await browser.close();
})();
