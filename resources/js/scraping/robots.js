const program = require("commander");
const puppeteer = require('puppeteer');

// クローリング&スクレイピングする対象のURLをコマンドオプションから取得する
program
  .option("-u, --url <url>", "Scraping URL.")
  .parse(process.argv);

if (process.argv.length < 3) {
  program.help();
}

// robots.txtを読み込む為の正規表現
const userAgentRegex = new RegExp('^User-agent:\\s*(\\S+)$', 'i');
const allowRegex = new RegExp('^Allow:\\s*(\\S+)$', 'i');
const disAllowRegex = new RegExp('^Disallow:\\s*(\\S+)$', 'i');
const sitemapRegex = new RegExp('^Sitemap:\\s*(\\S+)$', 'i');

// スクレイピング処理
puppeteer.launch({
  headless: true,
  args: ['--no-sandbox', '--disable-setuid-sandbox'],
}).then(async browser => {
  const page = await browser.newPage();
  await page.goto(program.url);
  const body = await page.$eval('body', el => el.innerText);
  const items = body.split('\n');

  let userAgents = [];
  let allows = [];
  let disallows = [];
  let sitemap = '';

  items.forEach(item => {
    if (userAgentRegex.test(item)) {
      userAgents.push(item.match(userAgentRegex)[1]);
    } else if (allowRegex.test(item)) {
      allows.push(item.match(allowRegex)[1]);
    } else if (disAllowRegex.test(item)) {
      disallows.push(item.match(disAllowRegex)[1]);
    } else if (sitemapRegex.test(item)) {
      sitemap = item.match(sitemapRegex)[1];
    }
  });

  console.log(JSON.stringify({
    userAgents,
    allows,
    disallows,
    sitemap,
  }));

  browser.close();
});
