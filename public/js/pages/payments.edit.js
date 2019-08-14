
$(document).ready(function() {

    $('#amount_taxable').on('keyup keypress blur change', function() {
        var base = parseFloat($(this).val());
        var result = 0;
        if (base && !isNaN(base)) {
            result = base * rate_value;
        }
        $('#amount_pay').val(result);
    });

    if ($('#amount_taxable').val() !== '') {
        $('#amount_taxable').change();
    }
});
