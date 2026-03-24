document.addEventListener('DOMContentLoaded', () => {

    // =============================
    // FILE NAME UPDATE
    // =============================

    document.querySelectorAll('.file-input input:not(#gallery-input)').forEach(input => {
        input.addEventListener('change', function () {

            let text = 'Nuotrauka nepasirinkta';

            if (this.files.length === 1) {
                text = this.files[0].name;
            }

            if (this.files.length > 1) {
                text = `Pasirinkta failų: ${this.files.length}`;
            }

            this.closest('.file-input')
                .querySelector('.file-name')
                .textContent = text;
        });
    });


    // =============================
    // GALLERY PREVIEW (NEW FILES)
    // =============================

    const input = document.getElementById('gallery-input');
    const preview = document.getElementById('image-preview');

    let filesArray = [];

    if (input && preview) {

        input.addEventListener('change', function (e) {

            const newFiles = Array.from(e.target.files);

            filesArray = [...filesArray, ...newFiles].filter((file, index, self) =>
                index === self.findIndex(f => f.name === file.name && f.size === file.size)
            );

            renderImages();
        });

        function renderImages() {

            preview.innerHTML = '';

            filesArray.forEach((file, index) => {

                const reader = new FileReader();

                reader.onload = function (e) {

                    const div = document.createElement('div');
                    div.classList.add('preview-item');

                    div.innerHTML = `
                <img src="${e.target.result}">
                <div class="preview-remove" data-index="${index}">×</div>
            `;

                    preview.appendChild(div);

                    // 🔥 čia update po kiekvieno append
                    updateGalleryText();
                };

                reader.readAsDataURL(file);
            });

            updateInputFiles();
        }

        preview.addEventListener('click', function (e) {

            if (!e.target.classList.contains('preview-remove')) return;

            const index = e.target.dataset.index;

            filesArray.splice(index, 1);

            renderImages();
        });

        function updateInputFiles() {

            const dataTransfer = new DataTransfer();

            filesArray.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;
        }
    }


    // =============================
    // MAIN IMAGE PREVIEW
    // =============================

    const mainInput = document.getElementById('main-image-input');
    const mainPreview = document.getElementById('main-image-preview');

    if (mainInput && mainPreview) {

        mainInput.addEventListener('change', function (e) {

            const existingMain = document.querySelector('[data-main-existing]');
            if (existingMain) existingMain.remove();

            mainPreview.innerHTML = '';

            const file = e.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {

                const div = document.createElement('div');
                div.classList.add('preview-item');

                div.innerHTML = `
            <img src="${e.target.result}">
            <div class="preview-remove">×</div>
        `;

                mainPreview.appendChild(div);
            };

            reader.readAsDataURL(file);
        });

        mainPreview.addEventListener('click', function (e) {

            if (!e.target.classList.contains('preview-remove')) return;

            mainInput.value = '';
            mainPreview.innerHTML = '';

            mainInput.closest('.file-input')
                .querySelector('.file-name')
                .textContent = 'Nuotrauka nepasirinkta';
        });
    }


    // =============================
    // TAG INPUT (ONLY CREATE)
    // =============================

    const page = document.body.dataset.page;

    if (page === "create-story") {

        const input = document.getElementById("tags-input");
        const suggestions = document.getElementById("tags-suggestions");
        const hidden = document.getElementById("tags-hidden");

        if (!input || !suggestions || !hidden) return;

        let tags = [];

        fetch("/tags-json")
            .then(res => res.json())
            .then(data => tags = data);

        input.addEventListener("keydown", e => {

            if (e.key === " ") {

                e.preventDefault();

                if (!input.value.endsWith(" ")) {
                    input.value += " ";
                }

                input.value += "#";
            }
        });

        input.addEventListener("input", () => {

            let words = input.value.split(" ");
            let last = words[words.length - 1];

            if (last && !last.startsWith("#")) {
                words[words.length - 1] = "#" + last;
                input.value = words.join(" ");
            }

            const lastWord = input.value.split(" ").pop().replace("#", "");

            if (lastWord.length < 1) {
                suggestions.innerHTML = "";
                hidden.value = input.value;
                return;
            }

            const filtered = tags.filter(tag =>
                tag.toLowerCase().startsWith(lastWord.toLowerCase())
            );

            suggestions.innerHTML = "";

            filtered.slice(0, 5).forEach(tag => {

                const div = document.createElement("div");
                div.classList.add("tag-suggestion");
                div.innerText = "#" + tag;

                div.onclick = () => {

                    let parts = input.value.split(" ");
                    parts.pop();

                    parts.push("#" + tag);

                    input.value = parts.join(" ") + " ";

                    hidden.value = input.value;

                    suggestions.innerHTML = "";
                };

                suggestions.appendChild(div);
            });

            hidden.value = input.value;
        });

        document.addEventListener("click", e => {
            if (!input.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.innerHTML = "";
            }
        });
    }


    // =============================
    // EXISTING IMAGES REMOVE (EDIT)
    // =============================

    document.addEventListener('click', (e) => {

        if (!e.target.classList.contains('existing-remove')) return;

        const wrapper = e.target.closest('.preview-item');
        const checkbox = wrapper.querySelector('input[type="checkbox"]');

        if (checkbox) {
            checkbox.checked = true;
        }

        wrapper.remove();

        updateGalleryText();
    });


    // =============================
    // MAIN IMAGE REMOVE (EDIT)
    // =============================

    document.addEventListener('click', (e) => {

        if (!e.target.classList.contains('main-remove')) return;

        const deleteInput = document.getElementById('delete-main-image');

        if (deleteInput) {
            deleteInput.value = 1;
        }

        const wrapper = e.target.closest('.preview-item');
        if (wrapper) wrapper.remove();

        // 🔥 RESET TEXT
        const mainInput = document.getElementById('main-image-input');

        if (mainInput) {
            mainInput.value = '';

            mainInput.closest('.file-input')
                .querySelector('.file-name')
                .textContent = 'Nuotrauka nepasirinkta';
        }
    });


    // =============================
    // GALLERY TEXT UPDATE (EDIT + CREATE)
    // =============================

    function updateGalleryText() {

        const fileName = document.querySelector('#gallery-input')
            ?.closest('.file-input')
            ?.querySelector('.file-name');

        if (!fileName) return;

        // 🔥 tik gallery existing (ne main!)
        const existing = document.querySelectorAll('[data-gallery-existing] .preview-item').length;

        // 🔥 naujai pridėtos
        const newFiles = document.querySelectorAll('#image-preview .preview-item').length;

        const total = existing + newFiles;

        if (total === 0) {
            fileName.textContent = 'Nuotraukos nepasirinktos';
        } else if (total === 1) {
            fileName.textContent = '1 nuotrauka';
        } else {
            fileName.textContent = `Nuotraukų: ${total}`;
        }
    }

});