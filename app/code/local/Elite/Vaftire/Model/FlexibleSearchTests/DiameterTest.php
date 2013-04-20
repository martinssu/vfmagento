<?php
class Elite_Vaftire_Model_FlexibleSearchTests_DiameterTest extends Elite_Vaf_TestCase
{
    function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        $this->assertEquals( 16, $flexibleSearch->diameter(), 'should get diameter from request' );
    }
    
    function testShouldInSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 16, $this->flexibleTireSearch()->diameter(), 'should store diameter in session' );
	}
	
	function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'0', 'aspect_ratio'=>'0', 'diameter'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleTireSearch()->diameter(), 'should clear diameter from session' );
    }
}