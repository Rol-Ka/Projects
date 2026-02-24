document.addEventListener("DOMContentLoaded", () => {

    const input = document.querySelector('input[name="tags_text"]');
    if (!input) return;

    let allTags = [];

    const suggestionBox = document.createElement('ul');
    suggestionBox.style.border = "1px solid #ccc";
    suggestionBox.style.display = "none";
    suggestionBox.style.listStyle = "none";
    suggestionBox.style.padding = "5px";
    suggestionBox.style.marginTop = "0";
    suggestionBox.style.position = "absolute";
    suggestionBox.style.background = "white";
    suggestionBox.style.zIndex = "1000";

    input.parentNode.appendChild(suggestionBox);

    fetch('/tags-json')
        .then(res => res.json())
        .then(data => allTags = data);

    input.addEventListener("input", () => {

        const parts = input.value.split('#');
        const last = parts.pop().toLowerCase().trim();

        if (!last) {
            suggestionBox.style.display = "none";
            return;
        }

        const matches = allTags
            .filter(tag => tag.startsWith(last))
            .slice(0, 5);

        suggestionBox.innerHTML = "";

        matches.forEach(tag => {
            const li = document.createElement("li");
            li.textContent = "#" + tag;
            li.style.cursor = "pointer";
            li.style.padding = "3px";

            li.onclick = () => {
                const newParts = input.value.split('#');
                newParts.pop();
                input.value = newParts.join('#') + "#" + tag + " ";
                suggestionBox.style.display = "none";
            };

            suggestionBox.appendChild(li);
        });

        suggestionBox.style.display = matches.length ? "block" : "none";
    });

    document.addEventListener("click", (e) => {
        if (!suggestionBox.contains(e.target) && e.target !== input) {
            suggestionBox.style.display = "none";
        }
    });
});