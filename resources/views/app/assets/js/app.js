$(function() {
    /*
    *   WALLETS
    */
    $('.btn-overlay-open').click(function() {
        $(".wallet-overlay").slideDown(400).css("display", "flex");
    });
    $('.btn-overlay-close').click(function() {
        console.log($(this).data('id'));
    })
    $('.wallet-remove').click(function() {
        $("#" + $(this).data('id')).submit();
    })
})
