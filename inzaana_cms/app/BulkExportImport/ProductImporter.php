<?php

namespace Inzaana\BulkExportImport;

use KzykHys\CsvParser\CsvParser;

class ProductImporter
{
	const CSV_STORAGE_PATH = 'app/csv/';
	const HEADER_COUNT = 2;	//Top row count that csv file uses for header titles
    const OUT_OF_RANGE_INDEX = -1;
    const JSON_DATA_TITLES = [ 'media' => [ 'type', 'resources' ], 'spec' => [ 'spec_label', 'values', 'view_type' ] ];
    const SUPPORTED_FILE_EXTENSIONS = [ 'csv' ];

	private $__parser;
    private $__productCount = 0;
    private $__headers = [];
    private $__records = [];

	public function __construct($file_csv)//product_inzaana_asset.csv
    {
        $this->__parser = CsvParser::fromFile(str_replace('\\', '\\\\', storage_path(self::CSV_STORAGE_PATH . $file_csv)));
        $this->__headers = $this->getHeaders();
        $this->__records = $this->getRawRecordsExceptHeaders();
        $this->__productCount = $this->getProductsCount();
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
    	foreach($this->__headers as $header)
    	{
    		foreach($header as $columnIndex => $column)
    		{
    			if(empty($column))
    				continue;
    			if($column_title == $column)
    				return $columnIndex;
    		}
    	}
    	return self::OUT_OF_RANGE_INDEX;
    }

    public function getData($columnTitle, $rowIndex)
    {
    	foreach($this->__records as $recordIndex => $record)
    	{
    		if($recordIndex < $rowIndex)
    			continue;
    		$colIndex = $this->getColumnIndex($columnTitle);
    		if($colIndex == self::OUT_OF_RANGE_INDEX)
                throw new \Exception("Data:: Invalid title (" . $columnTitle . ") of product csv data source.");
    		return $record[$colIndex];
    	}
    }

    public function getProductsCount()
    {
    	$productCount = 0;
    	foreach($this->__records as $recordIndex => $record)
    	{
            $productTitle = $this->__headers[0][0];
    		$colIndex = $this->getColumnIndex($productTitle);
    		if($colIndex == -1)
    			throw new \Exception("ProductsCount:: Invalid title (" . $productTitle . ") of product csv data source.");
    		if(!empty($record[$colIndex]))
    			$productCount++;
    	}
    	return $productCount;
    }

    public function getProductRowIndex($productNum)
    {
        $productCount = 1;
        foreach($this->__records as $recordIndex => $record)
        {
            $productTitle = $this->__headers[0][0];
            $colIndex = $this->getColumnIndex($productTitle);
            if($colIndex == -1)
                throw new \Exception("ProductRowIndex:: Invalid title (" . $productTitle . ") of product csv data source.");
            if(!empty($record[$colIndex]) && ($productCount++ == $productNum))
                return $recordIndex;
        }
        return self::OUT_OF_RANGE_INDEX;
    }

    private function getProductRow($productNum)
    {
        $productRowIndex = $this->getProductRowIndex($productNum);
        $nextProductRowIndex = $this->getProductRowIndex($productNum + 1);

        if($nextProductRowIndex == self::OUT_OF_RANGE_INDEX)
            $nextProductRowIndex = count($this->__records);
        return [ 'index' => $productRowIndex, 'spec_count' => ($nextProductRowIndex - $productRowIndex) ];
    }

    private function getProductSpecs($productRow, $columnTitle, $headerIndex)
    {
        $headerGroupTitle = $this->__headers[0][$headerIndex];
        if(!array_has($productRow, 'index') || !array_has($productRow, 'spec_count') || empty($columnTitle) || empty($headerGroupTitle))
            return [];
        $productSpecCount = $productRow['spec_count'];
        $productRowIndex = $productRow['index'];
        $specs = array();
        for($specIndex = 0; $specIndex < $productSpecCount; ++$specIndex)
        {
            $specLabel = $this->getData($columnTitle, $productRowIndex + $specIndex);
            if(empty($specLabel))
                continue;
            // If sub header is exactly 2 then put the record as single value
            if(count(self::JSON_DATA_TITLES[$headerGroupTitle]) == 2)
            {
                $titleKey = $headerGroupTitle . '.1';
                $specs[$specLabel] = $this->getData(array_get(self::JSON_DATA_TITLES, $titleKey), $productRowIndex + $specIndex);
                continue;
            }
            // If sub header is more than 2 then put the record as single value
            $specs[$specLabel] = [];
            for($subHeaderIndex = 1; $subHeaderIndex < count(self::JSON_DATA_TITLES[$headerGroupTitle]); ++$subHeaderIndex)
            {
                $titleKey = $headerGroupTitle . '.' . $subHeaderIndex;
                $key = array_get(self::JSON_DATA_TITLES, $titleKey);
                $value = $this->getData(array_get(self::JSON_DATA_TITLES, $titleKey), $productRowIndex + $specIndex);
                $specs[$specLabel] = array_add($specs[$specLabel], $key, $value);
            }
        }
        return $specs;       
    }

    public function getProducts()
    {
        $products = array();
        for($productNum = 1; $productNum <= $this->__productCount; $productNum++)
        {
            $productRow = $this->getProductRow($productNum);
            $productRowIndex = $productRow['index'];

            if($productRowIndex == self::OUT_OF_RANGE_INDEX)
                throw new \Exception("Product count is found out of range than the actual from csv data source.");
            $product = array();
            // Non Json Data serialize
            foreach($this->__headers[0] as $columnTitle)
            {
                if(empty($columnTitle) || array_has(self::JSON_DATA_TITLES, $columnTitle))
                    continue;
                $product[$columnTitle] = $this->getData($columnTitle, $productRowIndex);
            }
            // Json Data serialize
            foreach($this->__headers[1] as $headerIndex => $columnTitle)
            {
                if(empty($columnTitle))
                    continue;
                $headerGroupTitle = $this->__headers[0][$headerIndex];
                if(empty($headerGroupTitle))
                    continue;
                $product[$headerGroupTitle] = $this->getProductSpecs($productRow, $columnTitle, $headerIndex);
            }
            $products []= $product;
        }
        return [ 'json' => collect($products)->toJson(), 'raw' => $products ];
    }

    public static function isSupportedExtension($extension)
    {
        foreach(self::SUPPORTED_FILE_EXTENSIONS as $ext)
        {
            if($ext == $extension)
                return true;
        }
        return false;
    }

    public static function getStoragePath()
    {
        return str_replace('\\', '\\\\', storage_path(self::CSV_STORAGE_PATH));
    }
}