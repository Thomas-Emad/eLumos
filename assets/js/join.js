/* Show right form */
const buttonType = document.querySelectorAll('.types span');

buttonType.forEach(button => {
    button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');
        const forms = document.querySelectorAll(`.form`);
        const labels = document.querySelectorAll(`.types .button`);
        const form = document.querySelector(`.form-${type}`);

        /* Remove Class Active from all */
        forms.forEach(form => {
            form.classList.remove('active');
        })
        labels.forEach(label => {
            label.classList.remove('active');
        })

        form.classList.toggle('active');
        button.classList.toggle('active');
    });
})
