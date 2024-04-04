(function(){
    document.addEventListener('DOMContentLoaded', function(){
        const spinner = document.querySelector('#spinner')
        const formulario = document.querySelector('#formulario')
        
        formulario.addEventListener('submit', function() {
            spinner.classList.remove('opacity-0', 'pointer-events-none')
        })
    })
})()