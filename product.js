var itemscards = document.getElementsByClassName("items-card");
var itemscount = 0;
function newsCarousel(num) {
  itemscount += num;
  if (itemscount >= itemscards.length) {
    itemscount = 0;
  }
  if (itemscount < 0) {
    itemscount = itemscards.length - 1;
  }
  for (let i = 0; i < itemscards.length; i++) {
    itemscards[i].style.display = "none";
  }
  itemscards[itemscount].style.display = "block";
}

newsCarousel(0);
setInterval(() => {
  newsCarousel(1);
}, 4500);


