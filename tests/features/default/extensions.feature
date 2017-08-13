Feature: Extensions listing & details

  Scenario: test menu & homepage
	Given I am on the homepage
	Then I should see "Official extensions"
	And I should see "Community extensions"
	And the "h1" element should contain "atoum's extensions"
	And the "nav#menu" element should contain "about"
	And the "div#sidebar" element should contain "about"
	And the "nav#menu" element should contain "news"
	And the "div#sidebar" element should contain "news"
	And the "nav#menu" element should contain "documentation"
	And the "div#sidebar" element should contain "documentation"
	And the "div.extension-list" element should contain "autoloop"
	And the "div.extension-list" element should contain "autoloop"
	And the "div.extension-list" element should contain "blackfire"
	And the "div.extension-list" element should contain "blackfire"
	And the "div.extension-list" element should contain "reports"
	And the "div.extension-list" element should contain "reports"

  Scenario: list of extensions
	When I am on "/extensions/autoloop"
	Then the response status code should be 200
	And the response should contain "autoloop-extension is released under the MIT License. See the bundled LICENSE file for details."

	When I am on "/extensions/blackfire"
	Then the response status code should be 200
	And the response should contain "blackfire-extension is released under the MIT License. See the bundled LICENSE file for details."

	When I am on "/extensions/reports"
	Then the response status code should be 200
	And the response should contain "reports-extension is released under the BSD-3-Clause License. See the bundled"

	When I am on "/extensions/-not-exists"
	Then the response status code should be 404
	And the response should contain "It seems that the extension you are looking for are not found."
	And the response should contain "-not-exists"

  Scenario: non existing page
	When I am on "/lost-in-nowhere"
	Then the response status code should be 404
