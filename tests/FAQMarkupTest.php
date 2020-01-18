<?php

namespace Veloxia\Markup\Tests;

use __PHP_Incomplete_Class;
use Orchestra\Testbench\TestCase;
use Veloxia\Markup\MarkupServiceProvider;
use Veloxia\Markup\MarkupFacade as Markup;

class FAQMarkupTest extends TestCase
{

    /**
     * Change this if the tests are failing even though the output is fine.
     */
    public const EXPECTED_CHECKSUM = "ea8b755b43b598275c5bda5fd6ba6817eef30f8a";

    protected function getPackageProviders($app)
    {
        return [MarkupServiceProvider::class];
    }

    public function test_if_phpunit_works()
    {
        $this->assertTrue(true);
        $this->assertFalse(!true);
    }

    public function test_if_faq_module_is_alive()
    {
        $faq = Markup::make("FAQ");
        $this->assertIsObject($faq);
    }

    public function test_adding_items_to_faq()
    {
        $faq = Markup::make("FAQ");
        $faq->question("Hello")->answer("World");
        $faq->question("Varför")->answer("Funkar det helt plötsligt?");

        $array = $faq->dump();
        $this->assertNotNull($array);
        $this->assertEquals("FAQPage", $array['@type']);
        $this->assertEquals("https://schema.org", $array['@context']);
    }

    public function test_if_faq_contains_added_items()
    {

        $questions = [
            'A' => '1',
            'B' => '2',
            'C' => '3',
            'D' => '4',
        ];

        $faq = Markup::make("FAQ");
        foreach ($questions as $qu => $an) {
            $faq->question($qu)->answer($an);
        }
        foreach ($faq->dump()['mainEntity'] as $q) {
            $this->assertEquals("Question", $q['@type']);
            $this->assertEquals("Answer", $q['acceptedAnswer']['@type']);
        }
    }

    public function test_if_faq_maintains_order()
    {

        $questions = [
            'QA' => 'AA',
            'QB' => 'AB',
            'QC' => 'AC',
            'QD' => 'AD',
        ];

        $faq = Markup::make("FAQ");
        foreach ($questions as $qu => $an) {
            $faq->question($qu)->answer($an);
        }

        $data = $faq->dump();

        $this->assertEquals("QA", $data['mainEntity'][0]['name']);
        $this->assertEquals("QD", $data['mainEntity'][3]['name']);
        $this->assertEquals("QB", $data['mainEntity'][1]['name']);
        $this->assertEquals("QC", $data['mainEntity'][2]['name']);
        $this->assertEquals("AA", $data['mainEntity'][0]['acceptedAnswer']['text']);
        $this->assertEquals("AD", $data['mainEntity'][3]['acceptedAnswer']['text']);
        $this->assertEquals("AB", $data['mainEntity'][1]['acceptedAnswer']['text']);
        $this->assertEquals("AC", $data['mainEntity'][2]['acceptedAnswer']['text']);
    }

    public function test_if_something_has_changed()
    {
        $faq = new \Veloxia\Markup\Generators\FAQ([

            'composer test' => 'PHPUnit 8.5.2 by Sebastian Bergmann and contributors.',

            'A longer question?' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ]);

        $today = date('Ymd');
        $fileName = __DIR__ . '/.test-faq-' . $today . '.html';

        file_put_contents($fileName, $faq->json());

        $sha1 = sha1_file($fileName);

        $this->assertEquals(self::EXPECTED_CHECKSUM, $sha1, "The checksums of the generated test file (" . $fileName . ") and the previous checksum do not match. Expected " . self::EXPECTED_CHECKSUM . ", got " . $sha1 . ". Please check if the test json output looks ok and change self::EXPECTED_CHECKSUM located in " . __FILE__ . ".");
    }
}
