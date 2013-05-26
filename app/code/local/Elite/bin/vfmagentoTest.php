<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class vfmagentoTest extends VF_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year',true);
        $this->dropAndRecreateMockProductTable();
    }

    function testShouldImportFitments()
    {
        $this->query("INSERT INTO test_catalog_product_entity ( `sku` ) values ( 'sku123' )");
        $productID = $this->getReadAdapter()->lastInsertId();

        $file = sys_get_temp_dir().'/'.uniqid();

        $data = "sku,make,model,year\n";
        $data .= "sku123,Honda,Civic,2000";
        file_put_contents($file,$data);

        $command = MAGE_PATH . '/app/code/local/Elite/bin/vfmagento --product-table=test_catalog_product_entity '.$file;
        `$command`;

        $exists = $this->vehicleExists(array(
            'make'=>'Honda',
            'model'=>'Civic',
            'year'=>2000
        ));
        $this->assertTrue($exists, 'should import vehicles');

        $product = new VF_Product;
        $product->setId($productID);

        $fitments = $product->getFitModels();
        $this->assertEquals('Honda Civic 2000', $fitments[0]->__toString(), 'should import fitment');
    }


}
