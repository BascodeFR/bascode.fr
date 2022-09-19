const openModal  = (e) => {
    e.preventDefault()
    e.target.getAttribute('href')
}

document.querySelectorAll('.js-modal').forEach(a => {
    a.addEventListener('click', openModal)
})