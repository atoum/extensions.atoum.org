<?php

namespace tests\units\atoum\ExtensionsWebsite\Repository;

class ExtensionsRepository extends \atoum
{
	public function testExtensionGroups()
	{
		$this->newTestedInstance([]);
		$this->array($this->testedInstance->getExtensionsGroups())->isEmpty;
	}
}
