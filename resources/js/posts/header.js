const searchButton = document.getElementById("search_button");

searchButton.addEventListener("click", () => {
    const searchInput = document.querySelector(".search_input");
    const searchValue = searchInput.value.trim();

    if (!searchValue) {
        alert("Veuillez entrer un terme de recherche.");
        return;
    }

    fetch(
        "http://127.0.0.1:8000/posts?search_value=" +
            encodeURIComponent(searchValue),
        {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        }
    )
        .then((response) => {
            if (!response.ok) {
                throw new Error("Failed to fetch data.");
            }
            return response.json();
        })
        .then((data) => {
            const searchResults = document.querySelector(".search_results");

            searchResults.innerHTML = ""; // Clear previous results

            let tableContainer = document.createElement("div");
            tableContainer.classList.add("table-responsive");
            /*
            let searchTitle = document.createElement("h2");
            searchTitle.classList.add("search_value");
            searchTitle.textContent = `Résultats pour ${data.searchValue}`;

            tableContainer.appendChild(searchTitle);
*/
            let tableBody = document.createElement("tbody");
            tableBody.classList.add("table_container");

            let table = document.createElement("table");
            table.classList.add(
                "table",
                "table-striped",
                "table-hover",
                "align-middle"
            );

            tableContainer.appendChild(table);
            table.appendChild(tableBody);

            let tableHeader = `
            <thead class="table-dark">
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Auteur</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
        `;
            table.insertAdjacentHTML("afterbegin", tableHeader);

            if (data.success && data.posts.length > 0) {
                data.posts.forEach((post) => {
                    const row = document.createElement("tr");
                    row.classList.add("post_item");
                    row.setAttribute("data-post-id", post.id);

                    const imageColumn = document.createElement("td");
                    const imageHTML = post.image
                        ? `<div class="text-center my-3">
                        <img src="http://127.0.0.1:8000/storage/${post.image}" class="img-fluid rounded shadow-sm" style="width: 60px; height: 60px;">
                    </div>`
                        : `<div class="text-center my-3">
                        <img src="images/default-image.webp" class="img-fluid rounded shadow-sm" style="width: 60px; height: 60px;">
                    </div>`;
                    imageColumn.innerHTML = imageHTML;

                    const titleColumn = document.createElement("td");
                    const categoryName = post.category
                        ? post.category.name
                        : "Uncategorized";
                    titleColumn.innerHTML = `
                    <button class="btn btn-primary m-1 post_category" data-category="${categoryName}">
                        ${categoryName}
                    </button>
                    ${post.title}
                `;

                    const authorColumn = document.createElement("td");
                    authorColumn.textContent = post.user.name;

                    const actionsColumn = document.createElement("td");
                    actionsColumn.classList.add("text-left");
                    actionsColumn.innerHTML = `
                    <a href="/posts/${post.id}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Voir
                    </a>
                    ${
                        post.user_id === currentUserId
                            ? `
                    <a href="/posts/${post.id}/edit" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="/posts/${post.id}" method="POST" class="d-inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>`
                            : ""
                    }
                    <button class="btn btn-outline-danger btn-sm like-btn ${
                        post.likes.some(
                            (like) => like.user_id === currentUserId
                        )
                            ? "liked"
                            : ""
                    }" data-post-id="${post.id}">
                        <i class="fas fa-heart"></i>
                        <span class="like-count">${post.likes.length}</span>
                    </button>
                `;

                    row.appendChild(imageColumn);
                    row.appendChild(titleColumn);
                    row.appendChild(authorColumn);
                    row.appendChild(actionsColumn);

                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML =
                    "<p class='text-danger'>Aucun article trouvé.</p>";
            }

            searchResults.appendChild(tableContainer);
        })
        .catch((error) => {
            console.error("Error fetching posts:", error);
            alert("Une erreur est survenue lors de la recherche.");
        });

    searchInput.value = "";
});

const profileImages = document.querySelectorAll(".profile_image");

profileImages.forEach((profileImage) => {
    profileImage.addEventListener("click", () => {
        window.location.href = "/profile";
    });
});
