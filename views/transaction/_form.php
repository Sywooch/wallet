<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\contractor\Contractor;
/* @var $this yii\web\View */
/* @var $model app\models\transaction\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
$(function() {
    var generateNewId = function(type) {
        var prefix = "new_" + type + "_";
        var newId = "";
        do {
            newId = prefix + Math.random().toString(36).slice(10)
        } while ($('[data-key="' + type + '-' + newId + '"').length > 0);
        return newId;
    };
    
    var replaceNewId = function(div, type) {
        var text = div.html();
        var newId = generateNewId(type);
        div.html(text.split('%%newid%%').join(newId));
        return div;
    }
    
    $('[role="add-incoming"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('[role="transaction-details-add"] [role="new-incoming"]').clone();
        div.removeAttr('role');
        div = replaceNewId(div, 'incoming');
        div.appendTo('[role="transaction-details"] [role="transaction-details-incoming"]');
    });
    $('[role="add-outgoing"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('[role="transaction-details-add"] [role="new-outgoing"]').clone();
        div.removeAttr('role');
        div = replaceNewId(div, 'outgoing');
        div.appendTo('[role="transaction-details"] [role="transaction-details-outgoing"]');
    });
    $('[role="add-expense"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('[role="transaction-details-add"] [role="new-expense"]').clone();
        div.removeAttr('role');
        div = replaceNewId(div, 'expense');
        div.appendTo('[role="transaction-details"] [role="transaction-details-expense"]');
    });
    $('select[name="Transaction[expenceContractorId]"]').change(function () {
        var val = $(this).val();
        $('select[role="expense-contractor"]').each(function() {
            $(this).val(val);
        });
    });
})
</script>

<?php 
    include (__DIR__ . "/_form_" . $model->type . ".php");
?>
