<?php

/**
 * Description of sfWidgetFormDoctrineJQueryAutocompleterAndClear
 *
 * @author    Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 * @version   22 mars 2010 15:53:55
 */
class sfWidgetFormDoctrineJQueryAutocompleterAndClear extends sfWidgetFormDoctrineJQueryAutocompleter
{
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return parent::render($name, $value, $attributes, $errors).
           ' <img src="'.$this->getImage().'" alt="" id="'.$this->getDeleteId($name).'" />'.
           sprintf(<<<EOF
<script type="text/javascript">
  $("#%s").bind("mouseover", function(e){
    $("#%s")[0].style.cursor = "pointer";
  });
  $("#%s").bind("click", function(e){
    $("#%s")[0].value = "";
    $("#%s")[0].value = "";
    return false;
  });

</script>
EOF
      ,
      $this->getDeleteId($name),
      $this->getDeleteId($name),
      $this->getDeleteId($name),
      $this->generateId('autocomplete_'.$name),
      $this->generateId($name)
    );
  }

  private function getDeleteId($value)
  {
    return $this->generateId("delete_autocomplete_value_".$value);
  }

  private function getImage()
  {
    return "/images/icon/minus.png";
  }
}
?>
