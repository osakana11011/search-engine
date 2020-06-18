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
const userAgentRegex = new RegExp('^User-agent\\s*:\\s*(\\S+)$', 'i');
const allowRegex = new RegExp('^Allow\\s*:\\s*(\\S+)$', 'i');
const disAllowRegex = new RegExp('^Disallow\\s*:\\s*(\\S+)$', 'i');
const sitemapRegex = new RegExp('^Sitemap\\s*:\\s*(\\S+)$', 'i');

/**
 * 自分自身が許可されているエージェント定義かどうか調べる。
 * "*"以外のユーザーエージェントは適用しないようにする。
 * @param {string} userAgent 許可されているユーザーエージェント
 */
function isAllowed (userAgent) {
  return (userAgent === '*');
}

// スクレイピング処理
puppeteer.launch({
  headless: true,
  args: ['--no-sandbox', '--disable-setuid-sandbox'],
}).then(async browser => {
  const page = await browser.newPage();
  await page.goto(program.url);
  const body = await page.$eval('body', el => el.innerText);
  const items = body.split('\n');

  let result = {
    allows: [],
    disallows: [],
  }
  let isApplyed = false;
  let sitemaps = [];
  items.forEach(item => {
    // user-agent
    if (userAgentRegex.test(item)) {
      isApplyed = isAllowed(item.match(userAgentRegex)[1]);
    }

    // Allow・Disallow
    if (isApplyed) {
      if (allowRegex.test(item)) {
        // Allow
        result.allows.push(item.match(allowRegex)[1]);
      } else if (disAllowRegex.test(item)) {
        // Disallow
        result.disallows.push(item.match(disAllowRegex)[1]);
      }
    }

    // sitemap
    if (sitemapRegex.test(item)) {
      sitemaps.push(item.match(sitemapRegex)[1]);
    }
  });

  console.log(JSON.stringify({
    result,
    sitemaps,
  }));

  browser.close();
});
