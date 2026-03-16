document.addEventListener("DOMContentLoaded", function () {
  const favBtns = document.querySelectorAll(".fav-btn");
  let favorites = JSON.parse(localStorage.getItem("favorites") || "[]");

  favBtns.forEach(btn => {
    const id = btn.dataset.productId;
    const icon = btn.querySelector(".fav-icon");

    // 初期状態
    if (favorites.includes(id)) {
      btn.classList.add("is-active");
      icon.textContent = "♥";
    } else {
      icon.textContent = "♡";
    }

    // クリック動作
    btn.addEventListener("click", e => {
      e.preventDefault();
      btn.classList.toggle("is-active");

      if (btn.classList.contains("is-active")) {
        icon.textContent = "♥";
        if (!favorites.includes(id)) favorites.push(id);
      } else {
        icon.textContent = "♡";
        favorites = favorites.filter(f => f !== id);
      }

      localStorage.setItem("favorites", JSON.stringify(favorites));
    });
  });
});
$(function(){

  const area = $('.recently-slider');

  let history = [];
  try {
    history = JSON.parse(localStorage.getItem('recentItems') || '[]');
  } catch(e){}

  if (!history.length){
    $('.recently-viewed').hide();
    return;
  }

  let html = '';
  history.forEach(item => {
    html += `
      <div class="item">
        <a href="${item.url}">
          <img src="${item.image}">
          <h3>${item.title}</h3>
        </a>
      </div>`;
  });

  area.html(html);

  setTimeout(function(){

    area.slick({
      arrows:true,
      dots:false,
      infinite:false,
      slidesToShow:4,
      responsive:[
        { breakpoint:1024, settings:{slidesToShow:3}},
        { breakpoint:768, settings:{slidesToShow:2.2,arrows:false}},
        { breakpoint:560, settings:{slidesToShow:1.4,arrows:false}}
      ]
    });

  },100);

});

$(function(){

  const area = $(".recommend-slider");
  const itemId = "{block:ItemPage}{ItemId}{/block:ItemPage}";

  if(!itemId) return;

  $.ajax({
    url: "https://starringwhite.navi.jpn.com/api/recommend-items",
    dataType: "jsonp",
    data: { item_id: itemId },
    success: function(items){

      if(!items || !items.length){
        $(".recommend-viewed").hide();
        return;
      }

      let html = "";
      items.forEach(item=>{
        html += `
          <div class="item">
            <a href="${item.url}">
              <img src="${item.image_url}">
              <h3>${item.title}</h3>
            </a>
          </div>`;
      });

      area.html(html);

      setTimeout(()=>{
        area.slick({
          slidesToShow:4,
          arrows:true,
          infinite:false,
          responsive:[
            { breakpoint:1024, settings:{slidesToShow:3}},
            { breakpoint:768, settings:{slidesToShow:2.2,arrows:false}},
            { breakpoint:560, settings:{slidesToShow:1.4,arrows:false}}
          ]
        });
      },100);

    }
  });

});