const program = require("commander");
const puppeteer = require('puppeteer');

// クローリング&スクレイピングする対象のURLをコマンドオプションから取得する
program
  .option("-u, --url <url>", "Scraping URL.")
  .parse(process.argv);

if (process.argv.length < 3) {
  program.help();
}


puppeteer.launch({
  headless: true,
  args: ['--no-sandbox', '--disable-setuid-sandbox'],
}).then(async browser => {
  const page = await browser.newPage();

  // await page.setViewport({ width: 1200, height: 800 });
  await page.goto(program.url);
  const titleValue = await page.$eval('title', el => el.innerText);
  console.log(JSON.stringify({
    title: titleValue,
  }));
  // await page.screenshot({path: 'puppeteer_example.png'});

  browser.close();
});
