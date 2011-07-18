<?php

/**
 * Description of sfWidgetFormSchemaFormatterLogin
 *
 * @author jp
 */
class sfWidgetFormSchemaFormatterLogin extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<td>\n  %label%\n  %field%\n%hidden_fields%%error%</td>\n",
    $errorRowFormat  = "<tr>\n%errors%</tr>\n",
    $helpFormat      = '',
//    $errorListFormatInARow     = "  <tr class=\"error_list\">\n%errors%  </tr>\n",
    $errorRowFormatInARow      = "    <td>%error%</td>\n",
//    $namedErrorRowFormatInARow = "    <td>%name%: %error%</td>\n",
    $decoratorFormat = "<table><tr>\n  %content%</tr></table>";
  
  /*public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
    $row = parent::formatRow(
      $label,
      $field,
      $errors,
      $help,
      $hiddenFields
    );
 
    return strtr($row, array(
      '%row_class%' => (count($errors) > 0) ? ' form_row_error' : '',
    ));
  }*/
}


?>
