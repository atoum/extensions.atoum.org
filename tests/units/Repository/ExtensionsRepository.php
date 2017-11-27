<?php

namespace tests\units\atoum\ExtensionsWebsite\Repository;

class ExtensionsRepository extends \atoum
{
	public function testEmptyRepository()
	{
		$this
			->given($this->newTestedInstance([]))
			->then(
				$this->array($this->testedInstance->getExtensionsGroups())->isEmpty,
				$this->variable($this->testedInstance->findUrl('foo'))->isNull
			)
		;
	}

	public function testExtensionGroups(array $extensions)
	{
		$this
			->given($this->newTestedInstance($extensions))
			->then(
				$this->array($this->testedInstance->getExtensionsGroups())
					->isIdenticalTo($extensions),
				$this->variable($this->testedInstance->findUrl('baz-foo'))
					->isIdenticalTo($extensions[ 0 ][ 'extensions' ][ 1 ])
			)
		;
	}

	protected function testExtensionGroupsDataProvider()
	{
		return [
			[
				[
					[
						'label' => 'Foo bar',
						'extensions' => [
							[
								'label' => 'bar-baz',
								'url' => 'http://example.tld/foo/bar/README.md',
								'github_link' => 'http://example.tld/foo/bar',
							],
							[
								'label' => 'baz-foo',
								'url' => 'http://example.tld/bar/foo/README.md',
								'github_link' => 'http://example.tld/bar/foo',
							],
						],
					],
				],
			],
		];
	}
}
