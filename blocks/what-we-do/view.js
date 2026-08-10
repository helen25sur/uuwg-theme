document.addEventListener('DOMContentLoaded', function () {

  const accordions = document.querySelectorAll('[data-uuwg-accordion]');

  accordions.forEach(function (accordion) {
    const cards = accordion.querySelectorAll('.uuwg-what-we-do__card');

    function activateCard(targetCard) {
      cards.forEach(function (card) {
        card.classList.toggle('is-active', card === targetCard);
      });
    }

    cards.forEach(function (card) {

      card.addEventListener('click', function () {
        // Клік на вже відкриту картку — нічого не робимо
        // (принаймні одна картка завжди лишається відкритою,
        // це узгоджується з тим, що на макеті перша картка
        // відкрита за замовчуванням, а не всі закриті одразу)
        if (!card.classList.contains('is-active')) {
          activateCard(card);
        }
      });
    });
  });

});