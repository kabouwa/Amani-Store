$(function () {
    $(document).on('click', '.js-viewable', function () {
        const src = $(this).attr('src');
        const alt = $(this).attr('alt') || '';

        $('#imageViewerImg').attr('src', src).attr('alt', alt);
        openImageViewer();
    });

    $('#imageViewerClose').on('click', closeImageViewer);

    // Click backdrop (but not the image itself) to close
    $('#imageViewerModal').on('click', function (e) {
        if (e.target.id === 'imageViewerModal') {
            closeImageViewer();
        }
    });

    // Close on Escape
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') closeImageViewer();
    });

    function openImageViewer() {
        $(document.body).css('overflow','hidden')
        $('#imageViewerModal').removeClass('hidden').addClass('flex');
        setTimeout(() => {
            $('#imageViewerImg').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
        }, 10);
    }

    function closeImageViewer() {
        $(document.body).css('overflow','auto')
        $('#imageViewerImg').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        setTimeout(() => {
            $('#imageViewerModal').removeClass('flex').addClass('hidden');
        }, 200);
    }

});