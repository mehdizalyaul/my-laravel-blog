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
        .then((response) => response.json())
        .then((data) => {
            const resultsContainer = document.querySelector(".table_container");
            resultsContainer.innerHTML = ""; // Clear previous results

            if (data.success && data.posts.length > 0) {
                data.posts.forEach((post) => {
                    console.log(post);

                    resultsContainer.innerHTML += `
                    <tr class="post_item" data-post-id="${post.id}">
                        <td>
                            ${
                                post.image
                                    ? `<div class="text-center my-3">
                                    <img src="storage/${post.image}" class="img-fluid rounded shadow-sm" style="width: 60px; height: 60px;">
                                </div>`
                                    : `<div class="text-center my-3">
                                    <img src="images/default-image.webp" class="img-fluid rounded shadow-sm" style="width: 60px; height: 60px;">
                                </div>`
                            }
                        </td>
                        <td>
                            <button class="btn btn-primary m-1 post_category" data-category="${
                                post.category
                                    ? post.category.name
                                    : "Uncategorized"
                            }">
                                ${
                                    post.category
                                        ? post.category.name
                                        : "Uncategorized"
                                }
                            </button>
                            ${post.title}
                        </td>
                        <td>${post.user.name}</td>
                        <td class="text-left">
                            <a href="/posts/${
                                post.id
                            }" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Voir
                            </a>

                            ${
                                post.user_id === currentUserId
                                    ? `<a href="/posts/${post.id}/edit" class="btn btn-warning btn-sm">
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
                                <span class="like-count">${
                                    post.likes.length
                                }</span>
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                resultsContainer.innerHTML =
                    "<p class='text-danger'>Aucun article trouvé.</p>";
            }
        });

    searchInput.value = "";
});
