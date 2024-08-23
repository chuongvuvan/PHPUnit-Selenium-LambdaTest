<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use PHPUnit\Framework\Assert;

class LambdaTest extends LambdaTestSetup
{

    public function testAdd()
    {
		try {
			self::$driver->get("https://jobsgo.vn/");

			// Close the modal if it's open
			$modalCloseButton = self::$driver->findElements(WebDriverBy::cssSelector("#cv-modal .btn-close"));
			if (count($modalCloseButton) > 0) {
				$modalCloseButton[0]->click();
				// Wait for the modal to close
				self::$driver->wait(10, 500)->until(WebDriverExpectedCondition::invisibilityOfElementLocated(WebDriverBy::id("cv-modal")));
			}

			// Open the login modal
			$loginButton = self::$driver->findElement(WebDriverBy::cssSelector("[data-bs-target='#loginModal']"));
			$loginButton->click();

			// Wait for the login modal to appear
			self::$driver->wait(10, 500)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id("loginModal")));

//			// Proceed with the rest of your test
//			$element1 = self::$driver->findElement(WebDriverBy::name("li1"));
//			$element1->click();
//
//			$element2 = self::$driver->findElement(WebDriverBy::name("li2"));
//			$element2->click();
//
			$usernameField = self::$driver->findElement(WebDriverBy::id("username"));
			$passwordField = self::$driver->findElement(WebDriverBy::id("password"));

			$usernameField->sendKeys("chuong.vu@jobsgo.vn");
			$passwordField->sendKeys("chundubai");

			// Submit the form
			$submitButton = self::$driver->findElement(WebDriverBy::cssSelector("button[type='submit']"));
			$submitButton->click();

//			$element4 = self::$driver->findElement(WebDriverBy::id("addbutton"));
//			$element4->click();
//
//			self::$driver->wait(10, 500)->until(function($driver) {
//				$elements = $driver->findElements(WebDriverBy::cssSelector("[class='list-unstyled'] li:nth-child(6) span"));
//				return count($elements) > 0;
//			});
//
//			$element5 = self::$driver->findElement(WebDriverBy::cssSelector("[class='list-unstyled'] li:nth-child(6) span"));
//			$this->assertEquals($itemName, $element5->getText());
			self::$driver->wait(10, 500)->until(function($driver) {
				$currentUrl = $driver->getCurrentURL();
				if (strpos($currentUrl, "https://jobsgo.vn/") !== false) {
					return true;
				}
				$errorMessages = $driver->findElements(WebDriverBy::cssSelector(".login-error-message"));
				return count($errorMessages) > 0;
			});

			if (self::$driver->getCurrentURL() === "https://jobsgo.vn/") {
				self::$driver->executeScript("lambda-status=passed");
			} else {
				echo "Login failed: Please check your credentials.";
				self::$driver->executeScript("lambda-status=failed");
			}
		}
		catch (Exception $e) {
			self::$driver->executeScript("lambda-status=failed");
		}
    }

}

?>

