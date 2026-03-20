document.addEventListener('DOMContentLoaded', () => {

    // 🔥 FILE NAME UPDATE
    document.querySelectorAll('.file-input input').forEach(input => {
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

    // 🔥 PREVIEW
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
                };

                reader.readAsDataURL(file);
            });

            updateInputFiles();

            // 🔥 FIX ČIA
            const fileName = input.closest('.file-input').querySelector('.file-name');

            if (filesArray.length === 0) {
                fileName.textContent = 'Nuotraukos nepasirinktos';
            } else if (filesArray.length === 1) {
                fileName.textContent = filesArray[0].name;
            } else {
                fileName.textContent = `Pasirinkta failų: ${filesArray.length}`;
            }
        }

        preview.addEventListener('click', function (e) {

            if (e.target.classList.contains('preview-remove')) {

                const index = e.target.dataset.index;

                filesArray.splice(index, 1);

                renderImages();
            }
        });

        function updateInputFiles() {

            const dataTransfer = new DataTransfer();

            filesArray.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;
        }
    }


    const mainInput = document.getElementById('main-image-input');
    const mainPreview = document.getElementById('main-image-preview');

    if (mainInput && mainPreview) {

        mainInput.addEventListener('change', function (e) {

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

        // remove main image
        mainPreview.addEventListener('click', function (e) {

            if (e.target.classList.contains('preview-remove')) {

                mainInput.value = '';
                mainPreview.innerHTML = '';

                // reset text
                mainInput.closest('.file-input')
                    .querySelector('.file-name')
                    .textContent = 'Nuotrauka nepasirinkta';
            }
        });
    }

    // =============================
    // TAG INPUT (CREATE STORY)
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

        // 🔥 auto #
        input.addEventListener("keydown", e => {

            if (e.key === " ") {

                e.preventDefault();

                if (!input.value.endsWith(" ")) {
                    input.value += " ";
                }

                input.value += "#";
            }
        });

        // 🔥 main logic
        input.addEventListener("input", () => {

            let words = input.value.split(" ");
            let last = words[words.length - 1];

            // jei pradedi naują žodį be #
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
                div.classList.add("tag-suggestion"); // 🔥 pakeitėm klasę
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

        // 🔥 close on outside click
        document.addEventListener("click", e => {

            if (!input.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.innerHTML = "";
            }
        });
    }

});