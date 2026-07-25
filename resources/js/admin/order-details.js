$(function () {
    $(document).on('click', '.js-order-view', function () {
        const orderId = $(this).data('order-id');

        openModal('#orderDetailsModal');
        $('#orderDetailsBody').html(`
            <div class="flex items-center justify-center h-full text-gray-400">
                <i class="fa-solid fa-spinner fa-spin text-2xl"></i>
            </div>
        `);

        $.get(`/admin/orders/${orderId}`, function (order) {
            renderOrderDetails(order);
        }).fail(function () {
            $('#orderDetailsBody').html(`
                <div class="flex items-center justify-center h-full text-red-500 text-sm">
                    Erreur lors du chargement de la commande.
                </div>
            `);
        });
    });

    function renderOrderDetails(order) {
        $('#orderDetailsCode').text(order.order_code);
        // full render function comes next once table + controller are in place
    }
});