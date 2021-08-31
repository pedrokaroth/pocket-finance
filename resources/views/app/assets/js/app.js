$(function() {
    /*
    *   WALLETS
    */
    $('.btn-overlay-open').click(function() {
        $(".wallet-overlay").slideDown(400).css("display", "flex");
    });
    $('.btn-overlay-close').click(function() {
        $(".wallet-overlay").slideUp(400);
    })
    $('.wallet-remove').click(function() {
        $("#" + $(this).data('id')).submit();
    })
    $('.wallet-name').change(function() {
        $(this).parent().submit();
    })
    $(".wallet-dropdown").mouseenter(function () {
        $(this).find("ul").slideDown(200);
    }).mouseleave(function () {
        $(this).find("ul").slideUp(200);
    });
    $('.wallet-change').click(function() {
        const wallet = $(this).data('wallet');
        const endpoint = $(this).data('endpoint');

        $.post(endpoint, {wallet: wallet}, function() {
            window.location.reload();
        }, "json")

    })
})
