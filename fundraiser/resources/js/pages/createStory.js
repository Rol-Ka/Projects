document.addEventListener("DOMContentLoaded", () => {

    const page = document.body.dataset.page;
    if (page !== "create-story") return;

    const input = document.getElementById("tags-input");
    const suggestions = document.getElementById("tags-suggestions");
    const hidden = document.getElementById("tags-hidden");

    let tags = [];

    fetch("/tags-json")
        .then(res => res.json())
        .then(data => tags = data);


    // kai pradedi rašyti naują žodį → automatiškai prideda #
    input.addEventListener("keydown", e => {

        if (e.key === " ") {

            e.preventDefault();

            if (!input.value.endsWith(" ")) {
                input.value += " ";
            }

            input.value += "#";

        }

    });


    // kai input tuščias ir pradedi rašyti → prideda #
    input.addEventListener("input", () => {

        if (input.value.length === 1 && !input.value.startsWith("#")) {
            input.value = "#" + input.value;
        }


        // autocomplete
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
            div.classList.add("tag-item");
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

});