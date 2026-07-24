$(function () {
    const MAX_IMAGES = 15;
    let selectedFiles = [];

    const $dropZone = $('#dropZone');
    const $input = $('#imagesInput');
    const $primaryIndex = $('#primary_image')
    const $preview = $('#imagesPreview');
    const $count = $('#imagesCount');

    // Click / native file picker
    $input.on('change', function (e) {
        handleFiles(e.target.files);
    });

    // Drag & drop visuals + drop handling
    $dropZone.on('dragover', function (e) {
        e.preventDefault();
        $(this).addClass('border-amani bg-amani/5');
    });

    $dropZone.on('dragleave', function (e) {
        e.preventDefault();
        $(this).removeClass('border-amani bg-amani/5');
    });

    $dropZone.on('drop', function (e) {
        e.preventDefault();
        $(this).removeClass('border-amani bg-amani/5');
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    function handleFiles(files) {
        const allowed = ['image/png', 'image/jpeg', 'image/jpg'];

        Array.from(files).forEach(file => {
            if (!allowed.includes(file.type)) return; // skip invalid types
            if (selectedFiles.length >= MAX_IMAGES) return; // respect max

            selectedFiles.push(file);
        });

        renderPreview();
        syncInputFiles();
    }

    function renderPreview() {
        $preview.empty();

        selectedFiles.forEach((file, index) => {
            const url = URL.createObjectURL(file);

            const $item = $(`
                <div class="js-primary-image relative group aspect-square rounded-lg overflow-hidden border border-gray-200 cursor-pointer ${ index == $primaryIndex.val() && 'ring-2 ring-amani shadow-md shadow-amani/50' }" 
                    data-index="${index}">
                    <img src="${url}" class="w-full h-full object-cover">
                    <button type="button" data-index="${index}"
                            class="js-remove-image cursor-pointer absolute top-1 right-1 w-6 h-6 rounded-full
                                   bg-white/90 text-red-600 flex items-center justify-center
                                   opacity-0 group-hover:opacity-100 transition shadow-sm">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                    <div class="js-primary-image cursor-pointer absolute top-1 left-1 w-6 h-6 rounded-full
                                   bg-white/90 text-red-600 flex items-center justify-center
                                   opacity-0 group-hover:opacity-100 transition shadow-sm">
                        ${ index == $primaryIndex.val() ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>'}
                    </div>
                </div>
            `);

            $preview.append($item);
        });

        $count.text(selectedFiles.length + ' / ' + MAX_IMAGES);

        // Hide drop zone hint once at max
        $dropZone.toggleClass('opacity-50 pointer-events-none', selectedFiles.length >= MAX_IMAGES);
    }

    // Remove a single image
    $(document).on('click', '.js-remove-image', function () {
        const index = $(this).data('index');
        selectedFiles.splice(index, 1);
        renderPreview();
        syncInputFiles();
    });

    // Rebuild the actual <input type="file"> so the form submits the current (filtered) selection
    function syncInputFiles() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        $input[0].files = dataTransfer.files;
    }

    // Change Primary Image
    $(document).on('click', '.js-primary-image', function () {
        const index = $(this).data('index');
        $primaryIndex.val(index)
        renderPreview();
        syncInputFiles();
    });
});