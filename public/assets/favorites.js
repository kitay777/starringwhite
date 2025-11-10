/* ===============================
   favorites.js
   STARRING WHITE 用 お気に入り機能
=================================*/
document.addEventListener("DOMContentLoaded", function () {
  // --- 商品一覧・詳細ページのハート処理 ---
  const favBtns = document.querySelectorAll(".fav-btn");
  let favorites = JSON.parse(localStorage.getItem("favorites") || "[]");

  favBtns.forEach(btn => {
    const id = btn.dataset.productId;
    const title = btn.dataset.title;
    const price = btn.dataset.price;
    const image = btn.dataset.image;

    // 初期表示
    if (favorites.includes(id)) btn.classList.add("is-active");

    // クリック動作
    btn.addEventListener("click", e => {
      e.preventDefault();
      btn.classList.toggle("is-active");

      if (btn.classList.contains("is-active")) {
        if (!favorites.includes(id)) favorites.push(id);
        // 商品情報も保存
        localStorage.setItem(`fav_item_${id}`, JSON.stringify({ id, title, price, image }));
      } else {
        favorites = favorites.filter(f => f !== id);
        localStorage.removeItem(`fav_item_${id}`);
      }
      localStorage.setItem("favorites", JSON.stringify(favorites));
    });
  });

  // --- favorites.html ページ判定 ---
  if (document.body.classList.contains("favorites-page")) {
    const listEl = document.getElementById("favList");
    const emptyEl = document.getElementById("emptyMsg");
    const favs = JSON.parse(localStorage.getItem("favorites") || "[]");

    if (!favs.length) {
      emptyEl.style.display = "block";
      return;
    }

    favs.forEach(id => {
      const data = JSON.parse(localStorage.getItem(`fav_item_${id}`) || "{}");
      const image = data.image || "";
      const title = data.title || "商品名不明";
      const price = data.price || "";
      const link = `/items/${id}`;
      const card = `
        <a class="fav-item" href="${link}">
          <img src="${image}" alt="${title}">
          <h2>${title}</h2>
          <div class="price">${price}</div>
        </a>`;
      listEl.insertAdjacentHTML("beforeend", card);
    });
  }
});
