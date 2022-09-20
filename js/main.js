import Carousel from "carousel.js";
import {openModal} from "modalbox"


document.addEventListener('DOMContentLoaded', function() {
  new Carousel(document.querySelector("#carousel"), {
      slidesToScroll: 10,
      slidesVisible: 10,
      pagination: true
  })
})

document.querySelectorAll('.js-modal').forEach(a => {
  a.addEventListener('click', openModal)
})