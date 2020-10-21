
// FUNCTIONS //
const main = () =>
{
    // Confirm del
    $('.deletebutton').on("click", () => confirm('Voulez vous vraiment le supprimer ?'));

    // Article Read More
    $('[data-modal-target]').each((i, button) => {
        button.addEventListener('click', () => {
            modal = $(button.dataset.modalTarget);
            popModal(modal);
            const title = $(button).siblings('h2').html();
            const content = $(button).siblings('p').html();
            $('#modal-content').html(content);
            $('#modal-title').html(title);
        });
    });
    $('[data-close-button]').on('click', (button) => {
            modal = $("#modal");
            closeModal(modal);
    });
}


const popModal = (modal) =>
{
    if(modal == null) return false;
    modal.addClass('main__section__modal--active')
    $('#overlay').addClass("main__section__overlay--active")
}
const closeModal = (modal) =>
{
    if(modal == null) return false;
    modal.removeClass('main__section__modal--active')
    $('#overlay').removeClass("main__section__overlay--active")

}

        //## BODY ##//
$(document).ready(() => {
    main();
});
