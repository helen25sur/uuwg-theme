(function (blocks, element, blockEditor, components, i18n, data) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  // ДОДАНО: ToggleControl
  const { PanelBody, TextControl, ToggleControl, Spinner } = components;
  const { __, sprintf } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/our-projects', {
    edit: function (props) {
      const { attributes, setAttributes } = props;
      // ДОДАНО: showPagination
      const { heading, buttonText, buttonUrl, countOfProjects, showPagination, showHeaderButton } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-our-projects alignfull' });

      const { projects, totalPages } = useSelect(
        function (select) {
          const query = { per_page: countOfProjects, _embed: true };
          return {
            projects: select('core').getEntityRecords('postType', 'project', query),
            totalPages: select('core').getEntityRecordsTotalPages('postType', 'project', query) || 1,
          };
        },
        [countOfProjects]
      );

      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Block Settings', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Кількість проєктів', 'uuwg'),
            type: 'number',
            value: countOfProjects,
            min: 1,
            max: 12,
            onChange: (v) => setAttributes({ countOfProjects: parseInt(v, 10) || 1 }),
          }),
          // ДОДАНО: Перемикач пагінації
          el(ToggleControl, {
            label: __('Показувати пагінацію', 'uuwg'),
            checked: showPagination,
            onChange: (v) => setAttributes({ showPagination: v }),
          }),
          // ТОГЛЕР КНОПКИ
          el(ToggleControl, {
            label: __('Show header button', 'uuwg'),
            checked: showHeaderButton,
            onChange: (v) => setAttributes({ showHeaderButton: v }),
          }),
          // ПІДКАЗКА: Ховаємо Button URL, якщо кнопка вимкнена
          showHeaderButton && el(TextControl, {
            label: __('Button URL', 'uuwg'),
            value: buttonUrl,
            onChange: (v) => setAttributes({ buttonUrl: v }),
          })
        )
      );

      // Формування сітки проєктів (залишається без змін)
      let projectsGrid;
      if (projects === null) {
        projectsGrid = el('div', { className: 'uuwg-our-projects__loading' }, el(Spinner), ' ', __('Завантаження...', 'uuwg'));
      } else if (projects.length === 0) {
        projectsGrid = el('p', { className: 'uuwg-our-projects__empty' }, __('Не знайдено.', 'uuwg'));
      } else {
        projectsGrid = projects.map(function (project) {
          const media = project._embedded && project._embedded['wp:featuredmedia'] && project._embedded['wp:featuredmedia'][0];
          const imageUrl = media ? (media.media_details?.sizes?.medium?.source_url || media.source_url) : null;
          return el(
            'div', { className: 'uuwg-our-projects__card', key: project.id },
            imageUrl && el('img', { src: imageUrl, alt: project.title.rendered, className: 'uuwg-our-projects__card-img' }),
            el('div', { className: 'uuwg-our-projects__card__content' },
              el('h3', { className: 'uuwg-our-projects__card__title', dangerouslySetInnerHTML: { __html: project.title.rendered } }),
              el('span', { className: 'uuwg-our-projects__card__button wp-element-button' }, __('Read more', 'uuwg'))
            )
          );
        });
      }

      // ЗМІНЕНО: Додана перевірка на showPagination
      const paginationButtons = [];
      if (showPagination && totalPages > 1) {
        for (let i = 1; i <= totalPages; i++) {
          paginationButtons.push(
            el('button', {
              key: i,
              type: 'button',
              className: 'uuwg-pagination-btn' + (i === 1 ? ' is-active' : ''),
              'aria-label': sprintf(__('Сторінка %d', 'uuwg'), i),
              'data-page': i,
            }, i)
          );
        }
      }

      return el(
        'div',
        blockProps,
        inspector,
        el(
          'div', { className: 'uuwg-our-projects__content' },
          el('div', { className: 'uuwg-our-projects__header' },
            el(RichText, { tagName: 'h2', className: 'uuwg-our-projects__heading', value: heading, onChange: (v) => setAttributes({ heading: v }), placeholder: __('Заголовок...', 'uuwg') }),
            showHeaderButton && el(RichText, { tagName: 'span', className: 'uuwg-our-projects__cta uuwg-btn', value: buttonText, onChange: (v) => setAttributes({ buttonText: v }), placeholder: __('Текст кнопки...', 'uuwg') })
          ),
          el('div', { className: 'uuwg-our-projects__grids js-projects-grid' }, projectsGrid),
          // ЗМІНЕНО: Контейнер пагінації рендериться лише якщо вона увімкнена
          showPagination && el('div', { className: 'uuwg-our-projects__pagination js-projects-pagination' }, paginationButtons)
        )
      );
    },
    save: function () { return null; },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.i18n,
  window.wp.data
);