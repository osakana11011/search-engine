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
  await page.goto(program.url);

  // メタ情報を取得
  const title = await page.$eval('title', el => el.innerText).catch(() => '');
  const author = await page.$eval('meta[name="author"]', el => el.content).catch(() => '');
  const description = await page.$eval('meta[name="description"]', el => el.content).catch(() => '');
  const keywords = await page.$eval('meta[name="keywords"]', el => el.content.split(',').map(str => str.trim())).catch(() => '');
  const applicationName = await page.$eval('meta[name="application-name"]', el => el.content).catch(() => '');
  const generator = await page.$eval('meta[name="generator"]', el => el.content).catch(() => '');
  const robots = await page.$eval('meta[name="robots"]', el => el.content).catch(() => '');

  // ページ内の画像を取得
  const images = await page.$$eval('img', imgs => {
    return imgs.map(el => el.src);
  });

  console.log(JSON.stringify({
    meta: {
      title,
      author,
      description,
      keywords,
      applicationName,
      generator,
      robots,
    },
    images,
  }));

  browser.close();
});
