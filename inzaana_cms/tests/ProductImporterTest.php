<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Inzaana\BulkExportImport\ProductImporter;

class ProductImporterTest extends TestCase
{
	const ROUTING_PREFIX = '/products/import';
	const EXPECTED_CSV_FILE = 'product_inzaana_asset.csv';
    const HEADERS = [
        ["product_title","manufacturer_name","product_description","price","product_status","created_at","updated_at","store_product_title","qty","discount","category","media","","spec","",""],
        ["","","","","","","","","","","","type","resources","spec_label","values","view_type"]
    ];

	private $__importer;

	public function setUp()
	{
		parent::setUp();
        $this->__importer = new ProductImporter(self::EXPECTED_CSV_FILE);
	}
    /**
     * A raw csv parsed data retrieval test.
     * 
     * @return void
     */
    public function testGetRawRecords()
    {
        $this->assertNotEquals(0, count($this->__importer->getRawRecords()));
    }

    /**
     * A raw csv parsed raw data retrieval without title headers test.
     * 
     * @return void
     */
    public function testGetRawRecordsExceptHeaders()
    {
        $this->assertNotEquals(0, count($this->__importer->getRawRecordsExceptHeaders()));
    }

    /**
     * A raw csv parsed raw data retrieval only title headers test.
     * 
     * @return void
     */
    public function testGetHeaders()
    {
        $this->assertEquals(self::HEADERS, $this->__importer->getHeaders());
    }

    /**
     * A raw csv parsed column index retrieval from title test.
     * 
     * @return void
     */
    public function testGetColumnIndex()
    {
        $this->assertEquals(0, $this->__importer->getColumnIndex('product_title'));
        $this->assertEquals(7, $this->__importer->getColumnIndex('store_product_title'));

        $this->assertEquals(-1, $this->__importer->getColumnIndex('abc'));
    }

    /**
     * A raw csv parsed cell data retrieval test from title and row index.
     * @expectedException Exception
     * @return void
     */
    public function testGetData()
    {
        $this->assertEquals("s7edge", $this->__importer->getData('product_title', 0));
        $this->assertEquals("s7 exclusive india", $this->__importer->getData('store_product_title', 0));
        $this->assertEquals("", $this->__importer->getData('store_product_title', 1));

        $this->__importer->getData('abc');
    }

    /**
     * A raw csv parsed product count test.
     * //expectedException Exception
     * @return void
     */
    public function testGetProductsCount()
    {
    	$this->assertEquals(1, $this->__importer->getProductsCount());
    	$this->assertNotEquals(2, $this->__importer->getProductsCount());
    	$this->assertNotEquals(0, $this->__importer->getProductsCount());
    }

    /**
     * A raw csv parsed product row index test.
     * //expectedException Exception
     * @return void
     */
    public function testGetProductRowIndex()
    {
        $this->assertEquals(0, $this->__importer->getProductRowIndex(1));
        $this->assertEquals(-1, $this->__importer->getProductRowIndex(2));
        $this->assertNotEquals(0, $this->__importer->getProductRowIndex(-1));
    }

    /**
     * A response to get raw csv parsed data test.
     * 
     * @return void
     */
    public function testResponseGetRawRecordsExceptHeaders()
    {
        $this->withoutMiddleware();
    	$this->visit( self::ROUTING_PREFIX . '/csv/raw/records')
    		 ->assertResponseOk();
    }
}
