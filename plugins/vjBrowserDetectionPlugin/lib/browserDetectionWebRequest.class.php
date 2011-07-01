<?php

/**
 * This class is designed for browser detection. It extends sfWebRequest and so,
 * it's integrated to symfony request
 *
 * @author    Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 * @version   22 avr. 2010 10:22:19
 */
class browserDetectionWebRequest extends sfWebRequest
{
  protected $browser = null;

  /**
   * Return $_SERVER['HTTP_USER_AGENT']
   *
   * @return string the http_user_agent
   */
  public function getUserAgent()
  {
    $pathArray = $this->getPathInfoArray();

    return isset($pathArray['HTTP_USER_AGENT']) ? $pathArray['HTTP_USER_AGENT'] : '';
  }

  /**
   * Load browsers file and parse it
   *
   * @return array Browsers list
   */
  public function getBrowsers()
  {
    //$list = sfYaml::load(sfConfig::get('sf_plugins_dir').'/vjBrowserDetectionPlugin/config/browsers.yml');
    $list = sfYaml::load(sfConfig::get('app_vjBrowserDetectionPlugin_browsers_file'));
    return $list['all'];
  }

  /**
   * Set user's browser's datas
   */
  protected function setBrowser()
  {
    if($this->browser == null)
    {
      $agent = $this->getUserAgent();
      $this->browser = 'unknown';
      $flag = false;
      foreach($this->getBrowsers() as $id => $content)
      {
        if(strstr($agent, $id) && $flag === false)
        {
          $this->browser = $content;
          $flag = true;
        }
      }
    }
  }

  /**
   * Get user's browser's datas
   *
   * @return array The user's browser's datas
   */
  public function getBrowser()
  {
    $this->setBrowser();
    return $this->browser;
  }

  /**
   * Get one of the three informations from user's browser's datas
   *
   * @param string $info 'br' or 'name' or 'version' (browser's datas)
   * @return string Browser data for info entry
   */
  public function getBrowserInformation($info = "br")
  {
    $this->setBrowser();
    return $this->browser[$info];
  }

  /**
   * If user's browser in Internet Explorer
   *
   * @return boolean True if user's browser is Internet Explorer otherwise false
   */
  public function isIEBrowser()
  {
    return (strstr($this->getBrowserInformation('name'), 'Internet Explorer')) ? true: false;
  }

  /**
   * If user's browser's version of Internet Explorer is the version passed on parameter
   *
   * @param int $version
   * @return boolean True if user's browser's version of Internet Explorer is version otherwise false
   */
  public function isIEBrowserVersion($version = 6)
  {
    if($this->isIEBrowser())
    {
      return ($this->getBrowserInformation('version') == $version) ? true: false;
    }
    return false;
  }
}
?>
