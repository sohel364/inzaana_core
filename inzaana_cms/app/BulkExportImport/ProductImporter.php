<?php

namespace Inzaana\BulkExportImport;

use KzykHys\CsvParser\CsvParser;

class ProductImporter
{

	const CSV_STORAGE_PATH = 'app/csv/';
	const HEADER_COUNT = 2;	//Top row count that csv file uses for header titles
	const HEADERS = [
		["product_title","manufacturer_name","product_description","price","product_status","created_at","updated_at","store_product_title","qty","discount","category","media","","spec","",""],
		["","","","","","","","","","","","type","values","spec_label","values","type"]
	];

	private $__parser;

	public function __construct($file_csv)//product_inzaana_asset.csv
    {
        $this->__parser = CsvParser::fromFile(str_replace('\\', '\\\\', storage_path(self::CSV_STORAGE_PATH . $file_csv)));
    }

    public function getRawRecords()
    {
    	$records = array();
        foreach ($this->__parser as $record)
        {
        	$records []= $record;
        }
        return $records;
    }

    public function getRawRecordsExceptHeaders()
    {
    	$records = array();
    	$headerCount = 1;
    	foreach ($this->getRawRecords() as $record) {
    		if($headerCount++ <= self::HEADER_COUNT)
    			continue;
        	$records []= $record;
    	}
        return $records;
    }

    public function getHeaders()
    {
    	$records = array();
    	$headerCount = 1;
    	foreach ($this->getRawRecords() as $record) {
    		if($headerCount++ > self::HEADER_COUNT)
    			continue;
        	$records []= $record;
    	}
        return $records;
    }

    public function getColumnIndex($column_title)
    {
    	foreach($this->getHeaders() as $header)
    	{
    		foreach($header as $columnIndex => $column)
    		{
    			if(empty($column))
    				continue;
    			if($column_title == $column)
    				return $columnIndex;
    		}
    	}
    	return -1;
    }

    public function getData($column_title, $rowIndex)
    {
    	foreach($this->getRawRecordsExceptHeaders() as $recordIndex => $record)
    	{
    		if($recordIndex < $rowIndex)
    			continue;
    		$index = $this->getColumnIndex($column_title);
    		if($index == -1)
    			throw new \Exception("Invalid title of product csv data source.");
    		return $record[$index];
    	}
    	// throw new \Exception("Out of range record.");
    }

    public function getProductsCount()
    {
    	$productCount = 0;
    	foreach($this->getRawRecordsExceptHeaders() as $recordIndex => $record)
    	{
    		$index = $this->getColumnIndex(self::HEADERS[0][0]);
    		if($index == -1)
    			throw new \Exception("Invalid title of product csv data source.");
    		if(!empty($record[$index]))
    			$productCount++;
    	}
    	return $productCount;
    }

}