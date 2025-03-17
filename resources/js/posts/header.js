document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("search_button");
    const searchInput = document.querySelector(".search_input");

    submitButton.addEventListener("click", () => {
        const value = searchInput.value.trim();

        if (!value) {
            alert("Veuillez entrer un terme de recherche.");
            return;
        }

        fetch("http://127.0.0.1:8000/posts/search", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ search_value: value }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.success) {
                    window.location.href = "/posts/search-results"; // Redirect if search is successful
                } else {
                    alert("Aucun résultat trouvé.");
                }
            })
            .catch((error) => console.error("Erreur:", error));

        searchInput.value = ""; // Clear input only after making the request
    });
});
