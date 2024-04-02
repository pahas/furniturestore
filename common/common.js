window.basket = {
  items: [],
  observers: [],
  add: function (id) {
    this.items.push(id);
    this.update();
  },
  remove: function (requiredIndex) {
    this.items = this.items.filter(function (item, index) {
      return index !== requiredIndex;
    });
    this.update();
  },
  update: function () {
    localStorage.setItem("basket", JSON.stringify(this.items));
    this.notifyObservers();
  },
  addObserver: function (observer) {
    this.observers.push(observer);
  },
  removeObserver: function (observer) {
    this.observers = this.observers.filter(function (obs) {
      return obs !== observer;
    });
  },
  notifyObservers: function () {
    this.observers.forEach(function (observer) {
      observer.update();
    });
  },
  init: function () {
    this.items = JSON.parse(localStorage.getItem("basket")) || [];
    this.update();
  },
  clear: function () {
    this.items = [];
    this.update();
  },
};

window.basket.init();

async function renderBasketItems(items) {
  //items: number[]

  var responses = [];

  for (var i = 0; i < items.length; i++) {
    var id = items[i];
    var response = await fetch(
      "http://localhost/api.php?method=get-item&id=" + id
    );
    responses.push(await response.json());
  }

  var htmlChildren = "";

  function prettyPrint(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
  }

  for (var i = 0; i < responses.length; i++) {
    var item = responses[i];
    if (item.error) {
      window.basket.remove(i);
    } else
      htmlChildren += `
      <div
      class="overflow-hidden flex flex-row"
      style="justify-content: center; align-items: center"
      >
      <div class="font-bold text-lg mb-1 mx-2">${i + 1}.</div>
      <div class="w-full md:w-1/3 px-4 py-4 md:p-0">
          <img
          style="max-width: 64px; max-height: 64px; border-radius: 4px"
          src="${item.photo}"
          />
      </div>
      <div class="w-full pl-3">
          <div class="font-bold text-lg mb-1">${item.title}</div>
          <p class="text-gray-700 text-sm mb-1">Цена: ${prettyPrint(
            item.price
          )} руб.</p>
      </div>

      <i
          class="fas fa-trash-alt"
          style="
          height: max-content;
          margin-left: 12px;
          margin-right: 6px;
          cursor: pointer;
          "
          onClick="window.basket.remove(${i})"
      ></i>
      </div>
      `;
  }

  console.log(htmlChildren.length);
  $("#basket-items").html(htmlChildren);

  if (htmlChildren.length === 0) {
    $("#basket-items").html(
      `<div class="text-center text-2xl font-bold">Корзина пуста</div>`
    );
    $("#basket-buy").hide();
  } else $("#basket-buy").show();
}

$(document).ready(function () {
  $("#basket").on("click", function () {
    console.log("basket clicked");
  });

  window.basket.addObserver({
    update: function () {
      console.log("Basket updated");
      $("#basket").text(window.basket.items.length);
      renderBasketItems(window.basket.items);
    },
  });

  $("#basket").text(window.basket.items.length);
  renderBasketItems(window.basket.items);
});

window.handleBuy = function () {
  //push to /cart.php?ids=1,2,3
  var ids = window.basket.items.join(",");
  window.location.href = "/cart.php?ids=" + ids;
};
