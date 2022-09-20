let modal = null
const focusableSelector= "button, a, input, textarea"
let focusables = []
let previouslyFocusedElement = null

export const openModal  = (e) => {
    e.preventDefault()
    modal = document.querySelector(e.target.getAttribute('href'))
    focusables = Array.from(modal.querySelectorAll(focusableSelector))
    previouslyFocusedElement = document.querySelector(':focus')
    modal.style.display = null
    focusables[0].focus()
    modal.removeAttribute('aria-hidden')
    modal.setAttribute('aria-modal', true)
    modal.addEventListener('click', closeModal)
    modal.querySelector('.js-modal-close').addEventListener('click', closeModal)
    modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation)
  }
  
  const closeModal = function (e) {
    if(modal === null) return
    if(previouslyFocusedElement !== null) previouslyFocusedElement.focus()
    e.preventDefault()
    modal.setAttribute('aria-hidden', true)
    modal.removeAttribute('aria-modal')
    modal.removeEventListener('click', closeModal)
    modal.querySelector('.js-modal-close').addEventListener('click', closeModal)
    modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation)
    const hideModal = function() {
        modal.style.display = "none"
        modal.removeEventListener('animationend', hideModal)
        modal = null
    }
    modale.addEventListener('animationend', hideModal)  
  }
  
  const stopPropagation = function (e) {
    e.stopPropagation() 
  }

  const focusInModal = function(e) {
    e.preventDefault()
    let index = focusables.findIndex(f=> f === modal.querySelector(':focus'))
    if(e.shiftKey === true) {
        index++
    } else {
        index--
    } 
    if(index < 0 ) {
        index = focusables.length - 1
    }
    if(index >= focusables.length) {
        index = 0
    }
    focusables[index].focus()

  }
  
  window.addEventListener('keydown', (e) => {
    if(e.key === "Escape" || e.key === 'Esc') {
      closeModal(e)
    }
    if(e.key === 'Tab' && modal!== null) {
        focusInModal(e)
    }
  })
  