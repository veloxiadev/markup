<?php

namespace Veloxia\Markup\Tests;

use Orchestra\Testbench\TestCase;
use Veloxia\Markup\MarkupServiceProvider;
use Veloxia\Markup\MarkupFacade as Markup;

class FAQMarkupTest extends TestCase
{

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
        $this->assertEquals("FAQPage", $array['_type']);
        $this->assertEquals("https://schema.org", $array['_context']);
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
            $this->assertEquals("Question", $q->_type);
            $this->assertEquals("Answer", $q->acceptedAnswer->_type);
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

        $this->assertEquals("QA", $data['mainEntity'][0]->name);
        $this->assertEquals("QD", $data['mainEntity'][3]->name);
        $this->assertEquals("QB", $data['mainEntity'][1]->name);
        $this->assertEquals("QC", $data['mainEntity'][2]->name);
        $this->assertEquals("AA", $data['mainEntity'][0]->acceptedAnswer->text);
        $this->assertEquals("AD", $data['mainEntity'][3]->acceptedAnswer->text);
        $this->assertEquals("AB", $data['mainEntity'][1]->acceptedAnswer->text);
        $this->assertEquals("AC", $data['mainEntity'][2]->acceptedAnswer->text);
    }
}
