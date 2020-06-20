<?php
declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Domain;

class ExtractDomainTest extends TestCase
{
    /**
     * 検証内容: 「https」かつ最後に'/'無しのパターン
     * 入力値: 'https://google.com'
     * 期待値: 'google.com'
     */
    public function testExtractDomain1()
    {
        $actual = Domain::extractDomainName('https://google.com');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: 「https」かつ最後に'/'有りのパターン
     * 入力値: 'https://google.com/'
     * 期待値: 'google.com'
     */
    public function testExtractDomain2()
    {
        $actual = Domain::extractDomainName('https://google.com/');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: 「http」かつ最後に'/'無しのパターン
     * 入力値: 'http://google.com'
     * 期待値: 'google.com'
     */
    public function testExtractDomain3()
    {
        $actual = Domain::extractDomainName('http://google.com');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: 「http」かつ最後に'/'有りのパターン
     * @input 'http://google.com/'
     * 期待値: 'google.com'
     */
    public function testExtractDomain4()
    {
        $actual = Domain::extractDomainName('http://google.com/');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: パスが付いているパターン
     * 入力値: 'https://google.com/hoge/1'
     * 期待値: 'google.com'
     */
    public function testExtractDomain5()
    {
        $actual = Domain::extractDomainName('https://google.com/hoge/1');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: ポート番号が付いているパターン
     * 入力値: 'https://google.com:443'
     * 期待値: 'google.com'
     */
    public function testExtractDomain6()
    {
        $actual = Domain::extractDomainName('https://google.com:443');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: ポート番号に加え、パスも付いているパターン
     * 入力値: 'https://google.com:443/hoge/1'
     * 期待値: 'google.com'
     */
    public function testExtractDomain7()
    {
        $actual = Domain::extractDomainName('https://google.com:443/hoge/1');

        $this->assertEquals('google.com', $actual);
    }

    /**
     * 検証内容: URL形式になっていない場合
     * 入力値: 'google.com/hoge/1'
     * 期待値: 'google.com/hoge/1'
     */
    public function testExtractDomain8()
    {
        $actual = Domain::extractDomainName('google.com/hoge/1');

        $this->assertEquals('google.com/hoge/1', $actual);
    }

    /**
     * 検証内容: 文字列形式以外の値を渡した時
     * 入力値: 1
     * 期待値: TypeErrorが投げられる
     */
    public function testExtractDomain9()
    {
        $this->expectException(\TypeError::class);
        Domain::extractDomainName(1);
    }
}
