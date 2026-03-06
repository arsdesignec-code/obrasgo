
$(".pay_now").on("click",function() {
    $("#request_id").val($(this).attr('data-request-id'));
    $("#provider_name").val($(this).attr('data-provider-name'));
    $("#provider_id").val($(this).attr('data-provider-id'));
    $("#request_amount").val($(this).attr('data-request-amount'));
    $("#commission").val($(this).attr('data-commission'));
    $("#commission_amt").val($(this).attr('data-commission-amt'));
    $("#payable_amt").val($(this).attr('data-payable-amt'));
    $("#bank_name").val($(this).attr('data-bank-name'));
    $("#account_holder").val($(this).attr('data-account-holder'));
    $("#account_type").val($(this).attr('data-account-type'));
    $("#account_number").val($(this).attr('data-account-number'));
    $("#routing_number").val($(this).attr('data-routing-number'));
    $('#payout_modal').modal('show');
});
